<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Backend\BannerController;
use App\Http\Controllers\Backend\BrandController;
use App\Http\Controllers\Backend\CategoryController;
use App\Http\Controllers\Backend\ProductController;
use App\Http\Controllers\Backend\SliderController;
use App\Http\Controllers\Backend\SubCategoryController;
use App\Http\Controllers\Backend\VendorProductController;
use App\Http\Controllers\Frontend\IndexController;
use App\Http\Controllers\Frontend\CartController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\User\CompareController;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\User\WishlistController;
use App\Http\Controllers\Vendor\VendorController;
use App\Http\Middleware\RedirectIfAuthenticated;
use App\Models\SubCategory;
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

// Route::get('/', function () {
//     return view('frontend.index');
// });

Route::get('/',[IndexController::class,'Index'])->name('home');
// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');
//user
Route::middleware(['auth','role:user'])->group(function (){
    Route::controller(UserController::class)->group(function (){
        Route::get('/dashboard','userDashboard')->name('dashboard');
        Route::post('/user/profile/store','userProfileStore')->name('user.profile.store');
        Route::get('/user/logout','userLogout')->name('user.logout');
        Route::post('/user/update/password','userUpdatePassword')->name('user.update.password');
    });

    //wishlist
    Route::controller(WishlistController::class)->group(function(){
        Route::get('/wishlist','allWishlist')->name('wishlist');
        Route::get('/get-wishlist-product','getWishlistProduct');
        Route::get('/remove/product/wishlist/{id}','removeWishlist');
    });
    //end
    //compare
    Route::controller(CompareController::class)->group(function (){
        Route::get('/compare','Compare')->name('compare');
        Route::get('get/compare/product','getCompare');
        Route::get('remove/compare/product/{id}','removeCompare');
    });
    //end

     //my cart view
     Route::controller(CartController::class)->group(function(){
        Route::get('/mycart','myCart')->name('mycart');
        Route::get('get/my/cart','getMyCart');
        Route::get('remove/cart/{rowId}','removeCart');
        Route::get('cart/decrement/{rowId}','cartDecrement');
        Route::get('cart/increment/{rowId}','cartIncrement');

    });
    //end
    
    });
    //compare
    Route::controller(CompareController::class)->group(function(){
        Route::post('add/product/compare','addToCompareProduct');
    });
    //end

   
    
//end

//admin
Route::group(['prefix'=>'admin'],function (){
    Route::controller(AdminController::class)->group(function (){
        Route::get('/login','adminLoginForm')->name('admin.login')->middleware('guest');
        Route::post('/login','adminLogin')->name('alogin');
        
    });
   
});
Route::middleware(['auth','role:admin'])->group(function (){
    Route::controller(AdminController::class)->group(function (){
        Route::get('admin/dashboard','adminDashboard')->name('admin.dashboard');
        Route::get('admin/logout','adminLogout')->name('admin.logout');
        Route::get('/profile', 'AdminProfile')->name('admin.profile');
        Route::post('/profile/store', 'AdminProfileStore')->name('admin.profile.store');
        Route::get('/change/password', 'AdminChangePassword')->name('admin.change.password');
        Route::post('/update/password','AdminUpdatePassword')->name('update.password');
        Route::get('/inactive/vendor','inActiveVendor')->name('inactive.vendor');
        Route::get('/active/vendor','activeVendor')->name('active.vendor');
        Route::get('/inactive/vendor/details/{id}','inActiveVendorDetails')->name('inactive.vendor.details');
        Route::post('active/vendor/approve','activeVendorApprove')->name('active.vendor.approve');
        Route::get('active/vendor/details/{id}','activeVendorDetails')->name('active.vendor.details');
        Route::post('inactive/vendor/approve','inActiveVendorApprove')->name('inactive.vendor.approve');

    });
   Route::resource('brands',BrandController::class);
   Route::resource('categories',CategoryController::class);
   Route::resource('subcategories',SubCategoryController::class);
   //load subcategory for cateory
   Route::get('/subcategory/ajax/{id}',[SubCategoryController::class,'getSubCategory']);
   Route::post('postsubcategory',[SubCategoryController::class,'postSubCategory'])->name('getdata');
   //end
   Route::resource('products',ProductController::class);
   Route::controller(ProductController::class)->group(function (){
    Route::post('/update/product/thambnail','updateThambnail')->name('update.thambnail');
    Route::post('/update/product/multi/images','updateMultiImages')->name('update.multi.images');
    Route::get('delete/product/multi-image/{id}','deleteMultiImage')->name('delete.multi.image');
    Route::get('product/inactive/{id}','productInActive')->name('product.inactive');
    Route::get('product/active/{id}','productActive')->name('product.active');
   });
   Route::resource('sliders',SliderController::class);
   Route::resource('banners',BannerController::class);
  
});
//end

//vendor
route::group(['prefix'=>'vendor'],function (){
    Route::controller(VendorController::class)->group(function(){
        Route::get('/login','loginForm')->name('vendor.login.form')->middleware('guest');
        Route::post('/login','Login')->name('vendor.login');
        Route::get('/become/vendor','becomeVendor')->name('become.vendor');
        Route::post('/vendor/register','vendorRegister')->name('vendor.register');

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
        Route::resource('all/vendorproducts',VendorProductController::class);
        Route::controller(VendorProductController::class)->group(function (){
            Route::get('/subcategory/ajax/{category_id}','vendorGetSubCategory');
            Route::post('/vendor/update/product/thambnail' , 'vendorUpdateProductThabnail')
            ->name('vendor.update.product.thambnail');
            Route::post('/vendor/update/product/multiimage' , 'vendorUpdateProductmultiImage')
            ->name('vendor.update.product.multiimage');
            Route::get('/vendor/product/multiimg/delete/{id}' , 'vendorMultiimgDelete')
            ->name('vendor.product.multiimg.delete');
            Route::get('/vendor/product/inactive/{id}' , 'vendorProductInactive')
            ->name('vendor.product.inactive');
            Route::get('/vendor/product/active/{id}' , 'vendorProductActive')
            ->name('vendor.product.active');
        });
    }); 
});
//end


//FRONTEND DETAILS ALL ROUTE
Route::controller(IndexController::class)->group(function(){
    Route::get('product/details/{id}/{slug}','productDetails')
    ->name('product.details');
    Route::get('vendor/details/{id}','vendorDetails')
    ->name('vendor.details');
    Route::get('vendor/all','vendorAll')->name('vendor.all');
    Route::get('product/category/{id}/{slug}','catHeaderProduct')->name('product.category');
    Route::get('product/subcategory/{id}/{slug}','subcatHeaderProduct');
    Route::get('product/view/model/{id}','prodcutViewModel');

});
   
//END

//ADD TO CART WITH AJAX
Route::controller(CartController::class)->group(function(){
    //add to cart product details
    Route::post('detailcart/data/store','detailcartDataStore');
    //end
    //add to cart quick view
    Route::post('cart/data/store','cartDataStore');
    //end
    // CART DETAIL PRODCUT REMOVE
    Route::get('minicart/product/remove/{rowId}','minicartProductRemove');
    //END
    //MINI CART
    Route::get('/product/mini/cart','AddMiniCart');
    //END
    //MINI CART PRODCUT REMOVE
    Route::get('minicart/product/remove/{rowId}','minicartProductRemove');
    //END
});
//END

//ADD PRODUCT TO WISHLIST
Route::controller(WishlistController::class)->group(function(){
    Route::post('add/product/wishlist','addProductWishlist');
});
//END

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
