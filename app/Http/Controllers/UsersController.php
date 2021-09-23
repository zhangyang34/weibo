<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
class UsersController extends Controller
{
    //注册
    public function create(){
        return view('users.create');
    }

    //显示用户的个人信息页面
    public function show(User $user){
        return view('users.show',compact('user'));
    }
}
