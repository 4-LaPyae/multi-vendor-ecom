<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\Vendor\VendorController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('frontend.index');
});

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');
//user
Route::middleware(['auth'])->group(function (){
    Route::controller(UserController::class)->group(function (){
        Route::get('/dashboard','userDashboard')->name('dashboard');
        Route::post('/user/profile/store','userProfileStore')->name('user.profile.store');
        Route::get('/user/logout','userLogout')->name('user.logout');
        Route::post('/user/update/password','userUpdatePassword')->name('user.update.password');
    });
    
    });
//end

//admin
Route::group(['prefix'=>'admin'],function (){
    Route::controller(AdminController::class)->group(function (){
        Route::get('/login','adminLoginForm')->name('admin.login');
        Route::post('/login','adminLogin')->name('alogin');
        Route::get('/profile', 'AdminProfile')->name('admin.profile');
        Route::post('/profile/store', 'AdminProfileStore')->name('admin.profile.store');
        Route::get('/change/password', 'AdminChangePassword')->name('admin.change.password');
        Route::post('/update/password','AdminUpdatePassword')->name('update.password');
    });
   
});
Route::middleware(['auth','role:admin'])->group(function (){
    Route::controller(AdminController::class)->group(function (){
        Route::get('admin/dashboard','adminDashboard')->name('admin.dashboard');
        Route::get('admin/logout','adminLogout')->name('admin.logout');
});
});
//end

//vendor
route::group(['prefix'=>'vendor'],function (){
    Route::controller(VendorController::class)->group(function(){
        Route::get('/login','loginForm')->name('vendor.login.form');
        Route::post('/login','Login')->name('vendor.login');

    });
});

Route::middleware(['auth','role:vendor'])->group(function (){
    Route::group(['prefix'=>'vendor'],function(){
        Route::controller(VendorController::class)->group(function (){
            Route::get('/dashboard','vendorDashboard')->name('vendor.dashboard');
            Route::get('/logout','Logout')->name('vendor.logout');
            Route::get('/profile','Profile')->name('vendor.profile.view');
            Route::post('/profile/store','profileStore')->name('vendor.profile.store');
            Route::get('/change/password','changePassword')->name('vendor.change.password');
            Route::post('/update/password','updatePassword')->name('vendor.update.password');
        });
    }) ;
});
//end


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
