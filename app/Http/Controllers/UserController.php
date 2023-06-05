<?php

namespace App\Http\Controllers;

use App\Models\{User};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
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
            'email' => 'required|unique:users',

        ]);
        $imageName = date('Ymdhis') . '.' . request()->image->getClientOriginalExtension();
        request()->image->move(public_path('user_image'), $imageName);

        $user = new User;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->image = $imageName;
        $user->password = $request->password;
        $user->active_status = $request->active_status;

        if ($user->save()) {
            return redirect('/admin/user/create')->with('success', 'Inserted Successfully');
        } else {
            return redirect('/admin/user/create')->with('error', 'Something Went Wrong');
        }
    }

    public function newuser(User $user, Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpg,png,jpeg,gif,svg,webp|max:300',
            'phone' => 'required|digits:10',
            'email' => 'required|unique:users',
            'name' => 'required',
            'password' => 'required|same:ConfirmPassword',
            'ConfirmPassword' => 'required',
        ]);
        $imageName = date('Ymdhis') . '.' . request()->image->getClientOriginalExtension();
        request()->image->move(public_path('user_image'), $imageName);
        $pass = Hash::make($request->password);
        $user = new User;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->image = $imageName;
        $user->password =  $pass;
        // $user->active_status = $request->active_status;

        if ($user->save()) {
            return redirect('/shoping')->with('success', 'Inserted Successfully');
        } else {
            return redirect('/shoping')->with('error', 'Something Went Wrong');
        }
    }


    public function edit(User $user)
    {
        return view('admin.user.update', compact('user'));
    }


    public function update(Request $request, User $user)
    {
        if ($request->hasFile('image')) {
            $validated = $request->validate([
                'image' => 'required|image|mimes:jpg,png,jpeg,gif,svg,webp|max:300',
            ]);
            $imageName = date('Ymdhis') . '.' . request()->image->getClientOriginalExtension();
            request()->image->move(public_path('user_image'), $imageName);

            $previous_path = public_path() . '/user_image/' . $request->previous_image;
            if ($request->previous_image != '') {
                if (File::exists($previous_path)) {
                    unlink($previous_path);
                }
            }
        } else {
            $imageName = $request->previous_image;
        }


        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->image = $imageName;
        $user->password = $request->password;
        $user->active_status = $request->active_status;

        if ($user->save()) {
            return redirect('/admin/user/' . $user->id . '/edit')->with('success', 'Updated Successfully');
        } else {
            return redirect('/admin/user/' . $user->id . '/edit')->with('error', 'Something Went Wrong');
        }
    }


    public function destroy(User $user)
    {
        $previous_path = public_path() . '/user_image/' . $user->image;
        if ($user->image != '') {
            if (File::exists($previous_path)) {
                unlink($previous_path);
            }
        }
        if ($user->delete()) {
            return redirect('/admin/user/')->with('success', 'Deleted Successfully');
        }
    }

    public function login(Request $request)
    {
        //    dd($request->all());


        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);
        // $request->only('email','password');
        if (Auth::guard('web')->attempt(['email' => $request->email, 'password' => $request->password])) {
            return redirect('/shoping')->with('success', 'Login Sucessfully');
        } else {

            return redirect('/shoping')->with('error', 'Invalid Details');
        }
    }
    public function logout()
    {
        Auth::guard('web')->logout();
        return redirect('/shoping')->with('success', 'Logout Sucessfully');
    }
    public function cart()
    {
        return view('');
    }
    public function change_qnty(Request $request)
    {
        $val = array(
          'qty'=> $request->qty,
        //   'qty'=> 2,
          
      );
          $cart =DB::table('carts')->where('product_id' ,$request->id)->update($val);
         
        // dd($cart);
          return response()->json(['ok'=>'Quantity Updated']);
          
        }
        public function delete_product_cart(Request $request){
            $cart =DB::table('carts')->where('product_id' ,$request->id)->delete();
            return response()->json(['ok'=>'Product Remove']);
    }
    public function AddToCart(Request $request)
    {
        $val = array(
            'product_id'=> $request->product_id,
            'user_id'=> $request->user_id,
            'qty'=> $request->quantity,
            // 'qty'=> $request->qty,
          //   'qty'=> 2,
        );
        // if()
      $check=  DB::table('carts')->where(['user_id'=>$request->user_id , 'product_id' => $request->product_id])->exists();
    //   dd($table);
    //   exit();
        if(!$check){
            $cart = DB::table('carts')->insert($val);
            return response()->json(['ok'=>'Add Cart Successfully']);
        }else{
            
            return response()->json(['ok'=>'Already Added to  Cart ']);
         
        }

    }
    public function AddBuy(Request $request)
    {
    //     $val = array(
    //         'product_id'=> $request->product_id,
    //         'user_id'=> $request->user_id,
    //         'qty'=> $request->quantity,
    //         // 'qty'=> $request->qty,
    //       //   'qty'=> 2,
    //     );
    //     // if()
    //    $cart = DB::table('order_items')->insert($val);
       return response()->json(['ok'=>'Buy Successfully']);
    }
}
