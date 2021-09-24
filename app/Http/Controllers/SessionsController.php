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
        if(Auth::attempt($dataLogin)){
            session()->flash('success','欢迎回家');
            return redirect()->route('users.show',[Auth::user()]);
        }else{
            session()->flash('danger', '很抱歉，您的邮箱和密码不匹配');
            return redirect()->back()->withInput();
        }
        return;

    }
}
