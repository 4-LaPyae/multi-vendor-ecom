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

    public function adminDashboard(){
        return view('admin.admin_dashboard');
    }

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
        // $validator = $request->validated();
        // $user = User::where('email', $validator['email'])->first();
        // if ($user) {
        //     if (Hash::check($validator['password'], $user->password)) {
        //         //$token = $user->createToken('multi-vendor')->plainTextToken;
        //         $url = "";
        //         $noti = "";
        //      if($user->role === 'admin'){
        //         //return "hello";
        //         $url = 'admin/dashboard';
        //         $noti = [
        //             "error"=>false,
        //             "message"=>"Admin login successful",
        //             "alert-type"=>"success"
        //             ];
        //  }
        //  return redirect($url)->with($noti);

                
        //         // return response()->json([
        //         //     "error"=>false,
        //         //     "message"=>"Token get successful",
        //         //     "token"=>$token
        //         // ]);        
        //     } else {            
        //         return response()->json([
        //             "error"=>false,
        //             "message"=>"Password incorrect!"
        //         ]);
        //     }
        // } 
        // return response()->json([
        //     "error"=>false,
        //     "message"=>"User does not exists"
        //     ]);
        $user = $request->only('email', 'password');
        if (Auth::attempt($user)) {
            //for api
            //  $token = Auth::user()->createToken('multi-ventor')->plainTextToken;
            //     return response()->json([
            //         "error"=>false,
            //         "message"=>"Token get successful",
            //         "token"=>$token
            //     ]);
            //end
          //check role
            $url = "";
            $noti = "";
            if($request->user()->role === 'admin'){
                $url = 'admin/dashboard';
            $noti = [
                "error"=>false,
                "message"=>"Admin login successful",
                "alert-type"=>"success"
            ];
     }
     return redirect($url)->with($noti);
    }
        

            
        // }

         $noti = [
         "error"=>false,
             "message"=>"Username and password incorrect!",
             "alert-type"=>"error"
         ];
         return redirect()->back()->with($noti);
        // $request->authenticate();

        // $request->session()->regenerate();
        
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

   public function adminLoginForm()
   {
    return view('admin.admin_login');
   }

   public function AdminProfile(){

    $id = Auth::user()->id;
    $adminData = User::find($id);
    return view('admin.admin_profile_view',compact('adminData'));

}

   public function AdminProfileStore(AdminPorfile $request){

    $id = Auth::user()->id;
    $data = User::find($id);

    $validator = $request->validated();
    $checkimage = $validator['photo'] ?? null;
    if ($checkimage) {
        $filename = date('YmdHi').$checkimage->getClientOriginalName();
        $checkimage->move(public_path('upload/admin_images'),$filename);
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

public function AdminChangePassword(){
    return view('admin.admin_change_psw');
}

public function AdminUpdatePassword(UpdatePassword $request){
    $validator = $request->validated();

    //check password
    if (Hash::check($validator['old_password'], auth::user()->password)) {
        if(!Hash::check($validator['new_password'],auth::user()->password)){
            // Update The new password 
            User::whereId(auth()->user()->id)->update([
                'password' => Hash::make($validator['new_password'])
            ]);
            $noti = [
                "message"=> " Password Changed Successfully",
                "alert-type"=>"success"
            ];
            return back()->with($noti);

        }
        return back()->with("error", "message','New password can not be the old password!");

        
    }

    return back()->with("error", "Old Password Doesn't Match!!");
 
    

}
}
