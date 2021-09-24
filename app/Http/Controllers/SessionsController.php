<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SessionsController extends Controller
{
    public function __construct()
    {
        //未登录用户可以访问注册
        $this->middleware('auth', [
            'except' => ['show', 'create', 'store']
        ]);
        //未登录用户只能访问登录页面
        $this->middleware('guest', [
            'only' => ['create']
        ]);
        //登录限流十分钟只能登录十次
        $this->middleware('throttle:10,10', [
            'only' => ['store']
        ]);
    }
    // 显示登录页面
    public function create(){
        return view('sessions.create');
    }
    //登录验证
    public function store(Request $request){
        $dataLogin = $this->validate($request,[
            'email'=>'required|email|max:255',
            'password'=>'required'
        ]);
        //使用auth方法判断用户输入的邮箱密码是否和数据库中一致否则报错 remember 记住我功能可以延续至5年
        if(Auth::attempt($dataLogin,$request->has('remember'))){
            if(Auth::user()->activated){
                session()->flash('success','欢迎回家');
                $fallback = route('users.show',[Auth::user()]);
                return redirect()->intended($fallback);
            }else{
                Auth::logout();
                session()->flash('warning','你的账号未激活，请检查邮箱中的注册邮件进行激活。');
                return redirect('/');
            }
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
