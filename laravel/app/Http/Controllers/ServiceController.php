<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File; 
use Illuminate\Support\Facades\Hash;
use Auth;
use Mail;

class ServiceController extends Controller
{
    public function __construct()
    {
        date_default_timezone_set('Asia/Kolkata');
    }
    public function index()
    {
        return view('admin.service.view');
    }

    
    public function create()
    {
        return view('admin.service.create');
    }

    
    public function store(Request $request)
    {
        $validated = $request->validate([
            'image' => 'required|image|mimes:jpg,png,jpeg,gif,svg,webp|max:1000',
        ]);
        $imageName = date('Ymdhis').'.'.request()->image->getClientOriginalExtension();
        request()->image->move(public_path('service_image'), $imageName);


        $rowArray=explode(' ',strtolower($request->service));
	    $rowKeyword=implode('-',$rowArray);

	    $rowKeyword = str_replace(",", "-", $rowKeyword);
	    $rowKeyword = str_replace(".", "-", $rowKeyword);
	    $rowKeyword = str_replace("/", "-", $rowKeyword);
	    $rowKeyword = str_replace("!", "-", $rowKeyword);
	    $rowKeyword = str_replace("@", "-", $rowKeyword);
	    $rowKeyword = str_replace("#", "-", $rowKeyword);
	    $rowKeyword = str_replace("$", "-", $rowKeyword);
	    $rowKeyword = str_replace("%", "-", $rowKeyword);
	    $rowKeyword = str_replace("^", "-", $rowKeyword);
	    $rowKeyword = str_replace("*", "-", $rowKeyword);
	    $rowKeyword = str_replace("(", "-", $rowKeyword);
	    $rowKeyword = str_replace(")", "-", $rowKeyword);
	    $rowKeyword = str_replace("=", "-", $rowKeyword);
	    $rowKeyword = str_replace("+", "-", $rowKeyword);
	    $rowKeyword = str_replace("{", "-", $rowKeyword);
	    $rowKeyword = str_replace("}", "-", $rowKeyword);
	    $rowKeyword = str_replace("[", "-", $rowKeyword);
	    $rowKeyword = str_replace("]", "-", $rowKeyword);

        $service=New Service;
        $service->service = $request->service;
        $service->keyword = $rowKeyword;
        $service->description = $request->description;
        $service->image = $imageName;
       
        if($service->save())
        {
            return redirect('/admin/service/create')->with('success', 'Inserted Successfully');
        }
        else
        {
            return redirect('/admin/service/create')->with('error', 'Something Went Wrong');
        }
    }

    public function show(Service $service)
    {
        //
    }

    public function edit(Service $service)
    {
        return view('admin.service.update',compact('service'));
    }

    
    public function update(Request $request, Service $service)
    {
        if($request->hasFile('image'))
           {
                $validated = $request->validate([
                    'image' => 'required|image|mimes:jpg,png,jpeg,gif,svg,webp|max:1000',
                ]);
                $imageName = date('Ymdhis').'.'.request()->image->getClientOriginalExtension();
                request()->image->move(public_path('service_image'), $imageName);
               
                $previous_path=public_path().'/service_image/'.$request->previous_image;
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
        $rowArray=explode(' ',strtolower($request->service));
	    $rowKeyword=implode('-',$rowArray);

	    $rowKeyword = str_replace(",", "-", $rowKeyword);
	    $rowKeyword = str_replace(".", "-", $rowKeyword);
	    $rowKeyword = str_replace("/", "-", $rowKeyword);
	    $rowKeyword = str_replace("!", "-", $rowKeyword);
	    $rowKeyword = str_replace("@", "-", $rowKeyword);
	    $rowKeyword = str_replace("#", "-", $rowKeyword);
	    $rowKeyword = str_replace("$", "-", $rowKeyword);
	    $rowKeyword = str_replace("%", "-", $rowKeyword);
	    $rowKeyword = str_replace("^", "-", $rowKeyword);
	    $rowKeyword = str_replace("*", "-", $rowKeyword);
	    $rowKeyword = str_replace("(", "-", $rowKeyword);
	    $rowKeyword = str_replace(")", "-", $rowKeyword);
	    $rowKeyword = str_replace("=", "-", $rowKeyword);
	    $rowKeyword = str_replace("+", "-", $rowKeyword);
	    $rowKeyword = str_replace("{", "-", $rowKeyword);
	    $rowKeyword = str_replace("}", "-", $rowKeyword);
	    $rowKeyword = str_replace("[", "-", $rowKeyword);
	    $rowKeyword = str_replace("]", "-", $rowKeyword);

      
        $service->service = $request->service;
        $service->keyword = $rowKeyword;
        $service->description = $request->description;
        $service->image = $imageName;
       
        if($service->save())
        {
            return redirect('/admin/service/'.$service->id.'/edit')->with('success', 'Updated Successfully');
        }
        else
        {
            return redirect('/admin/category/'.$service->id.'/edit')->with('error', 'Something Went Wrong');
        }
    }

   
    public function destroy(Service $service)
    {
        $previous_path=public_path().'/service_image/'.$service->image;
        if($service->image!='')
        {
            if(File::exists($previous_path)){
                unlink($previous_path);
            }
        }
        if ($service->delete()) {
            return redirect('/admin/service/')->with('success', 'Deleted Successfully');
        }
    }
}