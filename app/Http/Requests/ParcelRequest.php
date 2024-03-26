<?php

namespace App\Http\Requests;

class ParcelRequest extends Request
{
    public function rules(): array
    {
        return [
            'sender_name' => 'required|string',
            'sender_address' => 'required|string',
            'receiver_name' => 'required|string',
            'receiver_address' => 'required|string',
            'parcel_name' => 'required|string',
            'parcel_weight' => 'required|numeric',
            'post_service' => 'required|string',
        ];
    }
}
