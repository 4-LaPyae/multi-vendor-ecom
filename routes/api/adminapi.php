<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminController;

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
Route::middleware(['auth:sanctum','role:admin'])->group(function (){
    Route::controller(AdminController::class)->group(function (){
        Route::get('admin/dashboard','adminDashboard')->name('admin.dashboard');
        Route::post('admin/logout','adminLogout')->name('admin.logout');
});
});