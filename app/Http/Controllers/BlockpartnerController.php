<?php

namespace App\Http\Controllers;

use App\Models\Blockpartner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File; 
use Illuminate\Support\Facades\Hash;
use Auth;
use Mail;

class BlockpartnerController extends Controller
{
    public function __construct()
    {
        date_default_timezone_set('Asia/Kolkata');
    }
    public function index()
    {
        return view('admin.blockpartner.view');
    }

    
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Blockpartner  $blockpartner
     * @return \Illuminate\Http\Response
     */
    public function show(Blockpartner $blockpartner)
    {
        //
    }

    
    public function edit($id)
    {
        return view('admin.blockpartner.update',compact('id'));
    }

    public function update(Request $request)
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
            'block_id'=>$request->block_id,
            'name'=>$request->name,
            'email'=>$request->email,
            'phone'=>$request->phone,
            'password'=>$new_password,
            'image'=>$imageName,
            'active_status'=>$request->active_status
        );

        $affected = DB::table('blockpartners')->where('id',$request->id)->update($val);
        
        if($affected==true)
        {
            return redirect('/admin/blockpartner/edit/'.$request->id)->with('success', 'Inserted Successfully');
        }
        else
        {
            return redirect('/admin/blockpartner/edit/'.$request->id)->with('error', 'Something Went Wrong');
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

        $deleted = DB::table('blockpartners')->where('id',$request->id)->delete();
        if ($deleted==true) {
            return redirect('/admin/blockpartner/')->with('success', 'Deleted Successfully');
        }
    }
}