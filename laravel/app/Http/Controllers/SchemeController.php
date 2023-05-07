<?php

namespace App\Http\Controllers;

use App\Models\AdminScheme;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File; 
use Illuminate\Support\Facades\Hash;
use Auth;
use Mail;

class SchemeController extends Controller
{
    public function __construct()
    {
        date_default_timezone_set('Asia/Kolkata');
    }

    public function index()
    {
        return view('admin.scheme.view');
    }

   
    public function create()
    {
        return view('admin.scheme.create');
    }

  
    public function store(Request $request)
    {
        $scheme=New AdminScheme;
        $scheme->name = $request->name;
        $scheme->type = $request->type;
        $scheme->amount = $request->amount;
        $scheme->percentage = $request->percentage;
        $scheme->from_date = $request->from_date;
        $scheme->to_date = $request->to_date;

        if($request->from_date >= $request->to_date){
            return redirect('/admin/schemes/create')->with('error', 'From date shpuld be less than To Date');
        }
        else{
            if($scheme->save())
            {
                return redirect('/admin/schemes/create')->with('success', 'Inserted Successfully');
            }
            else
            {
                return redirect('/admin/schemes/create')->with('error', 'Something Went Wrong');
            }
        }
    }
    public function show(AdminScheme $scheme)
    {
        //
    }

    
    public function edit(AdminScheme $scheme)
    {
        return view('admin.scheme.update',compact('scheme'));
    }

   
    public function update(Request $request, AdminScheme $scheme)
    {
        $scheme->name = $request->name;
        $scheme->type = $request->type;
        $scheme->amount = $request->amount;
        $scheme->percentage = $request->percentage;
        $scheme->from_date = $request->from_date;
        $scheme->to_date = $request->to_date;

        if($request->from_date >= $request->to_date){
            return redirect('/admin/schemes/create')->with('error', 'From date shpuld be less than To Date');
        }
        else{
            if($scheme->save())
            {
                return redirect('/admin/schemes/'.$scheme->id.'/edit')->with('success', 'Updated Successfully');
            }
            else
            {
                return redirect('/admin/schemes/'.$scheme->id.'/edit')->with('error', 'Something Went Wrong');
            }
        }
    }

    
    public function destroy(AdminScheme $scheme)
    {
        if ($scheme->delete()) {
            return redirect('/admin/schemes/')->with('success', 'Deleted Successfully');
        }
    }
}