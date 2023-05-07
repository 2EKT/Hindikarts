<?php

namespace App\Http\Resources\Api\App\User;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\Merchant;

class FilterProductCollection extends JsonResource
{
   
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {  
        $merchant = Merchant::find($this->merchant_id);
        
        return [
            'id' => $this->id,
            'product_id' => $this->product_id,
            'merchent_name' => !empty($merchant) ? $merchant->name : '',
            'price' => !empty($this->market_price) ? $this->market_price : '',
            'sell_price' => !empty($this->market_price) ? $this->sale_price : '',
            'main_image' => !empty($this->main_image) ? $this->main_image : '',
            'title' => !empty($this->title) ? $this->title : '',
        ];
    }

    public function twoDecimalPoint($number){
        return number_format((float)$number, 2, '.', '');
    }
}