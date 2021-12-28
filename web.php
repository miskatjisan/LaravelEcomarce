<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AdminController;
use App\Http\Controllers\LogoutController;
use App\Http\Controllers\admin\AdminProfileController;
use App\Http\Controllers\frontend\UserController;
use App\Http\Controllers\backend\BrandController;
use App\Http\Controllers\backend\CategoryController;
use App\Http\Controllers\backend\SubCategoryController;
use App\Http\Controllers\backend\ProductController;
use App\Http\Controllers\backend\CouponController;
use App\Http\Controllers\backend\ShippingAreaController;
use App\Http\Controllers\backend\OrderController;
use App\Http\Controllers\backend\ReportController;
use App\Http\Controllers\backend\BlogController;
use App\Http\Controllers\backend\SiteSettingController;
use App\Http\Controllers\backend\ReturnController;
use App\Http\Controllers\backend\MenuController;
use App\Http\Controllers\backend\SliderController;
use App\Http\Controllers\backend\OthersController;
use App\Http\Controllers\backend\ContactUsController;
use App\Http\Controllers\backend\TestimonialsController;



use App\Http\Controllers\frontend\LanguageController;
use App\Http\Controllers\frontend\IndexController;
use App\Http\Controllers\frontend\CartController;
use App\Http\Controllers\frontend\WishlistController;
use App\Http\Controllers\frontend\CartPageController;
use App\Http\Controllers\frontend\CheckoutController;
use App\Http\Controllers\frontend\StripeController;
use App\Http\Controllers\frontend\CashController;
use App\Http\Controllers\frontend\AllUserController;
use App\Http\Controllers\frontend\HomeBlogController;
use App\Http\Controllers\frontend\ReviewController;
use App\Http\Controllers\frontend\ShopController;



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




Route::group(['prefix'=> 'admin', 'middleware'=>['admin:admin']], function(){
	Route::get('/login', [AdminController::class, 'loginForm']);
	Route::post('/login',[AdminController::class, 'store'])->name('admin.login');
    
});
Route::get('admin/logout',[AdminController::class, 'destroy'])->name('admin.logout')->middleware('auth:admin');



Route::middleware(['auth:sanctum,admin','verified'])->get('/admin/dashboard', function () {
    return view('admin.index_admin');
})->name('admin.dashboard')->middleware('auth:admin');


///////////////////////////////       Admin middleware Start       ///////////////////////////////

    Route::middleware(['auth:admin'])->group(function(){

        //admin profile section

        Route::get('admin/profile',[AdminProfileController::class, 'Admin_Profile'])->name('admin.profile');
        Route::get('admin/profile/change/username',[AdminProfileController::class, 'Admin_Username'])->name('change.username');
        Route::get('admin/profile/change/photo',[AdminProfileController::class, 'Admin_Photo'])->name('change.photo');
        Route::get('admin/profile/change/password',[AdminProfileController::class, 'Admin_Password'])->name('change.password');
        Route::post('admin/profile/change/username/succecssfully',[AdminProfileController::class, 'Change_Username'])->name('admin.change.username');
        Route::post('admin/profile/change/photo/succecssfully',[AdminProfileController::class, 'Change_Photo'])->name('admin.photo');
        Route::post('admin/profile/change/password/succecssfully',[AdminProfileController::class, 'Change_Password'])->name('admin.change.password');


        // Admin Brands Section


        Route::prefix('admin/brands')->group(function(){

            Route::get('/view',[BrandController::class, 'Brands_view'])->name('all.brands');
            Route::post('/add/successfull',[BrandController::class, 'Brands_Store'])->name('brand.store');
            Route::get('/edit/{id}',[BrandController::class, 'Brands_Edit'])->name('brand.edit');
            Route::post('/update/successfull',[BrandController::class, 'Brands_Update'])->name('brand.update');
            Route::get('/delete/{id}',[BrandController::class, 'Brands_Delete'])->name('brand.delete');
        });





        // Admin Category Section



        Route::prefix('/admin/categories')->group(function(){

            Route::get('/view',[CategoryController::class, 'Categories_view'])->name('all.category');
            Route::post('/add/successfull',[CategoryController::class, 'Category_Store'])->name('category.store');
            Route::get('/edit/{id}',[CategoryController::class, 'Category_Edit'])->name('category.edit');
            Route::post('/update/successfull',[CategoryController::class, 'Category_Update'])->name('category.update');
            Route::get('/delete/{id}',[CategoryController::class, 'Category_Delete'])->name('category.delete');

            // Admin Sub Category Section

            Route::get('/sub/view',[SubCategoryController::class, 'SubCategories_view'])->name('all.subcategory');
            Route::post('/sub/add/successfull',[SubCategoryController::class, 'SubCategory_Store'])->name('subcategory.store');
            Route::get('/sub/edit/{id}',[SubCategoryController::class, 'SubCategory_Edit'])->name('subcategory.edit');
            Route::post('/sub/update/successfull',[SubCategoryController::class, 'SubCategory_Update'])->name('subcategory.update');
            Route::get('/sub/delete/{id}',[SubCategoryController::class, 'SubCategory_Delete'])->name('subcategory.delete');


            // Admin Sub Sub->Category Section

            Route::get('/subcategory/view',[SubCategoryController::class, 'Sub_SubCategories_view'])->name('all.sub_subcategory');
            Route::post('/subcategory/add/successfull',[SubCategoryController::class, 'Sub_SubCategory_Store'])->name('sub_subcategory.store');
            Route::get('/subcategory/edit/{id}',[SubCategoryController::class, 'Sub_SubCategory_Edit'])->name('sub_subcategory.edit');
            Route::post('/subcategory/update/successfull',[SubCategoryController::class, 'Sub_SubCategory_Update'])->name('sub_subcategory.update');
            Route::get('/subcategory/delete/{id}',[SubCategoryController::class, 'Sub_SubCategory_Delete'])->name('sub_subcategory.delete');



            Route::get('/subcategory/ajax/{Category_id}',[SubCategoryController::class, 'Get_SubCategory']);
            Route::get('/sub_subcategory/ajax/{subcategory_id}',[SubCategoryController::class, 'Get_Sub_SubCategory']);


        });


        
            ////  product Section   //////


        Route::prefix('/admin/products')->group(function(){

            Route::get('/manage',[ProductController::class, 'Product_Manage'])->name('all.product');
            Route::get('/add',[ProductController::class, 'Product_Add'])->name('add.product');
            Route::post('/store',[ProductController::class, 'Product_Store'])->name('product.store');
            Route::get('/edit/{id}',[ProductController::class, 'Product_Edit'])->name('product.edit');
            Route::post('/update',[ProductController::class, 'Product_Update'])->name('product.update');
            Route::post('/image/update',[ProductController::class, 'Product_MultiImage'])->name('update-product-image');
            Route::get('/multiimg/delete/{id}',[ProductController::class, 'MultiImageDelete'])->name('product.multiimg.delete');
            Route::get('/delete/{id}',[ProductController::class, 'ProductDelete'])->name('product.delete');
            Route::get('/inactive/{id}', [ProductController::class, 'ProductInactive'])->name('product.inactive');
            Route::get('/active/{id}', [ProductController::class, 'ProductActive'])->name('product.active');
            Route::get('/view/{id}', [ProductController::class, 'Product_view'])->name('product.view');
        });



          /////////// Coupon section


    Route::prefix('/coupons')->group(function(){

        Route::get('/view', [CouponController::class, 'CouponView'])->name('manage-coupon');
        Route::post('/store', [CouponController::class, 'CouponStore'])->name('coupon.store');
        Route::get('/edit/{id}', [CouponController::class, 'CouponEdit'])->name('coupon.edit');
        Route::post('/update/{id}', [CouponController::class, 'CouponUpdate'])->name('coupon.update');
        Route::get('/delete/{id}', [CouponController::class, 'CouponDelete'])->name('coupon.delete');
        
        
        });




        
    // Admin Shipping All Routes 

    Route::prefix('/shipping')->group(function(){

        Route::get('/division/view', [ShippingAreaController::class, 'DivisionView'])->name('manage-division');
        
        Route::post('/division/store', [ShippingAreaController::class, 'DivisionStore'])->name('division.store');
        Route::get('/division/edit/{id}', [ShippingAreaController::class, 'DivisionEdit'])->name('division.edit');
        Route::post('/division/update/{id}', [ShippingAreaController::class, 'DivisionUpdate'])->name('division.update');
        Route::get('/division/delete/{id}', [ShippingAreaController::class, 'DivisionDelete'])->name('division.delete');


        // Ship District 
        Route::get('/district/view', [ShippingAreaController::class, 'DistrictView'])->name('manage-district');
        Route::post('/district/store', [ShippingAreaController::class, 'DistrictStore'])->name('district.store');
        Route::get('/district/edit/{id}', [ShippingAreaController::class, 'DistrictEdit'])->name('district.edit');
        Route::post('/district/update/{id}', [ShippingAreaController::class, 'DistrictUpdate'])->name('district.update');
        Route::get('/district/delete/{id}', [ShippingAreaController::class, 'DistrictDelete'])->name('district.delete');


        // Ship State 
        Route::get('/state/view', [ShippingAreaController::class, 'StateView'])->name('manage-state');

        Route::post('/state/store', [ShippingAreaController::class, 'StateStore'])->name('state.store');

        Route::get('/state/edit/{id}', [ShippingAreaController::class, 'StateEdit'])->name('state.edit');

        Route::post('/state/update/{id}', [ShippingAreaController::class, 'StateUpdate'])->name('state.update');
        Route::get('/state/delete/{id}', [ShippingAreaController::class, 'StateDelete'])->name('state.delete');
        
    });





    // Admin Order All Routes 

    Route::prefix('/orders')->group(function(){

        Route::get('/pending/orders', [OrderController::class, 'PendingOrders'])->name('pending-orders');
        Route::get('/pending/orders/details/{order_id}', [OrderController::class, 'PendingOrdersDetails'])->name('pending.order.details');
        Route::get('/confirmed/orders', [OrderController::class, 'ConfirmedOrders'])->name('confirmed-orders');

        Route::get('/processing/orders', [OrderController::class, 'ProcessingOrders'])->name('processing-orders');

        Route::get('/picked/orders', [OrderController::class, 'PickedOrders'])->name('picked-orders');

        Route::get('/shipped/orders', [OrderController::class, 'ShippedOrders'])->name('shipped-orders');

        Route::get('/delivered/orders', [OrderController::class, 'DeliveredOrders'])->name('delivered-orders');

        Route::get('/cancel/orders', [OrderController::class, 'CancelOrders'])->name('cancel-orders');

        // Update Status 
        Route::get('/pending/confirm/{order_id}', [OrderController::class, 'PendingToConfirm'])->name('pending-confirm');
        Route::get('/confirm/processing/{order_id}', [OrderController::class, 'ConfirmToProcessing'])->name('confirm.processing');

        Route::get('/processing/picked/{order_id}', [OrderController::class, 'ProcessingToPicked'])->name('processing.picked');
        
        Route::get('/picked/shipped/{order_id}', [OrderController::class, 'PickedToShipped'])->name('picked.shipped');
        
        Route::get('/shipped/delivered/{order_id}', [OrderController::class, 'ShippedToDelivered'])->name('shipped.delivered'); 
        Route::get('/invoice/download/{order_id}', [OrderController::class, 'AdminInvoiceDownload'])->name('invoice.download');


    });




    // Admin Reports Routes 
    Route::prefix('/reports')->group(function(){

        Route::get('/view', [ReportController::class, 'ReportView'])->name('all-reports');
        Route::post('/search/by/date', [ReportController::class, 'ReportByDate'])->name('search-by-date');
        Route::post('/search/by/month', [ReportController::class, 'ReportByMonth'])->name('search-by-month');
        Route::post('/search/by/year', [ReportController::class, 'ReportByYear'])->name('search-by-year');
        
        
        });


//////// Admin Get All User Routes 

    Route::prefix('/alluser')->group(function(){

        Route::get('/view', [AdminProfileController::class, 'AllUsers'])->name('all-users');
    
    
    });





    // Admin Blog Routes 

    Route::prefix('/blog')->group(function(){

        Route::get('/category', [BlogController::class, 'BlogCategory'])->name('blog.category');
        Route::post('/store', [BlogController::class, 'BlogCategoryStore'])->name('blogcategory.store');
        Route::get('/category/edit/{id}', [BlogController::class, 'BlogCategoryEdit'])->name('blog.category.edit');
        Route::post('/update', [BlogController::class, 'BlogCategoryUpdate'])->name('blogcategory.update');

        // Admin View Blog Post Routes 

        Route::get('/list/post', [BlogController::class, 'ListBlogPost'])->name('list.post');
        Route::get('/add/post', [BlogController::class, 'AddBlogPost'])->name('add.post');
        Route::post('/post/store', [BlogController::class, 'BlogPostStore'])->name('post-store');
        Route::get('/post/edit/{id}', [BlogController::class, 'BlogPostEdit'])->name('blog.post.edit');
        Route::post('/post/update', [BlogController::class, 'BlogPostUpdate'])->name('post-update');
        Route::get('/post/delete/{id}', [BlogController::class, 'BlogPostDelete'])->name('post.delete');
    
         
    });



    // Admin Site Setting Routes 
    Route::prefix('/setting')->group(function(){

        Route::get('/header/site', [SiteSettingController::class, 'Header_SiteSetting'])->name('header_site.setting');
        Route::post('/header/site/update', [SiteSettingController::class, 'Header_SiteSetting_update'])->name('header_update.sitesetting');
        Route::get('/footer/site', [SiteSettingController::class, 'Footer_SiteSetting'])->name('footer_site.setting');
        Route::post('/footer/site/update', [SiteSettingController::class, 'Footer_SiteSetting_update'])->name('footer_update.sitesetting');
        Route::get('/seo', [SiteSettingController::class, 'SeoSetting'])->name('seo.setting');
        Route::post('/seo/update', [SiteSettingController::class, 'SeoSettingUpdate'])->name('update.seosetting');
        
        });



         // Admin Seo Setting Routes 

    Route::prefix('/seo')->group(function(){

        Route::get('/seo', [SiteSettingController::class, 'SeoSetting'])->name('seo.setting');
        Route::post('/seo/update', [SiteSettingController::class, 'SeoSettingUpdate'])->name('update.seosetting');
        
        });



        
           // Admin Return Order Routes 
    Route::prefix('/return')->group(function(){

        Route::get('/admin/request', [ReturnController::class, 'ReturnRequest'])->name('return.request');
        Route::get('/admin/return/approve/{order_id}', [ReturnController::class, 'ReturnRequestApprove'])->name('return.approve');
        Route::get('/admin/all/request', [ReturnController::class, 'ReturnAllRequest'])->name('all.request');
        
        });


        // Admin Manage Review Routes 
    Route::prefix('/review')->group(function(){

        //// product review

        Route::get('/admin/pending', [ReviewController::class, 'PendingReview'])->name('pending.review');       
        Route::get('/admin/approve/{id}', [ReviewController::class, 'ReviewApprove'])->name('review.approve');    
        Route::get('/admin/admin/all/request', [ReturnController::class, 'ReturnAllRequest'])->name('all.request');
        Route::get('/admin/publish', [ReviewController::class, 'PublishReview'])->name('publish.review');
        Route::get('/admin/delete/{id}', [ReviewController::class, 'DeleteReview'])->name('delete.review');

        //// post review
        
        Route::get('/admin/pending/blog', [HomeBlogController::class, 'PendingBlog'])->name('pending.blog.review'); 
        Route::get('/admin/blog/approve/{id}', [HomeBlogController::class, 'Review_Blog_Approve'])->name('blog.review.approve');
        Route::get('/admin/blog/publish', [HomeBlogController::class, 'Publish_blog_Review'])->name('publish.blog.review');
        Route::get('/admin/blog/delete/{id}', [HomeBlogController::class, 'Delete_blog_Review'])->name('delete.blog.review');
        
        });

        


         // Admin Manage Review Routes 
         Route::prefix('/stock')->group(function(){

            Route::get('/product', [ProductController::class, 'ProductStock'])->name('product.stock');
            
            
            });


    // Admin Manage Menu Routes

    Route::prefix('/menu')->group(function(){

        Route::get('/add', [MenuController::class, 'Add_menu'])->name('add.menu');
        Route::get('/store/{id}', [MenuController::class, 'Store_Menu'])->name('menu.edit');
        Route::get('/manage', [MenuController::class, 'Manage_Menu'])->name('manage.menu');
        Route::get('/delete/{id}', [MenuController::class, 'Delete_Menu'])->name('menu.delete');
        
        
        });


          // Admin Manage show By Brand Routes

    Route::prefix('/show/brand')->group(function(){

        Route::get('/add', [MenuController::class, 'Show_Brand'])->name('show.brand');
        Route::get('/store/{id}', [MenuController::class, 'Store_Show_Brand'])->name('brand.show.store');
        Route::get('/manage', [MenuController::class, 'Manage_Show_Brand'])->name('manage.show.brand');
        Route::get('/remove/{id}', [MenuController::class, 'Remove_show_brand'])->name('brand.remove.show');
        
        
        });



         // Admin Manage show By Category Routes

    Route::prefix('/show/category')->group(function(){

        Route::get('/add', [MenuController::class, 'Show_category'])->name('show.category');
        Route::get('/store/{id}', [MenuController::class, 'Store_Show_Category'])->name('category.show.store');
        Route::get('/manage', [MenuController::class, 'Manage_Show_Category'])->name('manage.show.category');
        Route::get('/remove/{id}', [MenuController::class, 'Remove_show_Category'])->name('brand.remove.category');
        
        
        });



    // Admin Slider All Routes 

    Route::prefix('/slider')->group(function(){

        Route::get('/view', [SliderController::class, 'SliderView'])->name('manage-slider');   
        Route::post('/store', [SliderController::class, 'SliderStore'])->name('slider.store');   
        Route::get('/edit/{id}', [SliderController::class, 'SliderEdit'])->name('slider.edit');   
        Route::post('/update', [SliderController::class, 'SliderUpdate'])->name('slider.update'); 
        Route::get('/delete/{id}', [SliderController::class, 'SliderDelete'])->name('slider.delete');
        Route::get('/inactive/{id}', [SliderController::class, 'SliderInactive'])->name('slider.inactive');
        Route::get('/active/{id}', [SliderController::class, 'SliderActive'])->name('slider.active');
        
        });



   // Admin FAQ All Routes 

   Route::prefix('/others')->group(function(){

    Route::get('/faq/view', [OthersController::class, 'Manage_FAQ'])->name('manage-faq'); 
    Route::get('/faq/add', [OthersController::class, 'Add_FAQ'])->name('add.faq'); 
    Route::post('/faq/store', [OthersController::class, 'Store_FAQ'])->name('faq.store');  
    Route::get('/faq/edit/{id}', [OthersController::class, 'Edit_FAQ'])->name('faq.edit'); 
    Route::post('/faq/update', [OthersController::class, 'Update_FAQ'])->name('update.faq');
    Route::get('/faq/delete/{id}', [OthersController::class, 'Delete_FAQ'])->name('faq.delete');

    // contact

    Route::get('/contact', [OthersController::class, 'Contact'])->name('admin.contact');
    Route::get('/contact/view/{id}', [OthersController::class, 'Contact_view'])->name('contact.view');
    Route::get('/contact/delete/{id}', [OthersController::class, 'Contact_Delete'])->name('contact.delete');
    
    //// map

    Route::get('/map/view', [OthersController::class, 'Map_Manage'])->name('manage-map');
    Route::post('/map/update', [OthersController::class, 'Map_Update'])->name('map.update');

    
    //// About


    Route::get('/about/view', [OthersController::class, 'About_Manage'])->name('add.about');
    Route::post('/about/update', [OthersController::class, 'About_Update'])->name('about-update');

    
    
    });

    


       // Admin Testimonials All Routes 

   Route::prefix('/testimonials')->group(function(){

    Route::get('/testimonials/view', [TestimonialsController::class, 'Testimonials_Manage'])->name('testimonials.view'); 
    Route::get('/testimonials/add', [TestimonialsController::class, 'Testimonials_Add'])->name('testimonials.add'); 
    Route::post('/testimonials/store', [TestimonialsController::class, 'Testimonials_Store'])->name('testimonial.store');
    Route::get('/testimonials/edit/{id}', [TestimonialsController::class, 'Testimonials_Edit'])->name('testimonial.edit');
    Route::post('/testimonials/update', [TestimonialsController::class, 'Testimonials_Update'])->name('testimonial.update');
    Route::get('/testimonials/delete/{id}', [TestimonialsController::class, 'Testimonials_Delete'])->name('testimonial.delete');
    
    });

        





    });  // end Middleware admin






    ///////////////////////////////       Admin middleware End       ///////////////////////////////








// Frontend Section

// Route::get('/', function () {
//     return view('frontend.index_home');
// });

Route::get('/',[IndexController::class, 'Index']);




Route::middleware(['auth:sanctum,web', 'verified'])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard')->middleware('auth:web');





Route::get('/user/logout',[UserController::class, 'User_Logout'])->name('user.logout');









/////////////// ///                  Start  user middleware                ////////////////////////////////////////////////

Route::group(['prefix'=>'user','middleware' => ['user','auth'],'namespace'=>'User'],function(){


    //////////  user profile ///////

    Route::get('/user/profile',[UserController::class, 'User_Profile'])->name('user.profile');
    Route::post('/user/profile/change/successfull',[UserController::class, 'User_Profile_Store'])->name('user.profile.store');
    Route::get('/user/password/change',[UserController::class, 'View_password'])->name('view.change.password');
    Route::post('/user/password/change/successfull',[UserController::class, 'User_Password_Store'])->name('user.change.password.store');
    Route::get('/user/photo',[UserController::class, 'User_Photo'])->name('user.photo');
    Route::post('/user/profile/photo/update/successfull',[UserController::class, 'User_photoe_Store'])->name('user.photo.store');



    // Wishlist page
    Route::get('/wishlist', [WishlistController::class, 'ViewWishlist'])->name('wishlist');
    Route::get('/get-wishlist-product', [WishlistController::class, 'GetWishlistProduct']);
    Route::get('/wishlist-remove/{id}', [WishlistController::class, 'RemoveWishlistProduct']);


    Route::post('/stripe/order', [StripeController::class, 'StripeOrder'])->name('stripe.order');
    Route::post('/cash/order', [CashController::class, 'CashOrder'])->name('cash.order');



    Route::get('/my/orders', [AllUserController::class, 'MyOrders'])->name('my.orders');
    Route::get('/order_details/{order_id}', [AllUserController::class, 'OrderDetails']);
    Route::get('/invoice_download/{order_id}', [AllUserController::class, 'InvoiceDownload']);
    Route::post('/return/order/{order_id}', [AllUserController::class, 'ReturnOrder'])->name('return.order');
    Route::get('/return/order/list', [AllUserController::class, 'ReturnOrderList'])->name('return.order.list');
    Route::get('/cancel/orders', [AllUserController::class, 'CancelOrders'])->name('cancel.orders');



    /// Order Traking Route 

    Route::post('/order/tracking', [AllUserController::class, 'OrderTraking'])->name('order.tracking'); 


    });


/////////////// ///                  End  user middleware                ////////////////////////////////////////////////





  





    






    // Multiple Language All route


    Route::get('/language/english', [LanguageController::class, 'English_Language'])->name('language.english');
    Route::get('/language/others', [LanguageController::class, 'Others_language'])->name('language.others');













    // Frontend section




    Route::get('/language/others', [LanguageController::class, 'Others_language'])->name('language.others');
    
    // frontend product details


    Route::get('/product/details/{id}/{slug}',[IndexController::class, 'Product_details']);

    Route::get('product/tag/en/{tags}',[IndexController::class, 'Product_tag_en']);
    Route::get('product/tag/others/{tag}',[IndexController::class, 'Product_tag_others']);
    Route::get('/sub/subcategory/{id}/{sub_subslug}',[IndexController::class, 'Sub_subProduct_show']);
    Route::get('/subcategory/{id}/{sub_slug}',[IndexController::class, 'Sub_Product_show']);
    Route::get('/category/{id}/{slug}',[IndexController::class, 'Category_Product_show']);


    // Product View Modal with Ajax

    Route::get('/product/view/modal/{id}', [IndexController::class, 'ProductViewAjax']);


    // Add to Cart Store Data
    Route::post('/cart/data/store/{id}', [CartController::class, 'AddToCart']);


     // Get Data from mini cart
     Route::get('/product/mini/cart/', [CartController::class, 'AddMiniCart']);

     // Remove mini cart
     Route::get('/minicart/product-remove/{rowId}', [CartController::class, 'RemoveMiniCart']);




   // Add to Wishlist
    Route::post('/add-to-wishlist/{product_id}', [WishlistController::class, 'AddToWishlist']);








     // My Cart Page All Routes

        Route::get('/mycart', [CartPageController::class, 'MyCart'])->name('mycart');
        Route::get('/user/get-cart-product', [CartPageController::class, 'GetCartProduct']);
        Route::get('/user/cart-remove/{rowId}', [CartPageController::class, 'RemoveCartProduct']);
        Route::get('/cart-increment/{rowId}', [CartPageController::class, 'CartIncrement']);
        Route::get('/cart-decrement/{rowId}', [CartPageController::class, 'CartDecrement']);


    // Frontend Coupon Option

        Route::post('/coupon-apply', [CartController::class, 'CouponApply']);
        Route::get('/coupon-calculation', [CartController::class, 'CouponCalculation']);
        Route::get('/coupon-remove', [CartController::class, 'CouponRemove']);


        // Checkout Routes 

        Route::get('/checkout', [CartController::class, 'CheckoutCreate'])->name('checkout');


        Route::get('/district-get/ajax/{division_id}', [CheckoutController::class, 'DistrictGetAjax']);

        Route::get('/state-get/ajax/{district_id}', [CheckoutController::class, 'StateGetAjax']);
        Route::post('/checkout/store', [CheckoutController::class, 'CheckoutStore'])->name('checkout.store');



        Route::get('/blog', [HomeBlogController::class, 'AddBlogPost'])->name('home.blog');

        Route::get('/post/details/{id}', [HomeBlogController::class, 'DetailsBlogPost'])->name('post.details');
        Route::get('/blog/category/post/{category_id}', [HomeBlogController::class, 'HomeBlogCatPost']);


        /// Frontend Product Review Routes

        Route::post('/review/store', [ReviewController::class, 'ReviewStore'])->name('review.store');

        /// Product Search Route 
        Route::post('/search', [IndexController::class, 'ProductSearch'])->name('product.search');

        Route::post('search-product', [IndexController::class, 'SearchProduct']);

        // Shop Page Route 
        Route::get('/shop', [ShopController::class, 'ShopPage'])->name('shop.page');
        
        Route::post('/shop/filter', [ShopController::class, 'ShopFilter'])->name('shop.filter');







         // FAQ

    Route::get('/faq', [IndexController::class, 'View_FAQ'])->name('faq');
    Route::get('/contact', [IndexController::class, 'View_Contact'])->name('contact');

    
    Route::post('/contact/store', [ContactUsController::class, 'Store_Contact'])->name('contact.store');

    /// about

    Route::get('/about', [IndexController::class, 'About'])->name('about');





    ////// Blog post cooment

    Route::post('/blog/post/comment', [HomeBlogController::class, 'Post_comment'])->name('post_comment');

   
    