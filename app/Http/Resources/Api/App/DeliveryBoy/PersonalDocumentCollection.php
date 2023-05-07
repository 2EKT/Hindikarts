<?php

namespace App\Http\Resources\Api\App\DeliveryBoy;

use Illuminate\Http\Resources\Json\JsonResource;

class PersonalDocumentCollection extends JsonResource
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
            'type ' => $this->type ,
            'card_number ' => $this->card_number ,
            'image' => !empty($this->image) ? \URL::asset('public/personal_documents_image/'.$this->image) : '',
            'front_image' => !empty($this->front_image) ? \URL::asset('public/personal_documents_image/'.$this->front_image) : '',
            'back_image' => !empty($this->back_image) ? \URL::asset('public/personal_documents_image/'.$this->back_image) : '',
        ];
    }
}