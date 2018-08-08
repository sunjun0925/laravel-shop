<?php

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

//Route::get('/', function () {
//    return view('welcome');
//});

Route::get('/', 'PagesController@root')->name('root');

Auth::routes();

Route::group(['middleware' => 'auth'], function () {
    
    Route::get('/email_verify_notice', 'PagesController@emailVerifyNotice')->name('email_verify_notice');  //验证邮箱提示页面
    Route::get('/email_verification/verify', 'EmailVerificationController@verify')->name('email_verification.verify');  //邮箱激活链接验证
    Route::get('/email_verification/send', 'EmailVerificationController@send')->name('email_verification.send');        //用户主动发送邮件路由
    
    Route::group(['middleware' => 'email_verified'], function() {
        Route::get('user_addresses', 'UserAddressesController@index')->name('user_addresses.index');
    });
});