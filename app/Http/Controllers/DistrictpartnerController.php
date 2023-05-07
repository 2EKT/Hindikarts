<?php

namespace App\Http\Controllers;

use App\Models\Districtpartner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File; 
use Illuminate\Support\Facades\Hash;
use Auth;
use Mail;

class DistrictpartnerController extends Controller
{
    public function __construct()
    {
        date_default_timezone_set('Asia/Kolkata');
    }
    public function index()
    {
        return view('admin.districtpartner.view');
    }

   
    public function create()
    {
        //
    }

    
    public function store(Request $request)
    {
        //
    }

    
    public function show(Districtpartner $districtpartner)
    {
        //
    }

    
    public function edit($id)
    {
        return view('admin.districtpartner.update',compact('id'));
    }

    
    public function update(Request $request, Districtpartner $districtpartner)
    {
        if($request->hasFile('image'))
        {
             $validated = $request->validate([
                 'image' => 'required|image|mimes:jpg,png,jpeg,gif,svg,webp|max:1000',
             ]);
             $imageName = date('Ymdhis').'.'.request()->image->getClientOriginalExtension();
             request()->image->move(public_path('user_image'), $imageName);
            
             $previous_path=public_path().'/user_image/'.$request->previous_image;
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

        if($request->password=='')
        {
            $new_password=$request->previous_password;
        }
        else
        {
            $new_password=Hash::make($request->password);
        }
        $val=array(
            'district_id'=>$request->district_id,
            'name'=>$request->name,
            'email'=>$request->email,
            'phone'=>$request->phone,
            'password'=>$new_password,
            'image'=>$imageName,
            'active_status'=>$request->active_status,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        );

        $affected = DB::table('districtpartners')->where('id',$request->id)->update($val);
        
        if($affected==true)
        {
            return redirect('/admin/districtpartner/edit/'.$request->id)->with('success', 'Inserted Successfully');
        }
        else
        {
            return redirect('/admin/districtpartner/edit/'.$request->id)->with('error', 'Something Went Wrong');
        }
    }

    
    public function destroy(Request $request)
    {
        $previous_path=public_path().'/user_image/'.$request->image;
        if($request->image!='')
        {
            if(File::exists($previous_path)){
                unlink($previous_path);
            }
        } 

        $deleted = DB::table('districtpartners')->where('id',$request->id)->delete();
        if ($deleted==true) {
            return redirect('/admin/districtpartner/')->with('success', 'Deleted Successfully');
        }
    }
}