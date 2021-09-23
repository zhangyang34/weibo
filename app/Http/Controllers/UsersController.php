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
    // 注册表单
    public function  store(Request $request){
        $this->validate($request,[
            'name'=>'required|unique:users|max50',
            'email'=>'required|email|unique:users|max:255',
            'password'=>'required|confirmed|min:6'
        ]);
        return;
    }

}
