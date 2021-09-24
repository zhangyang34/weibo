<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SessionsController extends Controller
{
    // 显示登录页面
    public function create(){
        return view('sessions.create');
    }
    public function store(Request $request){
        $dataLogin = $this->validate($request,[
            'email'=>'required|email|max:255',
            'password'=>'required'
        ]);
        //使用auth方法判断用户输入的邮箱密码是否和数据库中一致否则报错
        if(Auth::attempt($dataLogin)){
            session()->flash('success','欢迎回家');
            return redirect()->route('users.show',[Auth::user()]);
        }else{
            session()->flash('danger', '很抱歉，您的邮箱和密码不匹配');
            return redirect()->back()->withInput();
        }
        return;

    }

    public function destroy(){
        //销毁当前用户的登录状态
        Auth::logout();
        session()->flash('success','您已成功退下');
        //返回登录页
        return redirect('login');
    }
}
