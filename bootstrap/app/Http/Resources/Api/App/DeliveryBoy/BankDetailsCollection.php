<?php

namespace App\Http\Resources\Api\App\DeliveryBoy;

use Illuminate\Http\Resources\Json\JsonResource;

class BankDetailsCollection extends JsonResource
{
   
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {   
        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'bank_name' => $this->bank_name,
            'branch_name' => $this->branch_name,
            'account_holder' => $this->account_holder,
            'ifsc_code' => $this->ifsc_code,
            'account_no' => $this->account_no,
        ];
    }
}