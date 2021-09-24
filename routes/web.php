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



