<?php

namespace App\Http\Resources\Api\App\User;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductColorCollection extends JsonResource
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
            'merchant_id' => $this->merchant_id,
            'product_id' => $this->product_id,
            'color' => $this->color,
            'image' => !empty($this->image) ? \URL::asset('public/product_image/'.$this->image) : '',
        ];
    }
}