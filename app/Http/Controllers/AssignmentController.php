<?php

namespace App\Http\Controllers;

use App\Models\Parcel;
use App\Models\ParcelStatus;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class AssignmentController extends Controller
{
    use ApiResponse;

    public function index(Request $request)
    {
        $pending_parcel_array = Parcel::where("status", "Pending")->get()->toArray();
        $other_parecel_array = Parcel::where("biker_id", $request->user()->id)->get()->toArray();

        $parcels = collect(array_merge($pending_parcel_array, $other_parecel_array));

        return $this->success($parcels, "Parcel List");
    }

    public function updateStatus(Request $request, $id)
    {
        try {
            $parcel = Parcel::find($id);
            $status = isset($request->status) ? $request->status : null;
            if (!$parcel) {
                return $this->error("Parcel not Found", 404, []);
            } elseif (!$status) {
                return $this->error("Status is required", 401, []);
            } elseif (ParcelStatus::select('name')->where('name', $status)->count() == 0) {
                return $this->error("Invalid Status, Not Allowed in Our System", 401, []);
            } elseif ($status == "Pickup" && !empty($parcel->biker_id)) {
                return $this->error("Parcel already in Use, Please Select Another Other", 401, []);
            } elseif ($status == "Delivery-In-Progress" && $parcel->status == "Delivered") {
                return $this->error("Parcel already in Delivered");
            } elseif (!empty($parcel->biker_id) && $parcel->biker_id != $request->user()->id) {
                return $this->error("You are not allowed to updated this parcel");
            }
            $parcel->status = $status;
            $parcel->biker_id = $request->user()->id;
            $parcel->save();

            return $this->success($parcel, "Parcel Updated Successfully");

        } catch (\Exception $exception) {
            return $this->error($exception->getMessage(), 501, $exception->getTrace());
        }
    }
}
