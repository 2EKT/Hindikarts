<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductDetails;
use App\Models\ProductColor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File; 
use Illuminate\Support\Facades\Hash;
use Auth;
use Mail;

class ProductController extends Controller
{
    public function __construct()
    {
        date_default_timezone_set('Asia/Kolkata');
    }
    public function index()
    {
        return view('merchant.product.view');
    }

   
    public function create()
    {
        return view('merchant.product.create');
    }

    public function get_subcategory(Request $request)
    {
        $category=$request->category;
        $row=DB::table('subcategories')->where('cat_id','=',$category)->get();
        
        foreach($row as $details)
        {
            echo "<option value=".$details->id.">".$details->subcategory."</option>";            
            
        }
    }
    public function get_megacategory(Request $request)
    {
        $subcat_id=$request->subcat_id;
        $row=DB::table('megacategories')->where('subcat_id','=',$subcat_id)->get();
        
        foreach($row as $details)
        {
            echo "<option value=".$details->id.">".$details->megacategory."</option>";            
            
        }
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'image' => 'required|image|mimes:jpg,png,jpeg,gif,svg,webp|max:1000',
        ]);

        $imageName = date('Ymdhis').rand(111,999).'.'.request()->image->getClientOriginalExtension();
        request()->image->move(public_path('product_image'), $imageName);

        if($request->hasFile('img1'))
           {
                $validated = $request->validate([
                    'img1' => 'required|image|mimes:jpg,png,jpeg,gif,svg,webp|max:1000',
                ]);
                $img1 = date('Ymdhis').rand(111,999).'.'.request()->img1->getClientOriginalExtension();
                request()->img1->move(public_path('product_image'), $img1);
           }
           else{
            $img1="";
           }
        if($request->hasFile('img2'))
           {
                $validated = $request->validate([
                    'img2' => 'required|image|mimes:jpg,png,jpeg,gif,svg,webp|max:1000',
                ]);
                $img2 = date('Ymdhis').rand(111,999).'.'.request()->img2->getClientOriginalExtension();
                request()->img2->move(public_path('product_image'), $img2);
           }
           else{
            $img2="";
           }
        if($request->hasFile('img3'))
           {
                $validated = $request->validate([
                    'img3' => 'required|image|mimes:jpg,png,jpeg,gif,svg,webp|max:1000',
                ]);
                $img3 = date('Ymdhis').rand(111,999).'.'.request()->img3->getClientOriginalExtension();
                request()->img3->move(public_path('product_image'), $img3);
           }
           else{
            $img3="";
           }
        if($request->hasFile('img4'))
           {
                $validated = $request->validate([
                    'img4' => 'required|image|mimes:jpg,png,jpeg,gif,svg,webp|max:1000',
                ]);
                $img4 = date('Ymdhis').'.'.request()->img4->getClientOriginalExtension();
                request()->img4->move(public_path('product_image'), $img4);
           }
           else{
            $img4="";
           }

           try{
               DB::beginTransaction();

                $merchant_id = Auth::guard('merchant')->user()->id;

                $product = Product::create([
                    'cat_id' => $request->cat_id,
                    'subcat_id' => $request->subcat_id,
                    'megacat_id' => $request->megacat_id,
                    'merchant_id' => $merchant_id,
                    'shop_id' => $request->shop_id,
                    'title' => $request->title,
                    'market_price' => $request->product_market_price,
                    'sale_price' => $request->product_sale_price,
                    'discount' => $request->product_discount,
                    'discount_type' => $request->product_discount_type,
                    'main_image' => $imageName,
                    'description' => $request->description,
                    //'colors' => $request->colors,
                    'active' => 'YES',
                    'img1' => $img1,
                    'img2' => $img2,
                    'img3' => $img3,
                    'img4' => $img4,
                ]);

                if(!empty($product))
                {
                    if(!empty($request->attr_value)){
                        $attr_value = $request->attr_value;
                        foreach($attr_value as $key => $attr_value_details)
                        {
                            ProductDetails::create([
                                'product_id'=>$product->id,
                                'attr_type'=>$request->attr_type,
                                'attr_value'=>$attr_value_details,
                                'market_price'=>$request->market_price[$key],
                                'sale_price'=>$request->sale_price[$key],
                                'stock'=>$request->stock[$key]
                            ]);
                        }
                    }

                    if(!empty($request->colors)){
                        $colors = $request->colors;
                        $color_images = $request->color_images;
                        $valid_image_formats = ['jpg','png','jpeg','gif','svg','webp'];

                        foreach($colors as $key => $color)
                        {
                            $color_image = $color_images[$key];
                            if(!empty($color_image) && !empty($color))
                            {
                                $valid_image_size =  $this->getUploadedImageSize('color_images', $key);
                                $extention = $color_image->getClientOriginalExtension();
                                $existing_color = ProductColor::where(['merchant_id' => $merchant_id, 'color' => $color])->exists();
                                
                                if($valid_image_size && !$existing_color && in_array($extention, $valid_image_formats)){
                                    $image = date('Ymdhis').rand(111,999).'.'.$extention;
                                    $color_image->move(public_path('product_image'), $image);

                                    ProductColor::create([
                                        'product_id'=>$product->id,
                                        'merchant_id'=>$product->merchant_id,
                                        'color'=>$color,
                                        'image'=>$image
                                    ]);
                                }
                            }
                        }
                    }
                }

               DB::commit();
               return redirect('/merchant/product/create')->with('success', 'Inserted Successfully');
            
           }
           catch(\Exception $e){  
            DB::rollBack();
            //throw new $e;
            return redirect('/merchant/product/create')->with('error', 'Something Went Wrong');
        }
    }

    
    public function show(Product $product)
    {
        //
    }

  
    public function edit(Product $product)
    {
        $product=Product::find($product->id);
        if(empty($product))
        {
            return redirect('/merchant/product/');
        }
        return view('merchant.product.update',compact('product'));
    }

    
    public function update(Request $request, Product $product)
    {
        if($request->hasFile('image'))
           {
                $validated = $request->validate([
                    'image' => 'required|image|mimes:jpg,png,jpeg,gif,svg,webp|max:1000',
                ]);
                $imageName = date('Ymdhis').rand(111,999).'.'.request()->image->getClientOriginalExtension();
                request()->image->move(public_path('product_image'), $imageName);
               
                $previous_path=public_path().'/product_image/'.$request->previous_image;
                if($request->previous_image!='')
                {
                    if(File::exists($previous_path)){
                        unlink($previous_path);
                    }
                } 
           }
           else
           {
                $imageName=$request->previous_image;
           }

           if($request->hasFile('img1'))
           {
                $validated = $request->validate([
                    'img1' => 'required|image|mimes:jpg,png,jpeg,gif,svg,webp|max:1000',
                ]);
                $img1 = date('Ymdhis').rand(111,999).'.'.request()->img1->getClientOriginalExtension();
                request()->img1->move(public_path('product_image'), $img1);
               
                $previous_path=public_path().'/product_image/'.$request->previous_img1;
                if($request->previous_image!='')
                {
                    if(File::exists($previous_path)){
                        unlink($previous_path);
                    }
                } 
           }
           else
           {
                $img1=$request->previous_img1;
           }


           if($request->hasFile('img2'))
           {
                $validated = $request->validate([
                    'img2' => 'required|image|mimes:jpg,png,jpeg,gif,svg,webp|max:1000',
                ]);
                $img2 = date('Ymdhis').rand(111,999).'.'.request()->img2->getClientOriginalExtension();
                request()->img2->move(public_path('product_image'), $img2);
               
                $previous_path=public_path().'/product_image/'.$request->previous_img2;
                if($request->previous_image!='')
                {
                    if(File::exists($previous_path)){
                        unlink($previous_path);
                    }
                } 
           }
           else
           {
                $img2=$request->previous_img2;
           }

           if($request->hasFile('img3'))
           {
                $validated = $request->validate([
                    'img3' => 'required|image|mimes:jpg,png,jpeg,gif,svg,webp|max:1000',
                ]);
                $img3 = date('Ymdhis').rand(111,999).'.'.request()->img3->getClientOriginalExtension();
                request()->img3->move(public_path('product_image'), $img3);
               
                $previous_path=public_path().'/product_image/'.$request->previous_img3;
                if($request->previous_image!='')
                {
                    if(File::exists($previous_path)){
                        unlink($previous_path);
                    }
                } 
           }
           else
           {
                $img3=$request->previous_img3;
           }

           if($request->hasFile('img4'))
           {
                $validated = $request->validate([
                    'img4' => 'required|image|mimes:jpg,png,jpeg,gif,svg,webp|max:1000',
                ]);
                $img4 = date('Ymdhis').rand(111,999).'.'.request()->img4->getClientOriginalExtension();
                request()->img4->move(public_path('product_image'), $img4);
               
                $previous_path=public_path().'/product_image/'.$request->previous_img4;
                if($request->previous_image!='')
                {
                    if(File::exists($previous_path)){
                        unlink($previous_path);
                    }
                } 
           }
           else
           {
                $img4=$request->previous_img4;
           }

           try{
                DB::beginTransaction();

                $merchant_id = Auth::guard('merchant')->user()->id;

                Product::where('id', $product->id)->update([
                    'cat_id' => $request->cat_id,
                    'subcat_id' => $request->subcat_id,
                    'megacat_id' => $request->megacat_id,
                    'merchant_id' => $merchant_id,
                    'shop_id' => $request->shop_id,
                    'title' => $request->title,
                    'market_price' => $request->product_market_price,
                    'sale_price' => $request->product_sale_price,
                    'discount' => $request->product_discount,
                    'discount_type' => $request->product_discount_type,
                    'main_image' => $imageName,
                    'description' => $request->description,
                    //'colors' => $request->colors,
                    'active' => 'YES',
                    'img1' => $img1,
                    'img2' => $img2,
                    'img3' => $img3,
                    'img4' => $img4,
                ]);

                 if(!empty($request->attr_value)){
                    $existing_detail_ids =  ProductDetails::where('product_id', $product->id)->pluck('id')->toArray();
                    $attr_value = $request->attr_value; 
                    $detail_length = count($existing_detail_ids) >= count($attr_value) ? count($existing_detail_ids) : count($attr_value);
                    
                    for($detail_index = 0; $detail_index < $detail_length; $detail_index++){
                        if(!empty($existing_detail_ids[$detail_index])){ 
                            $product_details_id = $existing_detail_ids[$detail_index];  
                            
                            if(!empty($attr_value[$detail_index])){
                                ProductDetails::where('id', $product_details_id)->update(
                                    [
                                        'product_id'=>$product->id,
                                        'attr_type'=>$request->attr_type,
                                        'attr_value'=>$attr_value[$detail_index],
                                        'market_price'=>$request->market_price[$detail_index],
                                        'sale_price'=>$request->sale_price[$detail_index],
                                        'stock'=>$request->stock[$detail_index]
                                    ]
                                );
                            }
                            else{
                                ProductDetails::where('id', $product_details_id)->delete();
                            }
                        }
                        else{
                            ProductDetails::create(
                                [
                                    'product_id'=>$product->id,
                                    'attr_type'=>$request->attr_type,
                                    'attr_value'=>$attr_value[$detail_index],
                                    'market_price'=>$request->market_price[$detail_index],
                                    'sale_price'=>$request->sale_price[$detail_index],
                                    'stock'=>$request->stock[$detail_index]
                                ]
                            );
                        }
                    }
                }

                else{
                    ProductDetails::where('product_id', $product->id)->delete();
                }

                $existing_colors = ProductColor::where('product_id', $product->id)->select('id', 'color', 'image')->get()->toArray();

                if(!empty($request->colors)){
                    $colors = $request->colors;
                    $color_images = $request->color_images;
                    $valid_image_formats = ['jpg','png','jpeg','gif','svg','webp'];
                    $color_length = count($existing_colors) >= count($colors) ? count($existing_colors) : count($colors);

                    for($color_index = 0; $color_index < $color_length; $color_index++){
                       

                        if(empty($colors[$color_index]) && !empty($existing_colors[$color_index])){
                           $previous_path=public_path().'/product_image/'.$existing_colors[$color_index]['image'];

                           if(File::exists($previous_path)){
                            unlink($previous_path);
                           }
                           ProductColor::where('id', $existing_colors[$color_index]['id'])->delete();
                        }

                        else if(!empty($existing_colors[$color_index]) && !empty($colors[$color_index])){ 
                          $given_color = $colors[$color_index];
                          $existing_color = $existing_colors[$color_index]['color'];
                          $image = $existing_colors[$color_index]['image'];

                          $color_arr = [
                                    'product_id'=>$product->id,
                                    'merchant_id'=>$product->merchant_id,
                                    'color'=>$existing_color,
                                    'image'=>$image
                          ];

                          if(!empty($color_images[$color_index])){
                            $color_image = $color_images[$color_index];
                            $valid_image_size =  $this->getUploadedImageSize('color_images', $color_index);
                            $extention = $color_image->getClientOriginalExtension();

                            if($valid_image_size && in_array($extention, $valid_image_formats)){
                                $previous_path=public_path().'/product_image/'.$image;

                                if(File::exists($previous_path)){
                                    unlink($previous_path);
                                }

                                $image = date('Ymdhis').rand(111,999).'.'.$extention;
                                $color_image->move(public_path('product_image'), $image);
                                $color_arr['image'] = $image;
                            }
                          }

                          if($given_color != $existing_color) {
                              $color_arr['color'] = $given_color;
                          }
                          ProductColor::where('id', $existing_colors[$color_index]['id'])->update($color_arr);
                        }

                        else{
                            $saved_colors = array_column($existing_colors, 'color');
                            $given_color = $colors[$color_index];
                            
                            if(!empty($color_images[$color_index]) && !in_array($given_color, $saved_colors)){ 
                                $color_image = $color_images[$color_index];
                                $valid_image_size =  $this->getUploadedImageSize('color_images', $color_index);
                                $extention = $color_image->getClientOriginalExtension();
    
                                if($valid_image_size && in_array($extention, $valid_image_formats)){
                                    $image = date('Ymdhis').rand(111,999).'.'.$extention;
                                    $color_image->move(public_path('product_image'), $image);
                                    $color_arr = [
                                        'product_id'=>$product->id,
                                        'merchant_id'=>$product->merchant_id,
                                        'color'=>$given_color,
                                        'image'=>$image
                                     ];
                                }
                                ProductColor::create($color_arr);
                              }
                        }
                    }
                  }

                  else{
                       foreach($existing_colors as $existing_color){
                           $previous_path=public_path().'/product_image/'.$existing_color['image'];

                           if(File::exists($previous_path)){
                            unlink($previous_path);
                           }

                           ProductColor::where('id', $existing_color['id'])->delete();
                       }
                  }

                    DB::commit();
                    return redirect('/merchant/product/create')->with('success', 'Inserted Successfully');
                }
                catch(\Exception $e){  dd($e);
                DB::rollBack();
                //throw new $e;
                return redirect('/merchant/product/create')->with('error', 'Something Went Wrong');
            }
    }

  
    public function destroy(Product $product)
    {
        $arr=array(
            'active'=>'NO'
        );
        DB::table('products')->where('id','=',$product->id)->update($arr);
        
        return redirect('/merchant/product/')->with('success', 'Deleted Successfully');
        
    }

    public function getUploadedImageSize($image_key, $index){ 
         $size = (int)round($_FILES[$image_key]['size'][$index] / 1000);
         return ($size > 1000) ? false : true;
    }
}