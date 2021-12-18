<?php

use App\Http\Controllers\StudentController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

use App\Http\Controllers\UserController;

Route::get('/api1', [StudentController::class, 'apiFetch']);



// //Route::group(['domain' => '{subdomain}.' . env('APP_SUB_URL'), 'middleware' => ['subdomain_setup']], function() {
//     Route::group([],function() {
//         Route::post('user/register', 'APIRegisterController@register');
//         Route::post('user/login', 'APILoginController@login');
        
//         Route::post('lead', 'LeadController@index');
//         Route::get('/cron/report', 'ReportController@index');
//     //    Route::post('payment_success', 'PaymentController@paymentSuccess');
//     //    Route::post('payment_success_hdfc', 'PaymentController@paymentSuccessHdfc');
//         Route::get('thankyou/{id?}', 'PaymentController@thankyou');
//         Route::get('error_page/{msg?}', 'PaymentController@errorPage');
//         Route::get('quickpay', 'PaymentController@quickpay');
//     //    Route::get('userlogin/{id?}', 'PaymentController@userlogin');
//         Route::get('pay/{id?}', 'PaymentController@pay');
//         Route::get('pay_now/{id?}', 'PaymentController@payNow');
//         Route::post('payment_success_admin', 'PaymentController@paymentSuccessAdmin');
//         Route::any('typeform', 'TypeFormController@index');
//         Route::any('typeform-job', 'TypeFormController@job');
//     });
    
//     //Route::group(['domain' => '{subdomain}.' . env('APP_SUB_URL'), 'middleware' => ['auth:api']], function() {
//     Route::group(['middleware' => ['auth:api']], function() {
//         Route::get('user/getInfo', 'APILoginController@getInfo');
//         Route::get('user/logout', 'APILoginController@logout');
//     });
    
