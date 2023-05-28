<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
// sdasda
// SdA
// dSA
// D
// AD
// AD
// ADad
// sdA

use Mail;
use Session;
use App\Mail\DemoMail;

class AdminController extends Controller
{
    public function __construct()
    {
        date_default_timezone_set('Asia/Kolkata');
    }

    public function index()
    {
        if (!Auth::guard('admin')->check()) {
        return view('admin.index');
        } else {
            return redirect('/admin/dashboard');
        }
    }

    public function razorpay()
    {
        return view('admin.razorpay');
    }


    public function update_razorpay(Request $request)
    {
        $val = array(
            'key_id' => $request->key_id,
            'secret_id' => $request->secret_id
        );
        DB::table('razorpays')->where('id', '=', 1)->update($val);
        return redirect('/admin/razorpay')->with('success', 'Updated Successfully');
    }


    public function users()
    {
        return view('admin.users.view');
    }
    public function orders()
    {
        return view('admin.order');
    }
    public function profile()
    {
        return view('admin.profile');
    }
    public function update_profile(Request $request)
    {
        $result = array(
            'name' => $request->name,
            'email' => $request->email
        );
        $status = DB::table('admins')
            ->where('id', Auth::guard('admin')->user()->id)
            ->update($result);

        if ($status == true) {
            return redirect('/admin/profile')->with('success', 'Updated Successfully');
        } else {
            return redirect('/admin/profile')->with('error', 'Something Went Wrong');
        }
    }
    public function change_password()
    {
        return view('admin.change_password');
    }
    public function update_password(Request $request)
    {
        $result = array(
            'password' => Hash::make($request->password)
        );
        $status = DB::table('admins')
            ->where('id', Auth::guard('admin')->user()->id)
            ->update($result);

        if ($status == true) {
            return redirect('/admin/change-password')->with('success', 'Password Changed Successfully');
        } else {
            return redirect('/admin/change-password')->with('error', 'Something Went Wrong');
        }
    }
    public function company_details()
    {
        return view('admin.company_details');
    }
    public function update_company(Request $request)
    {
        $validatedData = $request->validate([
            'phone' => 'required|digits:10|numeric',
            'pincode' => 'required|digits:6|numeric'

        ]);

        if ($request->hasFile('image')) {
            $imageName = time() . '.' . request()->image->getClientOriginalExtension();
            request()->image->move(public_path('admin_image'), $imageName);

            $previous_path = public_path() . '/admin_image/' . $request->previous_image;
            if ($request->previous_image != '') {
                if (File::exists($previous_path)) {
                    unlink($previous_path);
                }
            }
        } else {
            $imageName = $request->previous_image;
        }
        $result = array(
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'house_no' => $request->house_no,
            'area' => $request->area,
            'city' => $request->city,
            'state' => $request->state,
            'pincode' => $request->pincode,
            'image' => $imageName,
            'gst_no' => $request->gst_no,
            'pan_no' => $request->pan_no,
            'licence_no' => $request->licence_no
        );
        $status = DB::table('company_details')
            ->where('admin_id', Auth::guard('user')->user()->id)
            ->update($result);

        if ($status == true) {
            return redirect('/admin/company-details')->with('success', 'Updated Successfully');
        } else {
            return redirect('/admin/company-details')->withInput()->with('error', 'Something Went Wrong');
        }
    }

    public function admin_login(Request $request)
    {
       

            if (Auth::guard('admin')->attempt(['email' => $request->email, 'password' => $request->password])) {
                return redirect('/admin/dashboard');
            } else {
                return redirect('/admin')->withInput()->with('error', 'Invalid Credentials');
            }
   
    }
    public function dashboard()
    {
        return view('admin.dashboard');
    }
    public function edit_users($id)
    {
        $user_result = DB::table('users')->where('id', $id)->first();
        return view('admin.users.update', compact('user_result'));
    }
    public function update_user(Request $request)
    {
        $result = array(
            'active_status' => $request->active_status
        );
        $status = DB::table('users')->where('id', $request->user_id)->update($result);
        return redirect('/admin/edit-users/' . $request->user_id)->with('success', 'Updated Successfully');
    }
    public function delete_user(Request $request)
    {
        $status = DB::table('users')->where('id', $request->user_id)->delete();
        return redirect('/admin/users')->with('success', 'Deleted Successfully');
    }
    public function admin_logout()
    {
        Auth::guard('admin')->logout();
        return redirect('/admin/');
    }
}
