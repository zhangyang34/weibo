<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Mail;
class UsersController extends Controller
{
    //过滤
    public function __construct()
    {
        $this->middleware('auth',[
            'except'=>['show','create','store','index','confirmEmail']
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
//        Auth::login($user);
        $this->sendEmailConfirmationTo($user);
        session()->flash('success', '验证邮件已发送到你的注册邮箱上，请注意查收。');
        return redirect()->route('users.show', [$user]);
    }
    //发送邮件
    protected function sendEmailConfirmationTo($user){
        $view = 'emails.confirm';
        $data = compact('user');
        $from = 'summer@example.com';
        $name = 'Summer';
        $to = $user->email;
        $subject = "感谢注册 weibo应用！请确认你的邮箱。";
        Mail::send($view, $data, function ($message) use ($from, $name, $to, $subject) {
            $message->from($from, $name)->to($to)->subject($subject);
        });
    }
    //激活
    public function confirmEmail($token){
        //根据激活令牌查询当前的用户

        $user = User::where('activation_token',$token)->firstOrFail();
        //激活状态设置为true
        $user->activated = true;
        //激活令牌设置为空
        $user->activation_token = null;
        //更新数据
        $user->save();
        Auth::login($user);
        session()->flash('success','恭喜你，激活成功！');
        return redirect()->route('users.show',[$user]);
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
    public function destroy(User $user)
    {
        $user->delete();
        session()->flash('success', '成功删除用户！');
        return back();
    }



}
