<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UpdatePassword;
use App\Http\Requests\User\UserDetail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


class UserController extends Controller
{
    public function userDashboard(){
        $id = Auth::id();
        $userData = User::find($id);
        return view('index',compact('userData'));
    }

    public function userProfileStore(UserDetail $request){

        $id = Auth::user()->id;
        $data = User::find($id);
    
        $validator = $request->validated();
        $checkimage = $validator['photo'] ?? null;
        if ($checkimage) {
            $filename = date('YmdHi').$checkimage->getClientOriginalName();
            $checkimage->move(public_path('upload/user_images'),$filename);
           $validator['photo'] = $filename;
           $data->update($validator);
        }
        $data->update($validator);
    
        $noti = [
            'message' => 'User Profile Updated Successfully',
            'alert-type' => 'success'
        ];
    
        return redirect()->back()->with($noti);
    } 

    public function userLogout(Request $request){
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        $notification = array(
            'message' => 'User Logout Successfully',
            'alert-type' => 'success'
        );

        return redirect('/login')->with($notification);
    }

    public function userUpdatePassword(UpdatePassword $request){
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
