<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;
use App\Traits\ApiResponse;

class ParcelRequest extends FormRequest
{
    use ApiResponse;
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {

        if ($this->isMethod('PUT')) {
            $rules = [
                'weight' => 'required|numeric|min:0.1',
                'amount' => 'required|numeric|min:0',
                // Add more validation rules for other parcel attributes as needed
            ];
        } else {
            $rules = [
                'weight' => 'required|numeric|min:0.1',
                'amount' => 'required|numeric|min:0',
                'pickup_name' => 'required|string|max:100',
                'pickup_phone' => 'required|string|max:20',
                'pickup_city' => 'required|string|max:100',
                'pickup_address' => 'required|string|max:1000',
                'delivery_name' => 'required|string|max:100',
                'delivery_phone' => 'required|string|max:20',
                'delivery_city' => 'required|string|max:100',
                'delivery_address' => 'required|string|max:1000',
                // Add more validation rules for other parcel attributes as needed
            ];
        }

        return $rules;
    }

    public function failedValidation(Validator $validator)
    {
        $this->httpError("Validation errors" ,401, $validator->errors());
    }
}


