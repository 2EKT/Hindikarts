<?php

namespace App\Http\Resources\Api\App\User;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\ProductDetails;

class SearchProductCollection extends JsonResource
{
   
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    { 
        $productDetails = ProductDetails::where('product_id', $this->id)->first();
        
        return [
            'id' => $this->id,
            'merchent_name' => !empty($this->merchant_name) ? $this->merchant_name: '',
            'price' => !empty($productDetails) ? $productDetails->market_price : '',
            'sell_price' => !empty($productDetails) ? $productDetails->sale_price : '',
            'main_image' => $this->main_image,
            'title' => $this->title
        ];
    }

    public function twoDecimalPoint($number){
        return number_format((float)$number, 2, '.', '');
    }
}