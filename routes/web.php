<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// Frontend Controller
use App\Http\Controllers\Frontend\PagesController;
use App\Http\Controllers\Frontend\ProductpagesController;
use App\Http\Controllers\Frontend\DashboardController;
use App\Http\Controllers\Frontend\CartController;
use App\Http\Controllers\Frontend\MessageController;
use App\Http\Controllers\Frontend\WishlistController;
use App\Http\Controllers\Frontend\ReviewController;

// Backend Controller
use App\Http\Controllers\Backend\AdminController;
use App\Http\Controllers\Backend\BrandController;
use App\Http\Controllers\Backend\CategoryController;
use App\Http\Controllers\Backend\SubCategoryController;
use App\Http\Controllers\Backend\ProductController;
use App\Http\Controllers\Backend\CountryController;
use App\Http\Controllers\Backend\StateController;
use App\Http\Controllers\Backend\DistrictController;
use App\Http\Controllers\Backend\UserController;
use App\Http\Controllers\Backend\OrderController;
use App\Http\Controllers\Backend\CustomerController;
use App\Http\Controllers\Backend\ShippingController;
use App\Http\Controllers\Backend\CurrencyController;
use App\Http\Controllers\Backend\GenarelSettings;
use App\Http\Controllers\Backend\ProductVariationController;
use App\Http\Controllers\Backend\VariationValueController;
use App\Http\Controllers\Backend\CuponController;

// Payment Controller
use App\Http\Controllers\Payment\SslCommerzPaymentController;

/*
|--------------------------------------------------------------------------
| Frontend Routes
|--------------------------------------------------------------------------
*/

Route::get('/', [PagesController::class, 'home'])->name('homepage');
Route::get('/about', [PagesController::class, 'about'])->name('aboutpage');
Route::get('/contact', [PagesController::class, 'contact'])->name('contactpage');
Route::get('/404-page-not-found', [PagesController::class, 'error404'])->name('error404');

// Product Pages
Route::get('/all-products', [ProductpagesController::class, 'all_products'])->name('all-products');
Route::get('/offer-products', [ProductpagesController::class, 'offer_products'])->name('offer-products');
Route::get('/product-details/{slug}', [ProductpagesController::class, 'single_products'])->name('product-details')->middleware('isProduct');
// Category wise Product
Route::get('/category-product/{slug}', [ProductpagesController::class, 'category_products'])->name('category-product');
// search product
Route::get('/search', [ProductpagesController::class, 'search_product'])->name('search-product');

// Cart Page
Route::group(['prefix' => 'carts'], function () {
    Route::get('/', [CartController::class, 'manage'])->name('cart-manage')->middleware('checkoutCartPage');
    Route::post('/store', [CartController::class, 'store'])->name('cart-store');
    Route::post('/add-to-cart', [CartController::class, 'addToCart'])->name('add-to-cart');
    Route::post('/update/{id}', [CartController::class, 'update'])->name('cart-update');
    Route::delete('/delete/{id}', [CartController::class, 'destroy'])->name('cart-delete');
    // apply coupon
    Route::post('/apply-coupon', [CartController::class, 'applyDiscount'])->name('apply-coupon');
    Route::post('/del-coupon', [CartController::class, 'delCoupon'])->name('del-coupon');
});

//wishlist
Route::controller(WishlistController::class)->group(function () {
    Route::group(['prefix' => 'wishlists'], function () {
        Route::get('/', 'manage')->name('manage-wishlist')->middleware('WishlistItem');
        Route::post('/store', 'store')->name('store-wishlist');
        Route::post('/update/{id}', 'update')->name('update-wishlist');
        Route::delete('/delete/{id}', 'destroy')->name('del-wishlist');
    });
});

// Checkout Page
Route::middleware('checkoutCartPage')->group(function () {
    Route::get('/checkout', [SslCommerzPaymentController::class, 'checkout'])->name('checkout');
    Route::post('/success-order', [SslCommerzPaymentController::class, 'index'])->name('make-payment');
    Route::post('/fail', [SslCommerzPaymentController::class, 'fail']);
    Route::post('/cancel', [SslCommerzPaymentController::class, 'cancel']);
    Route::post('/ipn', [SslCommerzPaymentController::class, 'ipn']);
});

// Route::get('/success-order', [SslCommerzPaymentController::class, 'index']);
Route::post('/success', [SslCommerzPaymentController::class, 'success'])->name('order-success');
Route::get('/track-order', [PagesController::class, 'track_order'])->name('track-order');

// User Pages
Route::get('/my-dashboard', [DashboardController::class, 'user_dashboard'])->middleware(['auth', 'verified'])->name('user-dashboard');
Route::get('/my-profile', [DashboardController::class, 'user_profile'])->middleware(['auth', 'verified'])->name('user-profile');
Route::get('/order-invoice/{id}', [DashboardController::class, 'order_invoice'])->middleware(['auth', 'verified'])->name('order-invoice');
Route::put('/personal-details-update/{id}', [DashboardController::class, 'userInfo'])->name('personal-details-update');
Route::put('/shipping-details-update/{id}', [DashboardController::class, 'shippingInfo'])->name('shipping-details-update');
Route::put('/profile-image-update/{id}', [DashboardController::class, 'profilePic'])->name('profile-image-update');
Route::patch('/profile-image-remove/{id}', [DashboardController::class, 'removeProfilePic'])->name('profile-image-remove');
Route::get('/forget-password', [DashboardController::class, 'forget_password'])->name('forget-password');
Route::delete('/delete-account/{id}', [DashboardController::class, 'profileDestroy'])->name('profile-destroy');
Route::patch('/deactive-account/{id}', [DashboardController::class, 'deactiveAccount'])->name('deactive-account');

// user message
Route::group(['prefix' => 'message'], function () {
    Route::get('/manage', [MessageController::class, 'manage'])->name('manage-message')->middleware('isAdmin');
    Route::post('/store', [MessageController::class, 'store'])->name('store-message');
    Route::get('/show/{id}', [MessageController::class, 'show'])->name('show-message')->middleware('isAdmin');
    Route::PUT('/replay-message/{id}', [MessageController::class, 'replyMessage'])->name('replay-message')->middleware('isAdmin');
    Route::delete('/delete/{id}', [MessageController::class, 'destroy'])->name('del-message')->middleware('isAdmin');
});

// customer reviews
Route::group(['prefix' => 'customer-review'], function () {
    Route::post('/store', [ReviewController::class, 'store'])->name('review-store');
});

//invalid url
Route::fallback(function () {
    return view('frontend.pages.404');
});

/*
|--------------------------------------------------------------------------
| Backend Routes
|--------------------------------------------------------------------------
*/
Route::group(['middleware' => ['isAdmin'], 'prefix' => '/admin'], function () {

    // All Admin
    Route::controller(AdminController::class)->group(function () {
        Route::get('/dashboard', 'index')->name('adminDashboard');
        Route::group(['prefix' => 'users'], function () {
            Route::get('/admin-manage', 'manage_admin')->name('manage-admin')->middleware('isSubAdmin');
        });
    });

    // All User
    Route::controller(UserController::class)->group(function () {
        Route::group(['prefix' => 'users'], function () {
            Route::get('/user-manage', 'manage_user')->name('manage-user');
            Route::post('/trash/{id}', 'trash')->name('trash-user');
            Route::get('/edit/{id}', 'edit')->name('edit-user');
            Route::get('/profile/{id}', 'profileEdit')->name('edit-profile');
            Route::put('/update/{id}', 'update')->name('update-user');
            Route::get('/trash-manage', 'trash_manage')->name('trash-manage-user');
            Route::post('/restore/{id}', 'restore')->name('restore-user');
            Route::post('/user-info/{id}', 'userInfo')->name('userInfo');
            Route::put('/profile-image-update/{id}', 'profilePic')->name('profile-image-update');
            Route::patch('/profile-image-remove/{id}', 'removeProfilePic')->name('profile-image-remove');
            Route::delete('/destroy/{id}', 'destroy')->name('destroy-user');
        });
    });

    // Brand
    Route::controller(BrandController::class)->group(function () {
        Route::group(['prefix' => 'brand'], function () {
            Route::get('/manage', 'manage')->name('manage-brand');
            Route::get('/create', 'create')->name('create-brand');
            Route::post('/store', 'store')->name('store-brand');
            Route::get('/edit/{id}', 'edit')->name('edit-brand');
            Route::put('/update/{id}', 'update')->name('update-brand');
            Route::post('/remove-image/{id}', 'remove_image')->name('remove-brand-logo');
            Route::post('/trash/{id}', 'trash')->name('trash-brand');
            Route::get('/trash-manage', 'trash_manage')->name('trash-manage-brand');
            Route::post('/restore/{id}', 'restore')->name('restore-brand');
            Route::delete('/destroy/{id}', 'destroy')->name('destroy-brand');
        });
    });

    // Parent Category
    Route::group(['prefix' => 'category'], function () {
        Route::get('/manage', [CategoryController::class, 'manage'])->name('manage-category');
        Route::get('/create', [CategoryController::class, 'create'])->name('create-category');
        Route::post('/store', [CategoryController::class, 'store'])->name('store-category');
        Route::get('/edit/{id}', [CategoryController::class, 'edit'])->name('edit-category');
        Route::post('/update/{id}', [CategoryController::class, 'update'])->name('update-category');
        Route::patch('/remove-image/{id}', [CategoryController::class, 'remove_image'])->name('remove-category-image');
        Route::post('/trash/{id}', [CategoryController::class, 'trash'])->name('trash-category');
        Route::get('/trash-manage', [CategoryController::class, 'trash_manage'])->name('trash-manage-category');
        Route::post('/restore/{id}', [CategoryController::class, 'restore'])->name('restore-category');
        Route::post('/destroy/{id}', [CategoryController::class, 'destroy'])->name('destroy-category');
    });

    // Sub Category
    Route::group(['prefix' => 'sub-category'], function () {
        Route::get('/manage', [SubCategoryController::class, 'manage'])->name('manage-subCategory');
        Route::get('/create', [SubCategoryController::class, 'create'])->name('create-subCategory');
        Route::post('/store', [SubCategoryController::class, 'store'])->name('store-subCategory');
        Route::get('/edit/{id}', [SubCategoryController::class, 'edit'])->name('edit-subCategory');
        Route::post('/update/{id}', [SubCategoryController::class, 'update'])->name('update-subCategory');
        Route::patch('/remove-image/{id}', [SubCategoryController::class, 'remove_image'])->name('remove-subcategory-image');
        Route::post('/trash/{id}', [SubCategoryController::class, 'trash'])->name('trash-subCategory');
        Route::get('/trash-manage', [SubCategoryController::class, 'trash_manage'])->name('trash-manage-subCategory');
        Route::post('/restore/{id}', [SubCategoryController::class, 'restore'])->name('restore-subCategory');
        Route::delete('/destroy/{id}', [SubCategoryController::class, 'destroy'])->name('destroy-subCategory');
    });

    // Product
    Route::group(['prefix' => 'product'], function () {
        Route::get('/manage', [ProductController::class, 'manage'])->name('manage-product');
        Route::get('/create', [ProductController::class, 'create'])->name('create-product');
        Route::post('/store', [ProductController::class, 'store'])->name('store-product');
        Route::get('/edit/{id}', [ProductController::class, 'edit'])->name('edit-product');
        Route::post('/update/{id}', [ProductController::class, 'update'])->name('update-product');
        Route::post('/trash/{id}', [ProductController::class, 'trash'])->name('trash-product');
        Route::get('/trash-manage', [ProductController::class, 'trash_manage'])->name('trash-manage-product');
        Route::post('/restore/{id}', [ProductController::class, 'restore'])->name('restore-product');
        Route::post('/destroy/{id}', [ProductController::class, 'destroy'])->name('destroy-product');
        Route::get('/featured-product', [ProductController::class, 'featured_product'])->name('featured-product');
        Route::get('/product-detail/{id}', [ProductController::class, 'product_detail'])->name('product-detail');
        Route::get('/product-review', [ProductController::class, 'Reviewmanage'])->name('review-manage');
        Route::delete('/destroy/{id}', [ProductController::class, 'destroy'])->name('destroy-review');
        Route::post('/update-feature-status/{id}', [ProductController::class, 'update_feature'])->name('update-feature-status');
    });

    // Product variation
    Route::group(['prefix' => 'product-variation'], function () {
        Route::get('/', [ProductVariationController::class, 'variation'])->name('variation-product');
        Route::post('/store', [ProductVariationController::class, 'store'])->name('store-variation-product');
        Route::post('/update/{id}', [ProductVariationController::class, 'update'])->name('update-variation-product');
        Route::delete('/delete/{id}', [ProductVariationController::class, 'destroy'])->name('delete-variation-product');

        // variation value
        Route::post('/variation-option', [VariationValueController::class, 'store'])->name('variation-option');
        Route::post('/update-option/{id}', [VariationValueController::class, 'update'])->name('update-option');
        Route::delete('/delete-option/{id}', [VariationValueController::class, 'destroy'])->name('delete-option');
    });

    // order
    Route::controller(OrderController::class)->group(function () {
        Route::group(['prefix' => 'order'], function () {
            Route::get('manage-order', 'manage')->name('manage-order');
            Route::get('order-details/{id}', 'order_details')->name('order-details');
            Route::patch('order-update/{id}', 'update')->name('order-update');
            Route::delete('delete-order/{id}', 'destroy')->name('del-order');
        });
    });

    // Country
    Route::group(['prefix' => 'country'], function () {
        Route::get('/manage', [CountryController::class, 'manage'])->name('manage-country');
        Route::get('/create', [CountryController::class, 'create'])->name('create-country');
        Route::post('/store', [CountryController::class, 'store'])->name('store-country');
        Route::get('/edit/{id}', [CountryController::class, 'edit'])->name('edit-country');
        Route::post('/update/{id}', [CountryController::class, 'update'])->name('update-country');
        Route::post('/trash/{id}', [CountryController::class, 'trash'])->name('trash-country');
        Route::get('/trash-manage', [CountryController::class, 'trash_manage'])->name('trash-manage-country');
        Route::post('/restore/{id}', [CountryController::class, 'restore'])->name('restore-country');
        Route::delete('/destroy/{id}', [CountryController::class, 'destroy'])->name('destroy-country');
    });

    // State
    Route::group(['prefix' => 'state'], function () {
        Route::get('/manage', [StateController::class, 'manage'])->name('manage-state');
        Route::get('/create', [StateController::class, 'create'])->name('create-state');
        Route::post('/store', [StateController::class, 'store'])->name('store-state');
        Route::get('/edit/{id}', [StateController::class, 'edit'])->name('edit-state');
        Route::post('/update/{id}', [StateController::class, 'update'])->name('update-state');
        Route::post('/trash/{id}', [StateController::class, 'trash'])->name('trash-state');
        Route::get('/trash-manage', [StateController::class, 'trash_manage'])->name('trash-manage-state');
        Route::post('/restore/{id}', [StateController::class, 'restore'])->name('restore-state');
        Route::post('/destroy/{id}', [StateController::class, 'destroy'])->name('destroy-state');
    });

    // District
    Route::group(['prefix' => 'district'], function () {
        Route::get('/manage', [DistrictController::class, 'manage'])->name('manage-district');
        Route::get('/create', [DistrictController::class, 'create'])->name('create-district');
        Route::post('/store', [DistrictController::class, 'store'])->name('store-district');
        Route::get('/edit/{id}', [DistrictController::class, 'edit'])->name('edit-district');
        Route::put('/update/{id}', [DistrictController::class, 'update'])->name('update-district');
        Route::post('/trash/{id}', [DistrictController::class, 'trash'])->name('trash-district');
        Route::get('/trash-manage', [DistrictController::class, 'trash_manage'])->name('trash-manage-district');
        Route::post('/restore/{id}', [DistrictController::class, 'restore'])->name('restore-district');
        Route::delete('/destroy/{id}', [DistrictController::class, 'destroy'])->name('destroy-district');
    });

    // shipping method
    Route::group(['prefix' => 'shipping-methods'], function () {
        Route::get('/manage', [ShippingController::class, 'manage'])->name('shipping-manage');
        Route::post('/store', [ShippingController::class, 'store'])->name('shipping-store');
        Route::post('curiour/store', [ShippingController::class, 'curiourStore'])->name('curiour-store');
        Route::post('/update/{id}', [ShippingController::class, 'update'])->name('shipping-update');
        Route::post('curiour/update/{id}', [ShippingController::class, 'curiourUpdate'])->name('curiour-update');
        Route::delete('/destroy/{id}', [ShippingController::class, 'destroy'])->name('destroy-shipping');
    });

    // currency 
    Route::group(['prefix' => 'currency'], function () {
        Route::get('/manage', [CurrencyController::class, 'manage'])->name('manage-currency');
        Route::match(['get', 'post'], '/add_edit/{id?}', [CurrencyController::class, 'add_edit'])->name('currency-add.edit');
        Route::post('/update/{id}', [CurrencyController::class, 'update'])->name('currency-update');
        Route::delete('/destroy/{id}', [CurrencyController::class, 'destroy'])->name('destroy-currency');
    });

    // genarel settings 
    Route::group(['prefix' => 'genarel_settings'], function () {
        Route::get('/manage', [GenarelSettings::class, 'manage'])->name('manage-genarelSettings');
        Route::post('/update/{id?}', [GenarelSettings::class, 'update'])->name('genarelSettings-update');
    });

    // customer
    Route::group(['prefix' => 'customer'], function () {
        Route::get('/manage', [CustomerController::class, 'manage'])->name('manage-customer');
    });

    // cupon
    Route::group(['prefix' => 'coupons'], function () {
        Route::get('/manage', [CuponController::class, 'manage'])->name('manage-cupons');
        Route::post('/store', [CuponController::class, 'store'])->name('store-cupons');
        Route::get('/create', [CuponController::class, 'create'])->name('create-cupons');
        Route::get('/edit/{id}', [CuponController::class, 'edit'])->name('edit-cupons');
        Route::put('/update/{id}', [CuponController::class, 'update'])->name('update-cupons');
        Route::delete('/destroy/{id}', [CuponController::class, 'destroy'])->name('destroy-cupons');
    });

    // wishlist
    Route::get('/wishlist-list', [WishlistController::class, 'wishlistList'])->name('wishlistList');
});

/*
|--------------------------------------------------------------------------
| Web API
|--------------------------------------------------------------------------
*/
require __DIR__ . '/api.php';
