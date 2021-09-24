<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UsersController extends Controller
{
    //过滤
    public function __construct()
    {
        $this->middleware('auth',[
            'except'=>['show','create','store']
        ]);
    }

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
            'name'=>'required|unique:users|max:50',
            'email'=>'required|email|unique:users|max:255',
            'password'=>'required|confirmed|min:6'
        ]);
        $user = User::create([
            'name'=>$request->name,
            'email'=>$request->email,
            'password'=>bcrypt($request->password),
        ]);
        Auth::login($user);
        session()->flash('success', '欢迎，您将在这里开启一段新的旅程~');
        return redirect()->route('users.show', [$user]);
    }

    //修改
    public function edit(User $user){
        $this->authorize('update',$user);
        //compact 相当于assign()
        return view('users.edit',compact('user'));
    }

    public function update(User $user,Request $request){
        $this->authorize('update', $user);
        //nullable 避免空白密码提交到数据库中 如果提交的密码为空则保持密码不变否则将新密码更新到数据库中
        $this->validate($request,[
            'name'=>'required|unique:users|max:50',
            'password'=>'nullable|confirmed|min:6'
        ]);
        $user->update([
            'name'=>$request->name,
            'password'=>bcrypt($request->password)
        ]);
        session()->flash('success','修改个人资料成功!');
        return redirect()->route('users.show',$user->id);
    }

    public function index(){
        $users = User::paginate(6);
        return view('users.index',compact('users'));
    }
}
