<?php
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ZoneController;
use App\Http\Controllers\ZonepartnerController;
use App\Http\Controllers\CompAnnouncementController;
use App\Http\Controllers\DealsoftheDayController;
use App\Http\Controllers\RecentlyviewedController;
use App\Http\Controllers\BestDiscountController;
use App\Http\Controllers\ZonalFranchiseController;
use App\Http\Controllers\DistrictFranchiseController;
use App\Http\Controllers\BlockFranchiseController;
use App\Http\Controllers\DistrictpartnerController;
use App\Http\Controllers\BlockpartnerController;
use App\Http\Controllers\EmployeeFranchiseController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\MerchantFranchiseController;
use App\Http\Controllers\MerchantController;
use App\Http\Controllers\WebsitebannerController;
use App\Http\Controllers\EcommercebannerController;
use App\Http\Controllers\CategorybannerController;
use App\Http\Controllers\ClientReviewController;
use App\Http\Controllers\SubcategoryController;
use App\Http\Controllers\MegacategoryController;
use App\Http\Controllers\SegmentController;
use App\Http\Controllers\SubSegmentController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\SubGroupController;
use App\Http\Controllers\TeamMemberController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\MonthlyfeeController;
use App\Http\Controllers\DeliverytypeController;
use App\Http\Controllers\MerchanttypeController;
use App\Http\Controllers\AdvertisementChargeController;
use App\Http\Controllers\ServiceChargeController;
use App\Http\Controllers\MerchantShopController;
use App\Http\Controllers\MerchantOrderController;
use App\Http\Controllers\SchemeController;
use App\Http\Controllers\BrochureController;
use App\Http\Controllers\FrequentQuestionController;
// use App\Http\Middleware\Clear_Cache;
use App\Http\Middleware\Clear_Cache;
use Illuminate\Support\Facades\Route;
use App\Models\Admin;
use App\Models\Zonepartner;
use App\Models\Districtpartner;
use App\Models\Blockpartner;
use App\Models\Employee;
use App\Models\Merchant;
// use App\Models\Districtpartner;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Cache;

// Frontend Routes Start Here..........................................
Route::controller(HomeController::class)->group(function(){
    Route::get('/','index');
    Route::get('/about-us','about_us');
    Route::get('/mission','mission');
    Route::get('/services','services');
    Route::get('/block-franchise','block_franchise');
    Route::get('/district-franchise','district_franchise');
    Route::get('/zonal-franchise','zonal_franchise');
    Route::get('/career','career');
    Route::get('/contact-us','contact_us');
    Route::get('/thankyou','thankyou');
    Route::post('/submit_contact','submit_contact');
});

// Frontend Routes End Here..........................................


Route::post('/user/register', [UserController::class , 'newuser']);
Route::post('/user/loging', [UserController::class , 'login']);
Route::get('/user/logout', [UserController::class , 'logout']);
Route::get('/user/cart', [UserController::class , 'cart']);
Route::get('Qunantiy/update', [UserController::class , 'change_qnty']);
Route::get('product/del', [UserController::class , 'delete_product_cart']);
Route::get('user/addcart', [UserController::class , 'AddToCart']);
Route::get('user/BuyNow', [UserController::class , 'AddBuy']);
Route::get('get/category/{id}', [UserController::class , 'getcategory']);
Route::get('/Product/Search', [UserController::class , 'ProductSerach']);
Route::post('user/update/profile', [UserController::class , 'Profile_Update']);


Route::view('/Product/Show/{id}','Shoping_Store.Product');

Route::view('/shoping','Shoping_Store.index');
Route::view('/user/Account/Setting','Shoping_Store.Account_Setting');
Route::view('/addcart','Shoping_Store.cart');
Route::view('/Checkout/{id}','Shoping_Store.Checkout');
Route::view('/product/{id}','Shoping_Store.Single_product');


// Admin Routes Start Here################################################
Route::controller(AdminController::class)->group(function(){
    Route::get('/admin','index');
    Route::post('/admin_login','admin_login');
    Route::get('/admin/admin_logout','admin_logout');
});
Route::group(['middleware'=>'admin'],function(){
    Route::middleware([Clear_Cache::class])->group(function () {
    Route::get('/admin/dashboard',[AdminController::class,'dashboard']);
    Route::get('/admin/profile',[AdminController::class,'profile']);
    Route::post('/admin/update_profile',[AdminController::class,'update_profile']);
    Route::post('/admin/update_password',[AdminController::class,'update_password']);
    Route::get('/admin/change-password',[AdminController::class,'change_password']);

    Route::get('/admin/business-details',[AdminController::class,'business_details']);

    Route::get('/admin/generate-report',[AdminController::class,'generateBusinessReport']);

    Route::resource('/admin/user', UserController::class);
    Route::resource('/admin/service', ServiceController::class);
    Route::resource('/admin/category', CategoryController::class);
    Route::resource('/admin/subcategory', SubcategoryController::class);
     Route::resource('/admin/megacategory', MegacategoryController::class);
     Route::post('/admin/get_subcategory', [MegacategoryController::class,'get_subcategory']);
     
     Route::resource('/admin/Segment', SegmentController::class);
     Route::post('/admin/Segment/get_subcategory', [SegmentController::class,'get_subcategory']);
     Route::post('/admin/Segment/get_megacategory', [SegmentController::class,'get_megacategory']);

     Route::resource('/admin/SubSegment', SubSegmentController::class);
     Route::post('/admin/SubSegment/get_subcategory', [SubSegmentController::class,'get_subcategory']);
     Route::post('/admin/SubSegment/get_megacategory', [SubSegmentController::class,'get_megacategory']);
     Route::post('/admin/SubSegment/get_Segment', [SubSegmentController::class,'get_Segment']);


     Route::resource('/admin/Group', GroupController::class);
     Route::post('/admin/Group/get_subcategory', [GroupController::class,'get_subcategory']);
     Route::post('/admin/Group/get_megacategory', [GroupController::class,'get_megacategory']);
     Route::post('/admin/Group/get_Segment', [GroupController::class,'get_Segment']);
     Route::post('admin/Group/get_SubSegment', [GroupController::class,'get_SubSegment']);


     Route::resource('/admin/SubGroup', SubGroupController::class);
     Route::post('/admin/SubGroup/get_subcategory', [SubGroupController::class,'get_subcategory']);
     Route::post('/admin/SubGroup/get_megacategory', [SubGroupController::class,'get_megacategory']);
     Route::post('/admin/SubGroup/get_Segment', [SubGroupController::class,'get_Segment']);
     Route::post('/admin/SubGroup/get_SubSegment', [SubGroupController::class,'get_SubSegment']);
     Route::post('/admin/SubGroup/get_Group', [SubGroupController::class,'get_Group']);

    Route::resource('/admin/zone', ZoneController::class);
    Route::resource('/admin/zonepartner', ZonepartnerController::class);

    Route::get('/admin/districtpartner', [DistrictpartnerController::class,'index']);
    Route::get('/admin/districtpartner/edit/{id}', [DistrictpartnerController::class, 'edit']);
    Route::post('/admin/districtpartner/update', [DistrictpartnerController::class, 'update']);
    Route::post('/admin/districtpartner/delete', [DistrictpartnerController::class, 'destroy']);

    Route::get('/admin/blockpartner', [BlockpartnerController::class,'index']);
    Route::get('/admin/blockpartner/edit/{id}', [BlockpartnerController::class, 'edit']);
    Route::post('/admin/blockpartner/update', [BlockpartnerController::class, 'update']);
    Route::post('/admin/blockpartner/delete', [BlockpartnerController::class, 'destroy']);


    Route::get('/admin/employee', [EmployeeController::class,'index']);
    Route::get('/admin/employee/edit/{id}', [EmployeeController::class, 'edit']);
    Route::post('/admin/employee/update', [EmployeeController::class, 'update']);
    Route::post('/admin/employee/delete', [EmployeeController::class, 'destroy']);

    Route::get('/admin/merchant', [MerchantController::class,'index']);
    Route::get('/admin/merchant/edit/{id}', [MerchantController::class, 'edit']);
    Route::post('/admin/merchant/update', [MerchantController::class, 'update']);
    Route::post('/admin/merchant/delete', [MerchantController::class, 'destroy']);

    Route::resource('/admin/websitebanner', WebsitebannerController::class);
    Route::get('/admin/websitebanner/edit/{id}', [WebsitebannerController::class, 'edit']);
    Route::post('/admin/websitebanner/update', [WebsitebannerController::class, 'update']);
    Route::post('/admin/websitebanner/delete', [WebsitebannerController::class, 'destroy']);

    Route::resource('/admin/ecommercebanner', EcommercebannerController::class);
    Route::get('/admin/ecommercebanner/edit/{id}', [EcommercebannerController::class, 'edit']);
    Route::post('/admin/ecommercebanner/update', [EcommercebannerController::class, 'update']);
    Route::post('/admin/ecommercebanner/delete', [EcommercebannerController::class, 'destroy']);

    Route::resource('/admin/categorybanner', CategorybannerController::class);
    Route::get('/admin/categorybanner/edit/{id}', [CategorybannerController::class, 'edit']);
    Route::post('/admin/categorybanner/update', [CategorybannerController::class, 'update']);
    Route::post('/admin/categorybanner/delete', [CategorybannerController::class, 'destroy']);

    Route::resource('/admin/company-announcement', CompAnnouncementController::class);
    Route::get('/admin/company-announcement/edit/{id}', [CompAnnouncementController::class, 'edit']);
    Route::post('/admin/company-announcement/update', [CompAnnouncementController::class, 'update']);
    Route::post('/admin/company-announcement/delete', [CompAnnouncementController::class, 'destroy']);

    Route::resource('/admin/deals-of-the-day', DealsoftheDayController::class);
    Route::get('/admin/deals-of-the-day/edit/{id}', [DealsoftheDayController::class, 'edit']);
    Route::post('/admin/deals-of-the-day/update', [DealsoftheDayController::class, 'update']);
    Route::post('/admin/deals-of-the-day/delete', [DealsoftheDayController::class, 'destroy']);

    Route::resource('/admin/recently-viewed', RecentlyviewedController::class);
    Route::get('/admin/recently-viewed/edit/{id}', [RecentlyviewedController::class, 'edit']);
    Route::post('/admin/recently-viewed/update', [RecentlyviewedController::class, 'update']);
    Route::post('/admin/recently-viewed/delete', [RecentlyviewedController::class, 'destroy']);

    Route::resource('/admin/best-discount', BestDiscountController::class);
    Route::get('/admin/best-discount/edit/{id}', [BestDiscountController::class, 'edit']);
    Route::post('/admin/best-discount/update', [BestDiscountController::class, 'update']);
    Route::post('/admin/best-discount/delete', [BestDiscountController::class, 'destroy']);
    
    Route::resource('/admin/teammember', TeamMemberController::class);
    Route::get('/admin/teammember/edit/{id}', [TeamMemberController::class, 'edit']);
    Route::post('/admin/teammember/update', [TeamMemberController::class, 'update']);
    Route::post('/admin/teammember/delete', [TeamMemberController::class, 'destroy']);

    Route::resource('/admin/clientreview', ClientReviewController::class);
    Route::get('/admin/clientreview/edit/{id}', [ClientReviewController::class, 'edit']);
    Route::post('/admin/clientreview/update', [ClientReviewController::class, 'update']);
    Route::post('/admin/clientreview/delete', [ClientReviewController::class, 'destroy']);
    
    Route::get('/admin/razorpay', [AdminController::class, 'razorpay']);
    Route::post('/admin/update_razorpay', [AdminController::class, 'update_razorpay']);
    
    Route::resource('/admin/monthlyfee', MonthlyfeeController::class);
    Route::resource('/admin/deliverytype', DeliverytypeController::class);
    Route::resource('/admin/merchanttype', MerchanttypeController::class);
    Route::resource('/admin/advertisementcharge', AdvertisementChargeController::class);
    Route::resource('/admin/schemes', SchemeController::class);
    Route::resource('/admin/servicecharge', ServiceChargeController::class);
    Route::resource('/admin/documents', BrochureController::class);
    Route::resource('/admin/frequent-questions', FrequentQuestionController::class);


});
    });
// Admin Routes End Here####################################################


// Zonal Franchise Routes Start Here################################################
Route::controller(ZonalFranchiseController::class)->group(function(){
    Route::get('/zonal-franchise','index');
    Route::post('/zonal-franchise/login','login');
    Route::get('/zonal-franchise/logout','logout');
});

Route::group(['middleware'=>'zonepartner'],function(){
    Route::get('/zonal-franchise/dashboard',[ZonalFranchiseController::class,'dashboard']);
    Route::get('/zonal-franchise/profile',[ZonalFranchiseController::class,'profile']);
    Route::post('/zonal-franchise/update_profile',[ZonalFranchiseController::class,'update_profile']);
    Route::get('/zonal-franchise/change-password',[ZonalFranchiseController::class,'change_password']);
    Route::post('/zonal-franchise/update_password',[ZonalFranchiseController::class,'update_password']);
    Route::get('/zonal-franchise/logout',[ZonalFranchiseController::class,'logout']);
    
    Route::get('/zonal-franchise/district-partner',[ZonalFranchiseController::class,'view_districtpartner']);
    Route::get('/zonal-franchise/districtpartner/create',[ZonalFranchiseController::class,'create_districtpartner']);
    Route::post('/zonal-franchise/districtpartner/store',[ZonalFranchiseController::class,'store_districtpartner']);
    Route::get('/zonal-franchise/districtpartner/edit/{id}', [ZonalFranchiseController::class, 'edit_districtpartner']);
    Route::post('/zonal-franchise/districtpartner/update', [ZonalFranchiseController::class, 'update_districtpartner']);
    Route::post('/zonal-franchise/districtpartner/delete', [ZonalFranchiseController::class, 'destroy_districtpartner']);
    Route::get('/zonal-franchise/payments', [ZonalFranchiseController::class,'payments']);
    Route::post('/zonal-franchise/make_payment', [ZonalFranchiseController::class,'make_payment']);
    Route::post('/zonal-franchise/get_amount', [ZonalFranchiseController::class,'get_amount']);
    Route::get('/check/payments/zonal', [ZonalFranchiseController::class,'check']);
    Route::get('/zonal-franchise/block-partner',[ZonalFranchiseController::class,'view_blockpartner']);
    Route::get('/zonal-franchise/employee',[ZonalFranchiseController::class,'view_employee']);
    Route::get('/zonal-franchise/merchant',[ZonalFranchiseController::class,'view_merchant']);
    
    Route::get('/zonal-franchise/business-details',[ZonalFranchiseController::class,'business_details']);
    Route::get('/zonal-franchise/generate-report',[ZonalFranchiseController::class,'generateBusinessReport']);

    Route::get('/zonal-franchise/wallet', [ZonalFranchiseController::class,'wallet']);

    });
// Zonal Franchise Routes End Here################################################


// District Franchise Routes Start Here################################################
Route::controller(DistrictFranchiseController::class)->group(function(){
    Route::get('/district-franchise','index');
    Route::post('/district-franchise/login','login');
    Route::get('/district-franchise/logout','logout');
});

Route::group(['middleware'=>'districtpartner'],function(){
    Route::get('/district-franchise/dashboard',[DistrictFranchiseController::class,'dashboard']);
    Route::get('/district-franchise/profile',[DistrictFranchiseController::class,'profile']);
    Route::post('/district-franchise/update_profile',[DistrictFranchiseController::class,'update_profile']);
    Route::get('/district-franchise/change-password',[DistrictFranchiseController::class,'change_password']);
    Route::post('/district-franchise/update_password',[DistrictFranchiseController::class,'update_password']);
    Route::get('/district-franchise/logout',[DistrictFranchiseController::class,'logout']);

    Route::get('/district-franchise/blockpartner',[DistrictFranchiseController::class,'view_blockpartner']);
    Route::get('/district-franchise/blockpartner/create',[DistrictFranchiseController::class,'create_blockpartner']);
    Route::post('/district-franchise/blockpartner/store',[DistrictFranchiseController::class,'store_blockpartner']);
    Route::get('/district-franchise/blockpartner/edit/{id}', [DistrictFranchiseController::class, 'edit_blockpartner']);
    Route::post('/district-franchise/blockpartner/update', [DistrictFranchiseController::class, 'update_blockpartner']);
    Route::post('/district-franchise/blockpartner/delete', [DistrictFranchiseController::class, 'destroy_blockpartner']);

    Route::get('/district-franchise/generate-report',[DistrictFranchiseController::class,'generateBusinessReport']);

    Route::get('/district-franchise/business-details',[DistrictFranchiseController::class,'business_details']);
    Route::get('/district-franchise/payments', [DistrictFranchiseController::class,'payments']);
    Route::post('/district-franchise/make_payment', [DistrictFranchiseController::class,'make_payment']);
    Route::post('/district-franchise/get_amount', [DistrictFranchiseController::class,'get_amount']);
    Route::get('/check/payments/district', [DistrictFranchiseController::class,'check']);
    Route::get('/district-franchise/employee',[DistrictFranchiseController::class,'view_employee']);
    Route::get('/district-franchise/merchant',[DistrictFranchiseController::class,'view_merchant']);
    
    Route::get('/district-franchise/wallet', [DistrictFranchiseController::class,'wallet']);
    });
// District Franchise Routes End Here################################################


// Block Franchise Routes Start Here################################################
Route::controller(BlockFranchiseController::class)->group(function(){
    Route::get('/block-franchise','index');
    Route::post('/block-franchise/login','login');
    Route::get('/block-franchise/logout','logout');
});

Route::group(['middleware'=>'blockpartner'],function(){
    Route::get('/block-franchise/dashboard',[BlockFranchiseController::class,'dashboard']);
    Route::get('/block-franchise/profile',[BlockFranchiseController::class,'profile']);
    Route::post('/block-franchise/update_profile',[BlockFranchiseController::class,'update_profile']);
    Route::get('/block-franchise/change-password',[BlockFranchiseController::class,'change_password']);
    Route::post('/block-franchise/update_password',[BlockFranchiseController::class,'update_password']);
    Route::get('/block-franchise/logout',[BlockFranchiseController::class,'logout']);
    Route::get('/block-franchise/business-details',[BlockFranchiseController::class,'business_details']);
    Route::get('/block-franchise/employee',[BlockFranchiseController::class,'view_employee']);
    Route::get('/block-franchise/employee/create',[BlockFranchiseController::class,'create_employee']);
    Route::post('/block-franchise/employee/store',[BlockFranchiseController::class,'store_employee']);
    Route::get('/block-franchise/employee/edit/{id}', [BlockFranchiseController::class, 'edit_employee']);
    Route::post('/block-franchise/employee/update', [BlockFranchiseController::class, 'update_employee']);
    Route::post('/block-franchise/employee/delete', [BlockFranchiseController::class, 'destroy_employee']);

    Route::get('/block/generate-report',[BlockFranchiseController::class,'generateBusinessReport']);

    Route::get('/block-franchise/payments', [BlockFranchiseController::class,'payments']);
    Route::post('/block-franchise/make_payment', [BlockFranchiseController::class,'make_payment']);
    Route::post('/block-franchise/get_amount', [BlockFranchiseController::class,'get_amount']);
    Route::get('/check/payments/block', [BlockFranchiseController::class,'check']);
    Route::get('/block-franchise/merchant',[BlockFranchiseController::class,'view_merchant']);
    
    Route::get('/block-franchise/wallet', [BlockFranchiseController::class,'wallet']);
    });
// District Franchise Routes End Here################################################


// Employee Franchise Routes Start Here################################################
Route::controller(EmployeeFranchiseController::class)->group(function(){
    Route::get('/employee','index');
    Route::post('/employee/login','login');
    Route::get('/employee/logout','logout');
});

Route::group(['middleware'=>'employee'],function(){
    Route::get('/employee/dashboard',[EmployeeFranchiseController::class,'dashboard']);
    Route::get('/employee/profile',[EmployeeFranchiseController::class,'profile']);
    Route::post('/employee/update_profile',[EmployeeFranchiseController::class,'update_profile']);
    Route::get('/employee/change-password',[EmployeeFranchiseController::class,'change_password']);
    Route::post('/employee/update_password',[EmployeeFranchiseController::class,'update_password']);
    Route::get('/employee/logout',[EmployeeFranchiseController::class,'logout']);

    Route::get('/employee/merchant',[EmployeeFranchiseController::class,'view_merchant']);
    Route::get('/employee/business-details',[EmployeeFranchiseController::class,'business_details']);
    Route::get('/employee/merchant/create',[EmployeeFranchiseController::class,'create_merchant']);
    Route::post('/employee/merchant/store',[EmployeeFranchiseController::class,'store_merchant']);
    Route::get('/employee/merchant/edit/{id}', [EmployeeFranchiseController::class, 'edit_merchant']);
    Route::post('/employee/merchant/update', [EmployeeFranchiseController::class, 'update_merchant']);
    Route::post('/employee/merchant/delete', [EmployeeFranchiseController::class, 'destroy_merchant']);
    Route::get('/check/payments/employee', [EmployeeFranchiseController::class,'check']);
    Route::get('/employee/wallet', [EmployeeFranchiseController::class,'wallet']);
    Route::post('/employee/generate-report',[EmployeeFranchiseController::class,'generateBusinessReport']);

        Route::get('/employee/payments', [EmployeeFranchiseController::class,'payments']);
    Route::post('/employee/make_payment', [EmployeeFranchiseController::class,'make_payment']);
    Route::post('/employee/get_amount', [EmployeeFranchiseController::class,'get_amount']);

    
    Route::post('/employee/merchant-shops/update/{id}', [MerchantShopController::class, 'updateShop']);
    Route::post('/employee/merchant-shops/delete/{id}', [MerchantShopController::class, 'deleteShop']);
    Route::resource('/employee/merchant-shops', MerchantShopController::class);
    
    });
// Employee Franchise Routes End Here################################################


// Merchant Franchise Routes Start Here################################################
Route::controller(MerchantFranchiseController::class)->group(function(){
    Route::get('/merchant','index');
    Route::post('/merchant/login','login');
    Route::get('/merchant/logout','logout');
});

Route::group(['middleware'=>'merchant'],function(){
    Route::get('/merchant/dashboard',[MerchantFranchiseController::class,'dashboard']);
    Route::get('/merchant/profile',[MerchantFranchiseController::class,'profile']);
    Route::post('/merchant/update_profile',[MerchantFranchiseController::class,'update_profile']);
    Route::get('/merchant/change-password',[MerchantFranchiseController::class,'change_password']);
    Route::post('/merchant/update_password',[MerchantFranchiseController::class,'update_password']);
    Route::get('/merchant/logout',[MerchantFranchiseController::class,'logout']);
    
    Route::resource('/merchant/product', ProductController::class);
    Route::post('/merchant/get_subcategory', [ProductController::class,'get_subcategory']);
    Route::post('/merchant/get_megacategory', [ProductController::class,'get_megacategory']);
    Route::post('/merchant/get_Segment', [ProductController::class,'get_Segment']);
    Route::post('/merchant/get_SubSegment', [ProductController::class,'get_SubSegment']);
    Route::post('/merchant/get_Group', [ProductController::class,'get_Group']);
    Route::post('/merchant/get_SubGroup', [ProductController::class,'get_SubGroup']);
    
    Route::get('/merchant/wallet', [MerchantFranchiseController::class,'wallet']);
    Route::post('/merchant/get_amount', [MerchantFranchiseController::class,'get_amount']);
    Route::get('/merchant/payments', [MerchantFranchiseController::class,'payment']);
    Route::post('/merchant/make_payment', [MerchantFranchiseController::class,'make_payment']);
    Route::get('/check/payments', [MerchantFranchiseController::class,'check']);
    Route::get('/merchant/new-orders', [MerchantOrderController::class,'index']);
    Route::get('/merchant/accepted-orders', [MerchantOrderController::class,'acceptedOrders']);
    Route::get('/merchant/completed-orders', [MerchantOrderController::class,'completedOrders']);
    Route::get('/merchant/cancelled-orders', [MerchantOrderController::class,'cancelledOrders']);
    Route::post('/merchant/accept-order', [MerchantOrderController::class,'acceptOrder']);
    Route::post('/merchant/cancel-order', [MerchantOrderController::class,'cancelOrder']);

    
    });
// Merchant Franchise Routes End Here################################################
Route::get('/Reg_admin',function(){
    $pasword = 123456;
    $pass = Hash::make($pasword);
    $admin =  Admin::where('email','admin@gmail.com')->first();
    $admin->password=$pass;
    $admin->update();
  
   // print_r($admin['password']);
  
  });
  
  Route::get('/Reg_Zone',function(){
      $pasword = 123456;
      $pass = Hash::make($pasword);
      $admin =  Zonepartner::where('email','a.agarwalla07@gmail.com')->first();
    //   $admin =  Zonepartner::where('email','hindkartmurshidabad@gmail.com')->first();
      $admin->password=$pass;
      $admin->update();
    
    //print_r($admin);
    
    });
    Route::get('/Reg_Distric',function(){
      $pasword = 123456;
      $pass = Hash::make($pasword);
      $admin =  Districtpartner::where('email','district@gmail.com')->first();
      $admin->password=$pass;
      $admin->update();
    
    //   print_r($admin);
    
    });
    Route::get('/Reg_Block',function(){
      $pasword = 123456;
      $pass = Hash::make($pasword);
      $admin =  Blockpartner::where('email','block@gmail.com')->first();
      $admin->password=$pass;
      $admin->update();
    
    //   print_r($admin);
    
    });  
    
      Route::get('/Reg_employ',function(){
      $pasword = 123456;
      $pass = Hash::make($pasword);
      $admin =  Employee::where('email','employee@gmail.com')->first();
      $admin->password=$pass;
      $admin->update();
    
    //   print_r($admin);
    
    });   
    
    Route::get('/Reg_Merchant',function(){
      $pasword = 123456;
      $pass = Hash::make($pasword);
      $admin =  Merchant::where('email','merchant@gmail.com')->first();
      $admin->password=$pass;
      $admin->update();
    
    //   print_r($admin);
    
    });



    Route::get('/beast',function(){
   // $Cache= Cache::flush();
  
//    exit();
// dd($Cache);
 $emp =DB::table('blockpartners')->get();
// $table =DB::table('merchants')->where('employer_id' , $table->id)->get();
// $table =DB::table('merchant_payments')->where('merchant_id' , )->first();
$table =DB::table('merchants')->where('district_partner_id' , 2)->get();
// foreach ($bl_tables as $key => $table) {
//     $table_merchant_id =DB::table('merchants')->where('employer_id' , $table->id)->get();
//     $table =DB::table('merchant_payments')->where('merchant_id' ,$table_merchant_id )->get();
    
// }
// dd($bl_tables);
$data=[];
$sums_merchant_collection=0;
$sums_merchant_sub=0;
$sums_merchant_adv=0;

$total_sum_collection = 0; 
foreach ($emp as $key => $emps) {
    
    $merchant_id =DB::table('merchants')->where('block_partner_id' , $emps->id)->get();
    foreach ($merchant_id as $key => $value) {
        
    
    $merchant_collections = DB::table('merchant_payments')
    ->where('merchant_id', $value->id)
    ->where('type', 'registration')
    // ->whereDate('created_at', '>=', $from_date)
    // ->whereDate('created_at', '<=', $to_date)
    ->sum('amount');   
    
    $merchant_sub = DB::table('merchant_payments')
    ->where('merchant_id', $value->id)
    ->where('type', 'subscription')
    // ->whereDate('created_at', '>=', $from_date)
    // ->whereDate('created_at', '<=', $to_date)
    ->sum('amount'); 
    $merchant_adv = DB::table('merchant_payments')
    ->where('merchant_id', $value->id)
    ->where('type', 'advertise')
    // ->whereDate('created_at', '>=', $from_date)
    // ->whereDate('created_at', '<=', $to_date)
    ->sum('amount');
    $sums_merchant_collection= $sums_merchant_collection+ $merchant_collections;
    $sums_merchant_sub = $sums_merchant_sub +  $merchant_sub;
    $sums_merchant_adv = $sums_merchant_adv +   $merchant_adv;

    // $total_sum_collection+= $sums_merchant_collection + $sums_merchant_sub + $sums_merchant_adv + 100;
    // $sums_merchant_collection= $sums_merchant_collection+ $merchant_collections;
    // // echo  $sums_merchant_collection . "<br>";
    // $data[]=[
    //     'Collection' =>  $sums_merchant_collection,
    // ];
   
}
    // $name = $emps->name;
    $data[]=[
        'Name' => $emps->name,
            'Collection' =>  $sums_merchant_collection,
            'Sub' =>   $sums_merchant_sub,
            //'totalsum'=>  $total_sum
    ];
    $sums_merchant_collection=0;
    $sums_merchant_sub=0;

    
}
// foreach ($data as  $names) {
    
//     // echo "Name :" . $->name ."<br>";
//    echo  $names;
//     // echo "Collection : $data->Collection <br>";
// }
// echo '<pre>'; print_r($data); echo '</pre>';
foreach($data as $result) {
    echo $result['Name'] ."<br>";
    echo $result['Collection'] ."<br>";
    echo $result['Sub'] ."<br>";
    // echo $result['totalsum'] ."<br>";
    
}

// echo $total_sum_collection ;
$total_sum= 0;
// echo $sums;
//  dd($data);
// print_r($name);
$sum=0;
$total =0;
$total_advertize=0;
$total_collection = 0;
$record =[];
foreach( $table  as $tables){
    $record = DB::table('merchant_payments')
->where('merchant_id',$tables->id)
->where('type', 'registration')
// ->whereDate('created_at', '>=', $from_date)
// ->whereDate('created_at', '<=', $to_date)
->get();
    $merchant_collection = DB::table('merchant_payments')
                    ->where('merchant_id',$tables->id)
                    ->where('type', 'registration')
                    // ->whereDate('created_at', '>=', $from_date)
                    // ->whereDate('created_at', '<=', $to_date)
                    ->sum('amount');
                    
                    $merchant_collection_Sub = DB::table('merchant_payments')
                    ->where('merchant_id',$tables->id)
                    ->where('type', 'subscription')
                    // ->whereDate('created_at', '>=', $from_date)
                    // ->whereDate('created_at', '<=', $to_date)
                    ->sum('amount');
                    $adverise_collection_block_total = DB::table('merchant_payments')
                    ->where('merchant_id',  $tables->id)
                    ->where('type', 'advertise')
                    // ->whereDate('created_at', '>=', $from_date)
                    // ->whereDate('created_at', '<=', $to_date)
                    ->sum('amount');

                    // dd($merchant);
                    // $merchant_collection +=  $merchant_collection + 0;
                    $sum= $sum+ $merchant_collection;
                    $total += $merchant_collection_Sub;
                    $total_advertize += $adverise_collection_block_total;

                    $total_collection =    $sum + $total + 0 + $total_advertize;
                    // echo $merchant_collection . "<br>";

                    // echo($record);
                }
          echo   "Total sum reg_collection =  $sum <br>";
          echo   "Total sum sub_collection = $total <br>";
          echo   "Total sum adv_collection = $total_advertize <br>";
          echo   "Total sum total_collection = $total_collection <br>";
                // dd($tables->id);
 dd($emp);



    });


   Route::get('/test',function(){
// $Cache= Cache::flush();
// dd($Cache);
$emp =DB::table('employees')->where('block_partner_id' , 2)->get();
// $table =DB::table('merchants')->where('employer_id' , $table->id)->get();
// $table =DB::table('merchant_payments')->where('merchant_id' , )->first();
$table =DB::table('merchants')->where('block_partner_id' , 2)->get();
// foreach ($bl_tables as $key => $table) {
//     $table_merchant_id =DB::table('merchants')->where('employer_id' , $table->id)->get();
//     $table =DB::table('merchant_payments')->where('merchant_id' ,$table_merchant_id )->get();
    
// }
// dd($bl_tables);
$data=[];
$sums_merchant_collection=0;
$sums_merchant_sub=0;
$sums_merchant_adv=0;

$total_sum_collection = 0; 
foreach ($emp as $key => $emps) {
    
    $merchant_id =DB::table('merchants')->where('employer_id' , $emps->id)->get();
    foreach ($merchant_id as $key => $value) {
        
    
    $merchant_collections = DB::table('merchant_payments')
    ->where('merchant_id', $value->id)
    ->where('type', 'registration')
    // ->whereDate('created_at', '>=', $from_date)
    // ->whereDate('created_at', '<=', $to_date)
    ->sum('amount');   
    
    $merchant_sub = DB::table('merchant_payments')
    ->where('merchant_id', $value->id)
    ->where('type', 'subscription')
    // ->whereDate('created_at', '>=', $from_date)
    // ->whereDate('created_at', '<=', $to_date)
    ->sum('amount'); 
    $merchant_adv = DB::table('merchant_payments')
    ->where('merchant_id', $value->id)
    ->where('type', 'advertise')
    // ->whereDate('created_at', '>=', $from_date)
    // ->whereDate('created_at', '<=', $to_date)
    ->sum('amount');
    $sums_merchant_collection= $sums_merchant_collection+ $merchant_collections;
    $sums_merchant_sub = $sums_merchant_sub +  $merchant_sub;
    $sums_merchant_adv = $sums_merchant_adv +   $merchant_adv;

    // $total_sum_collection+= $sums_merchant_collection + $sums_merchant_sub + $sums_merchant_adv + 100;
    // $sums_merchant_collection= $sums_merchant_collection+ $merchant_collections;
    // // echo  $sums_merchant_collection . "<br>";
    // $data[]=[
    //     'Collection' =>  $sums_merchant_collection,
    // ];
   
}
    // $name = $emps->name;
    $data[]=[
        'Name' => $emps->name,
            'Collection' =>  $sums_merchant_collection,
            'Sub' =>   $sums_merchant_sub,
            //'totalsum'=>  $total_sum
    ];
    $sums_merchant_collection=0;
    $sums_merchant_sub=0;

    
}
// foreach ($data as  $names) {
    
//     // echo "Name :" . $->name ."<br>";
//    echo  $names;
//     // echo "Collection : $data->Collection <br>";
// }
// echo '<pre>'; print_r($data); echo '</pre>';
foreach($data as $result) {
    echo $result['Name'] ."<br>";
    echo $result['Collection'] ."<br>";
    echo $result['Sub'] ."<br>";
    // echo $result['totalsum'] ."<br>";
    
}

// echo $total_sum_collection ;
$total_sum= 0;
// echo $sums;
//  dd($data);
// print_r($name);
$sum=0;
$total =0;
$total_advertize=0;
$total_collection = 0;
$record =[];
foreach( $table  as $tables){
    $record = DB::table('merchant_payments')
->where('merchant_id',$tables->id)
->where('type', 'registration')
// ->whereDate('created_at', '>=', $from_date)
// ->whereDate('created_at', '<=', $to_date)
->get();
    $merchant_collection = DB::table('merchant_payments')
                    ->where('merchant_id',$tables->id)
                    ->where('type', 'registration')
                    // ->whereDate('created_at', '>=', $from_date)
                    // ->whereDate('created_at', '<=', $to_date)
                    ->sum('amount');
                    
                    $merchant_collection_Sub = DB::table('merchant_payments')
                    ->where('merchant_id',$tables->id)
                    ->where('type', 'subscription')
                    // ->whereDate('created_at', '>=', $from_date)
                    // ->whereDate('created_at', '<=', $to_date)
                    ->sum('amount');
                    $adverise_collection_block_total = DB::table('merchant_payments')
                    ->where('merchant_id',  $tables->id)
                    ->where('type', 'advertise')
                    // ->whereDate('created_at', '>=', $from_date)
                    // ->whereDate('created_at', '<=', $to_date)
                    ->sum('amount');

                    // dd($merchant);
                    // $merchant_collection +=  $merchant_collection + 0;
                    $sum= $sum+ $merchant_collection;
                    $total += $merchant_collection_Sub;
                    $total_advertize += $adverise_collection_block_total;

                    $total_collection =    $sum + $total + 0 + $total_advertize;
                    // echo $merchant_collection . "<br>";

                    // echo($record);
                }
          echo   "Total sum reg_collection =  $sum <br>";
          echo   "Total sum sub_collection = $total <br>";
          echo   "Total sum adv_collection = $total_advertize <br>";
          echo   "Total sum total_collection = $total_collection <br>";
                // dd($tables->id);
 dd($emp);



   });

   Route::get('date', function(){
//  $date1 =new Datetime('4-6-2023');
//  $date2 =new Datetime('4-6-2023');
//     // $date2=  date('4-6-2023');
//     $Result = $date1-$date2;

$product = DB::table('products')->where('created_at', '>', Carbon\Carbon::now()->subDay()->toDateTimeString())->get();
$now =Carbon\Carbon::now()->toDateTimeString();
$Carbon=Carbon\Carbon::now()->subSecond(10)->toDateTimeString();
echo "now =  $now  <br> old $Carbon";
dd($product);

 //    echo  date('4-6-2023');
 // echo  $date1->format('d-m-y');
   });