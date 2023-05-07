<?php

namespace App\Http\Resources\Api\App\DeliveryBoy;

use Illuminate\Http\Resources\Json\JsonResource;

class TransactionCollection extends JsonResource
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
            'user_id'=> $this->user_id,
            'type' => $this->type,
            'amount' => (int) $this->amount,
            'date' => date('d.m.Y', strtotime($this->created_at))
        ];
    }
}