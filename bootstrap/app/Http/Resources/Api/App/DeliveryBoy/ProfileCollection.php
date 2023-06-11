<?php

namespace App\Http\Resources\Api\App\DeliveryBoy;

use Illuminate\Http\Resources\Json\JsonResource;

class ProfileCollection extends JsonResource
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
            'name' => $this->name,
            'email' => $this->email ,
            'phone' => $this->phone ,
            'father_name' => $this->father_name ?? '',
            'city' => $this->city ?? '',
            'address' => $this->address ?? '',
            'lang' => $this->lang ?? '',
            'image' => !empty($this->image) ? \asset('delivery_boy_image/'.$this->image) : '',
        ];
    }
}