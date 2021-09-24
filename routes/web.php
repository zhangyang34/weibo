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

Route::get('/', function () {
    return view('welcome');
});
//首页
Route::get('/', 'StaticPagesController@home')->name('home');
// 帮助页
Route::get('/help', 'StaticPagesController@help')->name('help');
//关于我们
Route::get('/about', 'StaticPagesController@about')->name('about');
//注册页
Route::get('/signup','UsersController@create')->name('signup');
//用户 增删改查等页面
Route::resource('users', 'UsersController');
// 显示登录页 登录 退出页面
Route::get('login','SessionsController@create')->name('login');
Route::post('login','SessionsController@store')->name('login');
Route::delete('logout','SessionsController@destroy')->name('logout');


//用户curd 更新 修改

Route::get('/users/{user}/edit','UsersController@edit')->name('users.edit');

//激活路由
Route::get('signup/confirm/{token}', 'UsersController@confirmEmail')->name('confirm_email');

//填写 Email 的表单
Route::get('password/reset',  'PasswordController@showLinkRequestForm')->name('password.request');
//处理表单提交，成功的话就发送邮件，附带 Token 的链接
Route::post('password/email',  'PasswordController@sendResetLinkEmail')->name('password.email');
//显示更新密码的表单，包含 token
Route::get('password/reset/{token}',  'PasswordController@showResetForm')->name('password.reset');
//对提交过来的 token 和 email 数据进行配对，正确的话更新密码
Route::post('password/reset',  'PasswordController@reset')->name('password.update');
