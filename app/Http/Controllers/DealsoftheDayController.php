<?php

namespace App\Http\Controllers;

use App\Models\DealsoftheDay;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File; 
use Illuminate\Support\Facades\Hash;
use Auth;
use Mail;

class DealsoftheDayController extends Controller
{
    public function __construct()
    {
        date_default_timezone_set('Asia/Kolkata');
    }
    public function index()
    {
        return view('admin.dealsoftheday.view');
    }

    
    public function create()
    {
        return view('admin.dealsoftheday.create');
    }

    
    public function store(Request $request)
    {
        $validated = $request->validate([
            'image' => 'required|image|mimes:jpg,png,jpeg,gif,svg,webp|max:1000',
        ]);
        $imageName = date('Ymdhis').'.'.request()->image->getClientOriginalExtension();
        request()->image->move(public_path('banner_image'), $imageName);

        $dealsoftheday=New DealsoftheDay;
        $dealsoftheday->image = $imageName;
        $dealsoftheday->link = $request->link;
       
        if($dealsoftheday->save())
        {
            return redirect('/admin/deals-of-the-day/create')->with('success', 'Inserted Successfully');
        }
        else
        {
            return redirect('/admin/deals-of-the-day/create')->with('error', 'Something Went Wrong');
        }
    }

   
    public function show(DealsoftheDay $dealsoftheDay)
    {
        //
    }

    public function edit($id)
    {
        return view('admin.dealsoftheday.update',compact('id'));
    }

  
    public function update(Request $request)
    {
        if($request->hasFile('image'))
        {
             $validated = $request->validate([
                 'image' => 'required|image|mimes:jpg,png,jpeg,gif,svg,webp|max:1000',
             ]);
             $imageName = date('Ymdhis').'.'.request()->image->getClientOriginalExtension();
             request()->image->move(public_path('banner_image'), $imageName);
            
             $previous_path=public_path().'/banner_image/'.$request->previous_image;
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

         $val=array(
             'image'=>$imageName,
             'link'=>$request->link
         );

        $affected = DB::table('dealsofthe_days')
           ->where('id', $request->id)
           ->update($val);

     if($affected==true)
     {
         return redirect('/admin/deals-of-the-day/edit/'.$request->id)->with('success', 'Updated Successfully');
     }
     else
     {
         return redirect('/admin/deals-of-the-day/edit/'.$request->id)->with('error', 'Something Went Wrong');
     }
    }

    
    public function destroy(Request $request)
    {
        $previous_path=public_path().'/banner_image/'.$request->image;
        if($request->image!='')
        {
            if(File::exists($previous_path)){
                unlink($previous_path);
            }
        } 

        $deleted = DB::table('dealsofthe_days')->where('id',$request->id)->delete();
        if ($deleted==true) {
            return redirect('/admin/deals-of-the-day/')->with('success', 'Deleted Successfully');
        }
    }
}