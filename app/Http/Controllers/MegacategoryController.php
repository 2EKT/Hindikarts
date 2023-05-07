<?php

namespace App\Http\Controllers;

use App\Models\Megacategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File; 
use Illuminate\Support\Facades\Hash;
use Auth;
use Mail;

class MegacategoryController extends Controller
{
    public function __construct()
    {
        date_default_timezone_set('Asia/Kolkata');
    }
    public function index()
    {
        return view('admin.megacategory.view');
    }

    public function create()
    {
        return view('admin.megacategory.create');
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

    
    
    public function store(Request $request)
    {
        $validated = $request->validate([
            'image' => 'required|image|mimes:jpg,png,jpeg,gif,svg,webp|max:1000',
        ]);
        $imageName = date('Ymdhis').'.'.request()->image->getClientOriginalExtension();
        request()->image->move(public_path('category_image'), $imageName);

        $megacategory=New Megacategory;
        $megacategory->cat_id = $request->cat_id;
        $megacategory->subcat_id = $request->subcat_id;
        $megacategory->megacategory = $request->megacategory;
        $megacategory->image = $imageName;
       
        if($megacategory->save())
        {
            return redirect('/admin/megacategory/create')->with('success', 'Inserted Successfully');
        }
        else
        {
            return redirect('/admin/megacategory/create')->with('error', 'Something Went Wrong');
        }
    }

   
    public function show(Megacategory $megacategory)
    {
        //
    }

    
    public function edit(Megacategory $megacategory)
    {
        return view('admin.megacategory.update',compact('megacategory'));
    }

    
    public function update(Request $request, Megacategory $megacategory)
    {
        if($request->hasFile('image'))
        {
             $validated = $request->validate([
                 'image' => 'required|image|mimes:jpg,png,jpeg,gif,svg,webp|max:1000',
             ]);
             $imageName = date('Ymdhis').'.'.request()->image->getClientOriginalExtension();
             request()->image->move(public_path('category_image'), $imageName);
            
             $previous_path=public_path().'/category_image/'.$request->previous_image;
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

        $megacategory->cat_id = $request->cat_id;
        $megacategory->subcat_id = $request->subcat_id;
        $megacategory->megacategory = $request->megacategory;
        $megacategory->image = $imageName;

        if($megacategory->save())
        {
            return redirect('/admin/megacategory/'.$megacategory->id.'/edit')->with('success', 'Updated Successfully');
        }
        else
        {
            return redirect('/admin/megacategory/'.$megacategory->id.'/edit')->with('error', 'Something Went Wrong');
        }
    }

  
    public function destroy(Megacategory $megacategory)
    {
        $previous_path=public_path().'/category_image/'.$megacategory->image;
        if($megacategory->image!='')
        {
            if(File::exists($previous_path)){
                unlink($previous_path);
            }
        } 
        if ($megacategory->delete()) {
            return redirect('/admin/megacategory/')->with('success', 'Deleted Successfully');
        }
    }
}