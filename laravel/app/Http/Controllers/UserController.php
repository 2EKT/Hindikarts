<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File; 
use Illuminate\Support\Facades\Hash;
use Auth;
use Mail;
 
use App\Mail\RegisterMail;

class UserController extends Controller
{
    public function __construct()
    {
        date_default_timezone_set('Asia/Kolkata');
    }
    public function index()
    {
        return view('admin.user.view');
    }
    public function create()
    {
        return view('admin.user.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'image' => 'required|image|mimes:jpg,png,jpeg,gif,svg,webp|max:300',
            'phone' => 'required|digits:10',
            'email'=> 'required|unique:users',
        ]);
        $imageName = date('Ymdhis').'.'.request()->image->getClientOriginalExtension();
        request()->image->move(public_path('user_image'), $imageName);

        $user=New User;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->image = $imageName;
        $user->password = $request->password;
        $user->active_status = $request->active_status;
       
        if($user->save())
        {
            return redirect('/admin/user/create')->with('success', 'Inserted Successfully');
        }
        else
        {
            return redirect('/admin/user/create')->with('error', 'Something Went Wrong');
        }
    }

    public function show(User $user)
    {
        //
    }

    
    public function edit(User $user)
    {
        return view('admin.user.update',compact('user'));
    }

  
    public function update(Request $request, User $user)
    {
        if($request->hasFile('image'))
           {
                $validated = $request->validate([
                    'image' => 'required|image|mimes:jpg,png,jpeg,gif,svg,webp|max:300',
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


           $user->name = $request->name;
           $user->email = $request->email;
           $user->phone = $request->phone;
           $user->image = $imageName;
           $user->password = $request->password;
           $user->active_status = $request->active_status;

        if($user->save())
        {
            return redirect('/admin/user/'.$user->id.'/edit')->with('success', 'Updated Successfully');
        }
        else
        {
            return redirect('/admin/user/'.$user->id.'/edit')->with('error', 'Something Went Wrong');
        }
    }

    
    public function destroy(User $user)
    {
        $previous_path=public_path().'/user_image/'.$user->image;
        if($user->image!='')
        {
            if(File::exists($previous_path)){
                unlink($previous_path);
            }
        } 
        if ($user->delete()) {
            return redirect('/admin/user/')->with('success', 'Deleted Successfully');
        }
    }
}