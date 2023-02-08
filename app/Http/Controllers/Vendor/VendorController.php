<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UpdatePassword;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Vendor\VendorProfile;
use App\Http\Requests\Vendor\VendorRegister;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


class VendorController extends Controller
{
    public function vendorDashboard()
    {
        return view('vendor.index');
    }

    //vendor logout
    public function Logout(Request $request)
    {
        Auth::logout();

        return redirect()->route('vendor.login.form');
    }
    //end

    //login form
    public function LoginForm()
    {
        return view('vendor.vendor_login');
    }
    //end

    //login
    public function Login(LoginRequest $request)
    {
        $user = $request->only('email', 'password');
        if (Auth::attempt($user)) {
            //check role
            if ($request->user()->role === 'vendor') {
                $url = 'vendor/dashboard';
                $noti = [
                    "error" => false,
                    "message" => "Vendor login successful",
                    "alert-type" => "success"
                ];
            } else {
                $noti = [
                    "error" => false,
                    "message" => "This user is not vendor role",
                    "alert-type" => "error"
                ];
                return redirect()->back()->with($noti);
            }
            //end
            return redirect($url)->with($noti);
        }
        $noti = [
            "error" => false,
            "message" => "Username and password incorrect!",
            "alert-type" => "error"
        ];
        return redirect()->back()->with($noti);
    }
    //end

    //profile
    public function Profile()
    {
        $id = Auth::user()->id;
        $vendorData = User::find($id);
        return view('vendor.vendor_profile_view', compact('vendorData'));
    }
    //end

    //profile store
    public function profileStore(VendorProfile $request)
    {
        $id = Auth::user()->id;
        $data = User::find($id);

        $validator = $request->validated();
        $checkimage = $validator['photo'] ?? null;
        if ($checkimage) {
            $filename = date('YmdHi') . $checkimage->getClientOriginalName();
            $checkimage->move(public_path('upload/vendor_images'), $filename);
            $validator['photo'] = $filename;
            $data->update($validator);
        }
        $data->update($validator);

        $noti = [
            'message' => 'Vendor Profile Updated Successfully',
            'alert-type' => 'success'
        ];

        return redirect()->back()->with($noti);
    }
    //end

    //change psw view
    public function changePassword()
    {
        return view('vendor.vendor_change_psw');
    }
    //end

    //change password store
    public function updatePassword(UpdatePassword $request)
    {
        $validator = $request->validated();

        //check password
        if (Hash::check($validator['old_password'], auth::user()->password)) {
            if (!Hash::check($validator['new_password'], auth::user()->password)) {
                // Update The new password 
                User::whereId(auth()->user()->id)->update([
                    'password' => Hash::make($validator['new_password'])
                ]);
                $noti = [
                    "message" => " Password Changed Successfully",
                    "alert-type" => "success"
                ];
                return back()->with($noti);
            }
            return back()->with("error", "message','New password can not be the old password!");
        }

        return back()->with("error", "Old Password Doesn't Match!!");
    }
    //end

    //show vendor register in frontend
    public function becomeVendor()
    {
        return view('auth.become_vendor');
    }
    //end

    //store in user table
    public function vendorRegister(VendorRegister $request)
    {
        $validator = $request->validated();
        User::insert([
            "name" => $validator['name'],
            "username" => $validator['username'],
            "email" => $validator['email'],
            "phone" => $validator['phone'],
            "password" => Hash::make($validator['password']),
            "role" => "vendor",
            "status" => "active",
        ]);
        $noti = [
            'message' => 'Vendor Registered Successfully',
            'alert-type' => 'success'
        ];

        return redirect()->route('vendor.login')->with($noti);
    }
    //end

}
