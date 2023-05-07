<?php

namespace App\Http\Resources\Api\App\User;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\Product;
use App\Models\User;

class RatingCollection extends JsonResource
{
   
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {   
        $product = Product::find($this->product_id);
        $user = User::find($this->user_id);

        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'product_id' => $this->product_id,
            'product_name' => !empty($product) ? $product->title : '',
            'user_name' => !empty($user) ? $user->name : '',
            'review' => !empty($this->review) ? $this->review : '',
            'rating' => !empty($this->rating) ? $this->rating : '',
            'date' => date('d.m.Y', strtotime($this->created_at))
        ];
    }
}