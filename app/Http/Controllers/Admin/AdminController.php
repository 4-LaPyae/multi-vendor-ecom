<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AdminLogin;
use App\Http\Requests\Admin\AdminPorfile;
use App\Http\Requests\Admin\UpdatePassword;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

use Illuminate\Http\RedirectResponse;

use Illuminate\View\View;



class AdminController extends Controller
{
    //show admin dashboard
    public function adminDashboard()
    {
        return view('admin.index');
    }
    //end

    //admin logout
    public function adminLogout(Request $request)
    {
        //for api
        // $request->user()->currentAccessToken()->delete();
        //     return response()->json([
        //         "error"=>false,
        //         "message"=>"Token is deleted",
        //    ]);
        //end
        Auth::logout();
        return redirect()->route('admin.login');
    }
    //end

    //admin login
    public function adminLogin(AdminLogin $request)
    {
        $user = $request->only('email', 'password');
        if (Auth::attempt($user)) {
            //check role
            $url = "";
            if ($request->user()->role === 'admin') {
                $url = 'admin/dashboard';
                $noti = [
                    "error" => false,
                    "message" => "Admin login successful",
                    "alert-type" => "success"
                ];
            } else {
                $noti = [
                    "error" => false,
                    "message" => "This user is not admin role",
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

        // //check role
        // $url = "";
        // if($request->user()->role === 'admin'){
        //         $url = 'admin/dashboard';
        // }elseif($request->user()->role === 'vendor'){
        //         $url = 'vendor/dashboard';
        // }elseif($request->user()->role === 'user'){
        //         $url = 'dashboard';
        // }
        // //end

        // return redirect()->intended($url);
    }

    //show login form
    public function adminLoginForm()
    {
        return view('admin.admin_login');
    }
    //end

    //show admin profile
    public function AdminProfile()
    {
        $id = Auth::user()->id;
        $adminData = User::find($id);
        return view('admin.admin_profile_view', compact('adminData'));
    }
    //end

    //update admin profile
    public function AdminProfileStore(AdminPorfile $request)
    {
        $id = Auth::user()->id;
        $data = User::find($id);
        $validator = $request->validated();
        $checkimage = $validator['photo'] ?? null;
        if ($checkimage) {
            $filename = date('YmdHi') . $checkimage->getClientOriginalName();
            $checkimage->move(public_path('upload/admin_images'), $filename);
            $validator['photo'] = $filename;
            $data->update($validator);
        }
        $data->update($validator);
        $noti = [
            'message' => 'Admin Profile Updated Successfully',
            'alert-type' => 'success'
        ];
        return redirect()->back()->with($noti);
    }
    //end    

    //show password page
    public function AdminChangePassword()
    {
        return view('admin.admin_change_psw');
    }
    //end

    //update password
    public function AdminUpdatePassword(UpdatePassword $request)
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

    //show inactive vendor
    public function inActiveVendor()
    {

        $inActiveVendor = User::where('status', 'inactive')
            ->where('role', 'vendor')->latest()->get();
        return view('backend.vendor.inactive_vendor', compact('inActiveVendor'));
    }
    //end

    //inactive vendor details
    public function inActiveVendorDetails($id){
        $inActiveVendorDetails = User::findOrFail($id);
        return view('backend.vendor.inactive_vendor_detail',compact('inActiveVendorDetails'));
    }
    //end

    //show active vendor
    public function activeVendor()
    {
        $activeVendor = User::where('status', 'active')
            ->where('role', 'vendor')->latest()->get();
        return view('backend.vendor.active_vendor', compact('activeVendor'));
    }
    //end

    //active vendor approve
    public function activeVendorApprove(Request $request){
       $vendor = User::findOrFail($request->id);
       $vendor->status = 'active';
       $vendor->save();
       $noti = [
        'message' => 'Vendor Active Successfully',
        'alert-type' => 'success'
       ];

    return redirect()->route('active.vendor')->with($noti);
    }
    //end


    //inactive vendor details
    public function activeVendorDetails($id){
        $activeVendorDetails = User::findOrFail($id);
        return view('backend.vendor.active_vendor_detail',compact('activeVendorDetails'));
    }
    //end
    //inactive vendor approve
    public function inActiveVendorApprove(Request $request){
        $vendor = User::findOrFail($request->id);
        $vendor->status = 'inactive';
        $vendor->save();
        $noti = [
         'message' => 'Vendor InActive Successfully',
         'alert-type' => 'success'
        ];
 
     return redirect()->route('inactive.vendor')->with($noti);
     }
     //end


}
