<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File; 
use Illuminate\Support\Facades\Hash;
use Auth;
use Mail;

class DistrictFranchiseController extends Controller
{
    public function __construct()
    {
        date_default_timezone_set('Asia/Kolkata');
    }
    public function index()
    {
        return view('district-franchise.index');
    }
    
    public function wallet()
    {
        return view('district-franchise.wallet');
    }
    
    public function login(Request $request)
    {
        if(Auth::guard('districtpartner')->attempt(['email'=>$request->email,'password'=>$request->password])){
            return redirect('/district-franchise/dashboard');
        }
        else{
            return redirect('/district-franchise')->withInput()->with('error', 'Invalid Credentials');
        }
    }

    public function dashboard()
    {
        return view('district-franchise.dashboard');
    }
    public function profile()
    {
        return view('district-franchise.profile');
    }

    public function update_profile(Request $request)
    {
            $result=array(
                'name'=>$request->name,
                'email'=>$request->email
            );
               $status = DB::table('districtpartners')
                  ->where('id', Auth::guard('districtpartner')->user()->id)
                  ->update($result);
    
            if($status==true){
                return redirect('/district-franchise/profile')->with('success', 'Updated Successfully');
            }
            else{
                return redirect('/district-franchise/profile')->with('error', 'Something Went Wrong');
            }
           
    }
    public function change_password()
    {
        return view('district-franchise.change_password');
    }

    public function update_password(Request $request)
    {
            $result=array(
                'password'=>Hash::make($request->password)
            );
               $status = DB::table('districtpartners')
                  ->where('id', Auth::guard('districtpartner')->user()->id)
                  ->update($result);
    
            if($status==true){
                return redirect('/district-franchise/change-password')->with('success', 'Password Changed Successfully');
            }
            else{
                return redirect('/district-franchise/change-password')->with('error', 'Something Went Wrong');
            }
        
           
    }
    public function logout()
    {
        Auth::guard('districtpartner')->logout();
        return redirect('/district-franchise/');
    }

    //District Partner Section
    public function view_blockpartner()
    {
        return view('district-franchise.blockpartner.view');
    }
    public function create_blockpartner()
    {
        return view('district-franchise.blockpartner.create');
    }

    public function store_blockpartner(Request $request)
    {
        $validated = $request->validate([
            'image' => 'required|image|mimes:jpg,png,jpeg,gif,svg,webp|max:1000',
            'phone' => 'required|digits:10',
            'email'=> 'required|unique:blockpartners',
        ]);
        $imageName = date('Ymdhis').'.'.request()->image->getClientOriginalExtension();
        request()->image->move(public_path('user_image'), $imageName);

        

       
        $val=array(
            'zone_partner_id'=>Auth::guard('districtpartner')->user()->zone_partner_id,
            'district_partner_id'=>Auth::guard('districtpartner')->user()->id,
            'block_id'=>$request->block_id,
            'name'=>$request->name,
            'email'=>$request->email,
            'phone'=>$request->phone,
            'password'=>Hash::make($request->password),
            'image'=>$imageName,
            'wallet_balance' => 0,
            'active_status'=>'YES'
        );

       $affected = DB::table('blockpartners')->insert($val);
          
        if($affected==true)
        {
            return redirect('/district-franchise/blockpartner/create')->with('success', 'Inserted Successfully');
        }
        else
        {
            return redirect('/district-franchise/blockpartner/create')->with('error', 'Something Went Wrong');
        }
    }

    public function edit_blockpartner($id)
    {
        return view('district-franchise.blockpartner.update',compact('id'));
    }
    
    public function update_blockpartner(Request $request)
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
            $new_password=$request->password;
        }
        $val=array(
            'block_id'=>$request->block_id,
            'name'=>$request->name,
            'email'=>$request->email,
            'phone'=>$request->phone,
            'password'=>Hash::make($new_password),
            'image'=>$imageName,
            'active_status'=>$request->active_status
        );

       $affected = DB::table('blockpartners')->where('id',$request->id)->update($val);
          
        if($affected==true)
        {
            return redirect('/district-franchise/blockpartner/edit/'.$request->id)->with('success', 'Inserted Successfully');
        }
        else
        {
            return redirect('/district-franchise/blockpartner/edit/'.$request->id)->with('error', 'Something Went Wrong');
        }
    }

    
    public function destroy_blockpartner(Request $request)
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
            return redirect('/district-franchise/blockpartner/')->with('success', 'Deleted Successfully');
        }
    }


    public function view_employee()
    {
        return view('district-franchise.employee.view');
    }
    public function view_merchant()
    {
        return view('district-franchise.merchant.view');
    }
}