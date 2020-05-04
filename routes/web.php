<?php

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


Auth::routes(['verify' => true]);

Route::get('/home', 'HomeController@index')->name('home');





// FrontEndController

Route::get('/', 'FrontEndController@index')->name('frontend.index');
Route::get('/about', 'FrontEndController@about')->name('about');
Route::get('/front_faq', 'FrontEndController@front_faq')->name('front_faq');
Route::get('contact', 'FrontEndController@contact')->name('frontend.contact');
Route::get('/shop', 'FrontEndController@shop')->name('frontend.shop');

// END FrontEndController



// FaqController
Route::get('/faq', 'FaqController@faq_index')->name('faq_index');
Route::post('/faq/insert', 'FaqController@faq_insert')->name('faq_insert');
Route::get('/faq/edit/{faq_id}', 'FaqController@faq_edit')->name('faq_edit');
Route::post('/faq/update', 'FaqController@faq_update')->name('faq_update');
Route::get('/faq/trash/{faq_id}', 'FaqController@faq_trash')->name('faq_trash');

Route::get('/faq/restore/{faq_id}', 'FaqController@faq_restore')->name('faq_restore');
Route::get('/faq/delete/{faq_id}', 'FaqController@faq_delete')->name('faq_delete');
// END FaqController


// ProfileController

Route::get('/change/password', 'ProfileController@profile_edit')->name('profile_edit');
Route::post('/change/passord/post', 'ProfileController@change_pass')->name('change_pass');

// END ProfileController

// CategoryController

Route::resource('/category', 'CategoryController');
Route::get('/category/{category_id}/delete', 'CategoryController@delete')->name('category_delete');


// END CategoryController

// ToDoListController

Route::get('/todolist/alldone', 'ToDoListController@alldone')->name('todolist.alldone');
Route::get('/todolist/delete/all', 'ToDoListController@alldelete')->name('todolist.alldelete');
Route::resource('todolist', 'ToDoListController');

// END ToDoListController


// ProductController

Route::resource('product', 'ProductController');

// END ProductController


// CustomerController

Route::get('/home/customer', 'CustomerController@index');

// END CustomerController


// GithubController

Route::get('register/github', 'GithubController@redirectToProvider');
Route::get('register/github/callback', 'GithubController@handleProviderCallback');

// END GithubController

// CartController

Route::post('add/to/cart', 'CartController@addCart')->name('add.cart');
Route::get('delete/{cart_id}/cart', 'CartController@deleteCart')->name('delete.cart');
Route::get('cart', 'CartController@cart');
Route::get('cart/{coupon_name}', 'CartController@cart' );
Route::post('update/cart', 'CartController@updateCart');

// END CartController

// CouponController


Route::resource('coupon', 'CouponController');

// END CouponController


// CheckoutController

Route::post('checkout', 'CheckoutController@index')->name('checkout.index');
Route::post('checkout/post', 'CheckoutController@post')->name('checkout.post');

// Ajax Request
Route::post('/get/city/list', 'CheckoutController@getcitylist');

// END CheckoutController

// StripeController
  Route::post('stripe', 'StripePaymentController@stripePost')->name('stripe.post');
// END StripeController


// PaypalController

Route::get('payment', 'PayPalController@payment')->name('payment');
Route::get('cancel', 'PayPalController@cancel')->name('payment.cancel');
Route::get('payment/success', 'PayPalController@success')->name('payment.success');

Route::get('online', 'PaymentController@online');

//payment form

// route for processing payment
// Route::post('paypal', 'PaymentController@payWithpaypal');
//
// // route for check status of the payment
// Route::get('status', 'PaymentController@getPaymentStatus');

// END PaypalController


// BlogController
Route::resource('blog', 'BlogController');
// END BlogController


Route::post('/create-payment', 'PaymentController@create')->name('create-payment');
Route::get('/execute-payment', 'PaymentController@execute')->name('execute-payment');
Route::get('/cancel', 'PaymentController@cancel')->name('cancel-payment');


