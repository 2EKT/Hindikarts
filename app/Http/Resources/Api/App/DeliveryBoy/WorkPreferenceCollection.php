<?php

namespace App\Http\Resources\Api\App\DeliveryBoy;

use Illuminate\Http\Resources\Json\JsonResource;

class WorkPreferenceCollection extends JsonResource
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
            'option ' => $this->option ,
        ];
    }
}