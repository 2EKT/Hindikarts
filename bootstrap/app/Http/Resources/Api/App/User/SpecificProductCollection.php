<?php

namespace App\Http\Resources\Api\App\User;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\ProductDetails;
use App\Models\ProductColor;
use App\Models\Rating;
use App\Http\Resources\Api\App\User\ProductColorCollection;

class SpecificProductCollection extends JsonResource
{
   
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    { 
        $user_id = $request->user_id;
        $productDetails = ProductDetails::where('product_id', $this->id)->first();
        $rating = Rating::where(['product_id' => $this->id, 'user_id' => $user_id])->first();
        $sizes = ProductDetails::where(['product_id' => $this->id, 'attr_type' => 'Size'])->select('id', 'attr_value', 'market_price', 'sale_price')->get();
        $colors = ProductColor::where('product_id', $this->id)->get();
       
        return [
            'id' => $this->id,
            'product_name' => $this->title,
            'rating' => !empty($rating) ? $rating->rating : '',
            'merchent_name' => !empty($this->merchant_name) ? $this->merchant_name: '',
            'sizes' => $sizes,
            'colors' => ProductColorCollection::collection($colors),
            // 'price' => !empty($productDetails) ? $productDetails->market_price : '',
            // 'sell_price' => !empty($productDetails) ? $productDetails->sale_price : '',
            'main_image' => $this->main_image,
            'title' => $this->title
        ];
    }

    public function twoDecimalPoint($number){
        return number_format((float)$number, 2, '.', '');
    }
}