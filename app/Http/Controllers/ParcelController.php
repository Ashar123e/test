<?php

namespace App\Http\Controllers;

use App\Http\Requests\ParcelRequest;
use App\Models\Parcel;
use App\Models\ParcelAddress;
use App\Models\User;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ParcelController extends Controller
{
    use ApiResponse;

    public function index(Request $request)
    {
        $limit = $request->query('limit') ?? 10;
        $parcels = Parcel::with('sender','biker')->orderBy('updated_at', 'desc')->paginate($limit);
        return $this->success($parcels, "Parcel List");
    }

    /**
     * Task 1
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'pickup_address' => 'required',
                'name' => 'required',
                'description' => '',
                'weight' => 'required',
                'amount' => ''
            ]);

            $parcel = new Parcel();
            $parcel->weight = $request->weight;
            $parcel->amount = $request->amount;
            $parcel->name = $request->name;
            $parcel->description = $request->description;
            $parcel->status = Parcel::PENDING;
            // $parcel->pickup_address = $request->pickup_address;
            // $parcel->dropoff_address = $request->dropoff_address;
            $parcel->sender_id = Auth::id();
            $parcel->save();

            $parcel->parcelAddress()->create([
                'pickup_address' => $request->pickup_address,
                'dropoff_address' => $request->dropoff_address,
            ]);

            /**
             * Maybe not needed
             */
            $parcel->loadMissing('parcelAddress');

            // $pickup = new ParcelAddress();
            // $pickup->parcel_id = $parcel->id;
            // $pickup->name = $request->pickup_name;
            // $pickup->email = $request->pickup_email;
            // $pickup->phone = $request->pickup_phone;
            // $pickup->city = $request->pickup_city;
            // $pickup->address = $request->pickup_address;
            // $pickup->type = "pickup";
            // $pickup->save();

            // $delivery = new ParcelAddress();
            // $delivery->parcel_id = $parcel->id;
            // $delivery->name = $request->delivery_name;
            // $delivery->email = $request->delivery_email;
            // $delivery->phone = $request->delivery_phone;
            // $delivery->city = $request->delivery_city;
            // $delivery->address = $request->delivery_address;
            // $delivery->type = "delivery";
            // $delivery->save();
            // $data = Parcel::with('pickup', 'delivery')->where('id', $parcel->id)->first();

            return $this->success($parcel);
        } catch (\Exception $exception) {
            return $this->error($exception->getMessage(), 501, $exception->getTrace());
        }
    }

    /**
     * Task 2 , 3
     */
    public function get(Request $request){

        $parcels = Parcel::when(Auth::user()->isSender(), function($query){
            $query->where('sender_id', Auth::id());
        })
        ->when(Auth::user()->isBiker(), function($query){
            $query->where('biker_id', Auth::id());
        })
        ->orderBy('updated_at', 'desc')
        ->paginate($request->query('limit') ?? 10);
        return $this->success($parcels);
    }

    public function show($id)
    {
        try {
            $parcel = Parcel::with('sender', 'biker')->where('id', $id)->first();
            if (!$parcel) {
                return $this->error("Parcel not Found", 404, []);
            }
            return $this->success($parcel);
        } catch (\Exception $exception) {
            return $this->error($exception->getMessage(), 501, $exception->getTrace());
        }
    }

    /**
     * Task 4, 5 , 6
     */
    public function pickupParcel(Parcel $parcel){
        
        // $request->validate([
        //     'parcel_id' => 'required'
        // ]);

        // $parcel = Parcel::find($request->parcel_id);

        if(!$parcel){
            return $this->error('Parcel not found');
        }

        if($parcel->isPicked()){
            return $this->error('Parcel already picked');
        }

        $parcel->biker_id = Auth::id();
        $parcel->status = Parcel::PICKED;
        $parcel->save();

        return $this->success($parcel, 'Parcel Picked successfully');



    }

    // public function update(ParcelRequest $request, $id)
    // {
    //     try {
    //         $request->validate();

    //         $parcel = Parcel::find($id);
    //         if (!$parcel) {
    //             return $this->error("Parcel not Found", 404, []);
    //         }
    //         $parcel->weight = $request->weight;
    //         $parcel->amount = $request->amount;
    //         $parcel->save();

    //         $pickup = ParcelAddress::where('parcel_id', $id)->where('type', 'pickup')->first();
    //         $pickup->name = !empty($request->pickup_name) ? $request->pickup_name : $pickup->name;
    //         $pickup->email = !empty($request->pickup_email) ? $request->pickup_email : $pickup->email;
    //         $pickup->phone = !empty($request->pickup_phone) ? $request->pickup_phone : $pickup->phone;
    //         $pickup->city = !empty($request->pickup_city) ? $request->pickup_city : $pickup->city;
    //         $pickup->address = !empty($request->pickup_address) ? $request->pickup_address : $pickup->address;
    //         $pickup->save();

    //         $delivery = ParcelAddress::where('parcel_id', $id)->where('type', 'delivery')->first();
    //         $delivery->name = !empty($request->delivery_name) ? $request->delivery_name : $delivery->name;
    //         $delivery->email = !empty($request->delivery_email) ? $request->delivery_email : $delivery->email;
    //         $delivery->phone = !empty($request->delivery_phone) ? $request->delivery_phone : $delivery->phone;
    //         $delivery->city = !empty($request->delivery_city) ? $request->delivery_city : $delivery->city;
    //         $delivery->address = !empty($request->delivery_address) ? $request->delivery_address : $delivery->address;
    //         $delivery->save();

    //         $data = Parcel::with('pickup', 'delivery')->where('id', $id)->first();

    //         return $this->success($data);
    //     } catch (\Exception $exception) {
    //         return $this->error($exception->getMessage(), 501, $exception->getTrace());
    //     }
    // }

    // public function destroy($id)
    // {
    //     $parcel = Parcel::find($id);
    //     if (!$parcel) {
    //         return $this->error("Parcel not Found", 404, []);
    //     }
    //     $parcel->delete();
    //     return $this->success([], "Parcel Deleted Successfully");
    // }
}
