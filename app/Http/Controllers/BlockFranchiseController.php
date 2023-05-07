<?php

namespace App\Http\Controllers;

use App\Models\BlockFranchise;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File; 
use Illuminate\Support\Facades\Hash;
use Auth;
use Mail;

class BlockFranchiseController extends Controller
{
    public function __construct()
    {
        date_default_timezone_set('Asia/Kolkata');
    }
    public function index()
    {
        return view('block-franchise.index');
    }
    
    public function wallet()
    {
        return view('block-franchise.wallet');
    }

    public function login(Request $request)
    {
        if(Auth::guard('blockpartner')->attempt(['email'=>$request->email,'password'=>$request->password])){
            return redirect('/block-franchise/dashboard');
        }
        else
        {
            return redirect('/block-franchise')->withInput()->with('error', 'Invalid Credentials');
        }
    }

    public function dashboard()
    {
        return view('block-franchise.dashboard');
    }
    public function profile()
    {
        return view('block-franchise.profile');
    }

    public function update_profile(Request $request)
    {
            $result=array(
                'name'=>$request->name,
                'email'=>$request->email
            );
               $status = DB::table('blockpartners')
                  ->where('id', Auth::guard('blockpartner')->user()->id)
                  ->update($result);
    
            if($status==true){
                return redirect('/block-franchise/profile')->with('success', 'Updated Successfully');
            }
            else{
                return redirect('/block-franchise/profile')->with('error', 'Something Went Wrong');
            }
           
    }
    public function change_password()
    {
        return view('block-franchise.change_password');
    }

    public function update_password(Request $request)
    {
            $result=array(
                'password'=>Hash::make($request->password)
            );
               $status = DB::table('blockpartners')
                  ->where('id', Auth::guard('blockpartner')->user()->id)
                  ->update($result);
    
            if($status==true){
                return redirect('/block-franchise/change-password')->with('success', 'Password Changed Successfully');
            }
            else{
                return redirect('/block-franchise/change-password')->with('error', 'Something Went Wrong');
            }
        
           
    }
    public function logout()
    {
        Auth::guard('blockpartner')->logout();
        return redirect('/block-franchise/');
    }

    //District Partner Section
    public function view_employee()
    {
        return view('block-franchise.employee.view');
    }
    public function create_employee()
    {
        return view('block-franchise.employee.create');
    }

    public function store_employee(Request $request)
    {
        $validated = $request->validate([
            'image' => 'required|image|mimes:jpg,png,jpeg,gif,svg,webp|max:1000',
            'phone' => 'required|digits:10',
            'email'=> 'required|unique:blockpartners',
        ]);
        $imageName = date('Ymdhis').'.'.request()->image->getClientOriginalExtension();
        request()->image->move(public_path('user_image'), $imageName);

        if($request->password=='')
        {
            $new_password=$request->previous_password;
        }
        else
        {
            $new_password=$request->password;
        }
        $current_block_partner_id = Auth::guard('blockpartner')->user()->id;
        $current_block_partner = DB::table('blockpartners')->find($current_block_partner_id);
        $val=array(
            'block_partner_id'=> $current_block_partner_id,
            'zone_partner_id' => $current_block_partner->zone_partner_id,
            'district_partner_id' => $current_block_partner->district_partner_id,
            'name'=>$request->name,
            'email'=>$request->email,
            'phone'=>$request->phone,
            'password'=>Hash::make($new_password),
            'image'=>$imageName,
            'wallet_balance' => 0,
            'active_status'=>$request->active_status
        );

       $affected = DB::table('employees')->insert($val);
          
        if($affected==true)
        {
            return redirect('/block-franchise/employee/create')->with('success', 'Inserted Successfully');
        }
        else
        {
            return redirect('/block-franchise/employee/create')->with('error', 'Something Went Wrong');
        }
    }

    public function edit_employee($id)
    {
        return view('block-franchise.employee.update',compact('id'));
    }
    
    public function update_employee(Request $request)
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
            'name'=>$request->name,
            'email'=>$request->email,
            'phone'=>$request->phone,
            'password'=>Hash::make($new_password),
            'image'=>$imageName,
            'active_status'=>$request->active_status
        );

       $affected = DB::table('employees')->where('id',$request->id)->update($val);
          
        if($affected==true)
        {
            return redirect('/block-franchise/employee/edit/'.$request->id)->with('success', 'Inserted Successfully');
        }
        else
        {
            return redirect('/block-franchise/employee/edit/'.$request->id)->with('error', 'Something Went Wrong');
        }
    }

    
    public function destroy_employee(Request $request)
    {
        $previous_path=public_path().'/user_image/'.$request->image;
        if($request->image!='')
        {
            if(File::exists($previous_path)){
                unlink($previous_path);
            }
        } 

        $deleted = DB::table('employees')->where('id',$request->id)->delete();
        if ($deleted==true) {
            return redirect('/block-franchise/employee/')->with('success', 'Deleted Successfully');
        }
    }

    public function view_merchant()
    {
        return view('block-franchise.merchant.view');
    }
}