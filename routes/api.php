<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AppController;
use App\Http\Controllers\DeliveryBoyAppController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::controller(AppController::class)->group(function(){
    Route::post('/userRegistration','userRegistration');
    Route::post('/userLogin','userLogin');
    Route::get('/compAnnouncement','compAnnouncement');
    Route::get('/dealsoftheDay','dealsoftheDay');
    Route::get('/recentlyViewed','recentlyViewed');
    Route::get('/bestDiscount','bestDiscount');
    Route::get('/ecomCategory','ecomCategory');
    Route::post('/ecomSubcategory','ecomSubcategory');
    Route::post('/ecomMegacategory','ecomMegacategory');
    Route::get('/services','services');
    Route::get('/newlyAddedproducts','newlyAddedproducts');
    Route::post('/productDetails','productDetails');
    Route::post('/getproductSize','getproductSize');
    Route::post('/productforMegacategry','productforMegacategry');
    Route::post('/addCart','addCart');
    Route::post('/removeCart','removeCart');
    Route::post('/changeSize','changeSize');
    Route::post('/changeQty','changeQty');
    Route::post('/cartDetails','cartDetails');
    Route::get('/razorpayDetails','razorpayDetails');
    
    Route::post('/wishlistDetails','wishlistDetails');
    Route::post('/addWishlist','addWishlist');
    Route::post('/removeWishlist','removeWishlist');
    Route::post('/removeWishlistByProduct','removeWishlistByProduct');
    
    Route::get('/stateList','stateList');
    
    Route::post('/addAddress','addAddress');
    Route::post('/activeAddress','activeAddress');
    Route::post('/fetchAddress','fetchAddress');
    Route::post('/removeAddress','removeAddress');
    
    Route::post('/fetchProfile','fetchProfile');
    Route::post('/updateUserProfile','updateUserProfile');
    
    Route::post('/searchProduct','searchProduct');
    Route::post('/filterProduct','filterProduct');
    Route::get('/ecommercebanners','ecommercebanners');
    Route::post('/placeOrder','placeOrder');
    Route::post('/allUserOrders','allUserOrders');
    Route::post('/userOrderDetails','userOrderDetails');

    Route::get('/topRatedProducts','topRatedProducts');
    Route::get('/productsOnSale','productsOnSale');
    Route::post('/specificProduct','specificProduct');
    Route::get('/ratings/{id}','allRatings');
    Route::post('/saveRating','saveRating');

    Route::get('/searchHistory/{id}','searchHistory');
    Route::post('/saveHistory','saveHistory');

    Route::get('/searchedProduct/{id}','searchedProduct');
    Route::post('/saveSearchedProduct','saveSearchedProduct');
    
    
});



Route::controller(DeliveryBoyAppController::class)->group(function(){
    Route::post('/deliveryBoyRegistration','deliveryBoyRegistration');
    Route::post('/deliveryBoyLogin','deliveryBoyLogin');
    Route::post('/updatePersonalInfo','updatePersonalInfo');
    Route::get('/getProfile/{id}','getProfile');
    Route::get('/getOtherDetails/{id}','getOtherDetails');
    Route::post('/updateProfile','updateProfile');
    Route::post('/savePersonalDocument','savePersonalDocument');
    Route::post('/saveWorkPreference','saveWorkPreference');
    Route::post('/saveVehicleDetail','saveVehicleDetail');
    Route::get('/dashboard/{id}','dashboard');
    Route::post('/updateOrderStatus/{id}','updateOrderStatus');
    Route::get('/transactions/{id}','getTransactions');
    Route::post('/allOrders','allOrders');
    Route::post('/orderDetails','orderDetails');
    Route::post('/updateCurrentLocation','updateCurrentLocation');
    Route::post('/saveBankDetail','saveBankDetail');
    Route::post('/makePayment','makePayment');
    //Route::post('/withDrawAmount','withDrawAmount');
    
    
});
