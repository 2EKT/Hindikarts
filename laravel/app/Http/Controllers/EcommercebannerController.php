<?php

namespace App\Http\Controllers;

use App\Models\Ecommercebanner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File; 
use Illuminate\Support\Facades\Hash;
use Auth;
use Mail;

class EcommercebannerController extends Controller
{
    public function __construct()
    {
        date_default_timezone_set('Asia/Kolkata');
    }
    public function index()
    {
        return view('admin.ecommercebanner.view');
    }

    public function create()
    {
        return view('admin.ecommercebanner.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'image' => 'required|image|mimes:jpg,png,jpeg,gif,svg,webp|max:1000',
        ]);
        $imageName = date('Ymdhis').'.'.request()->image->getClientOriginalExtension();
        request()->image->move(public_path('banner_image'), $imageName);

        $ecommercebanner=New Ecommercebanner;
        $ecommercebanner->image = $imageName;
        $ecommercebanner->title = $request->title;
        $ecommercebanner->sub_title = $request->sub_title;
       
        if($ecommercebanner->save())
        {
            return redirect('/admin/ecommercebanner/create')->with('success', 'Inserted Successfully');
        }
        else
        {
            return redirect('/admin/ecommercebanner/create')->with('error', 'Something Went Wrong');
        }
    }

    
    public function show(CompAnnouncement $compAnnouncement)
    {
        //
    }

    
    public function edit($id)
    {
        return view('admin.ecommercebanner.update',compact('id'));
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
                'title'=>$request->title,
                'sub_title'=>$request->sub_title
            );

           $affected = DB::table('ecommercebanners')
              ->where('id', $request->id)
              ->update($val);

        if($affected==true)
        {
            return redirect('/admin/ecommercebanner/edit/'.$request->id)->with('success', 'Updated Successfully');
        }
        else
        {
            return redirect('/admin/ecommercebanner/edit/'.$request->id)->with('error', 'Something Went Wrong');
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

        $deleted = DB::table('ecommercebanners')->where('id',$request->id)->delete();
        if ($deleted==true) {
            return redirect('/admin/ecommercebanner/')->with('success', 'Deleted Successfully');
        }
    }
}