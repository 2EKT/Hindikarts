<?php

namespace App\Http\Controllers;

use App\Models\ClientReview;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File; 
use Illuminate\Support\Facades\Hash;
use Auth;
use Mail;

class ClientReviewController extends Controller
{
    public function __construct()
    {
        date_default_timezone_set('Asia/Kolkata');
    }
    public function index()
    {
        return view('admin.clientreview.view');
    }

    public function create()
    {
        return view('admin.clientreview.create');
    }

    
    public function store(Request $request)
    {
        $validated = $request->validate([
            'image' => 'required|image|mimes:jpg,png,jpeg,gif,svg,webp|max:1000',
        ]);
        $imageName = date('Ymdhis').'.'.request()->image->getClientOriginalExtension();
        request()->image->move(public_path('banner_image'), $imageName);

        $clientreview=New ClientReview;
        $clientreview->image = $imageName;
        $clientreview->name = $request->name;
        $clientreview->designation = $request->designation;
        $clientreview->comment = $request->comment;
       
        if($clientreview->save())
        {
            return redirect('/admin/clientreview/create')->with('success', 'Inserted Successfully');
        }
        else
        {
            return redirect('/admin/clientreview/create')->with('error', 'Something Went Wrong');
        }
    }

   
    public function show(ClientReview $clientReview)
    {
        //
    }

    public function edit($id)
    {
        return view('admin.clientreview.update',compact('id'));
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
                'name'=>$request->name,
                'designation'=>$request->designation,
                'comment'=>$request->comment
            );

           $affected = DB::table('client_reviews')
              ->where('id', $request->id)
              ->update($val);

        if($affected==true)
        {
            return redirect('/admin/clientreview/edit/'.$request->id)->with('success', 'Updated Successfully');
        }
        else
        {
            return redirect('/admin/clientreview/edit/'.$request->id)->with('error', 'Something Went Wrong');
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

        $deleted = DB::table('client_reviews')->where('id',$request->id)->delete();
        if ($deleted==true) {
            return redirect('/admin/clientreview/')->with('success', 'Deleted Successfully');
        }
    }
}