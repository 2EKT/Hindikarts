<?php

namespace App\Http\Controllers;

use App\Models\Deliverytype;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File; 
use Illuminate\Support\Facades\Hash;
use Auth;
use Mail;

class DeliverytypeController extends Controller
{
    public function __construct()
    {
        date_default_timezone_set('Asia/Kolkata');
    }
    public function index()
    {
        return view('admin.deliverytype.view');
    }

   
    public function create()
    {
        return view('admin.deliverytype.create');
    }

  
    public function store(Request $request)
    {
        $deliverytype=New Deliverytype;
        $deliverytype->delivery_name = $request->delivery_name;
        $deliverytype->delivery_charge = $request->delivery_charge;
       
        if($deliverytype->save())
        {
            return redirect('/admin/deliverytype/create')->with('success', 'Inserted Successfully');
        }
        else
        {
            return redirect('/admin/deliverytype/create')->with('error', 'Something Went Wrong');
        }
    }
    public function show(Deliverytype $deliverytype)
    {
        //
    }

    
    public function edit(Deliverytype $deliverytype)
    {
        return view('admin.deliverytype.update',compact('deliverytype'));
    }

   
    public function update(Request $request, Deliverytype $deliverytype)
    {
        $deliverytype->delivery_name = $request->delivery_name;
        $deliverytype->delivery_charge = $request->delivery_charge;
       
        if($deliverytype->save())
        {
            return redirect('/admin/deliverytype/'.$deliverytype->id.'/edit')->with('success', 'Updated Successfully');
        }
        else
        {
            return redirect('/admin/deliverytype/'.$deliverytype->id.'/edit')->with('error', 'Something Went Wrong');
        }
    }

    
    public function destroy(Deliverytype $deliverytype)
    {
        if ($deliverytype->delete()) {
            return redirect('/admin/deliverytype/')->with('success', 'Deleted Successfully');
        }
    }
}