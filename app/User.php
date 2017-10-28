<?php

namespace App;

use Hash;
use Illuminate\Database\Eloquent\Model;
use Request;

class User extends Model
{
    //注册api
    public function signup()
    {
        /*
         * 检查用户名是否为空 检查密码是否为空 检查用户名是否存在 加密密码 存入数据库
         */
        //dd(Request::has('username'));
        //dd(Request::get('username'));
        //dd(Request::all());

        $has_username_and_password = $this->has_username_and_password();
        //检查用户名和密码是否为空
        if (!$has_username_and_password) {
            return ['status' => 0, 'msg' => 'username and password are required!'];
        }

        $username = $has_username_and_password[0];
        $password = $has_username_and_password[1];

        //检查用户名是否存在
        $user_exists = $this
            ->where('username', $username)
            ->exists();

        if ($user_exists) {
            return ['status' => 0, 'msg' => 'username not exists'];
        }

        //加密密码
        //$hashed_password = Hash::make($password);
        $hashed_password = bcrypt($password);
        //dd($hashed_password);

        //存入数据库
        $user = $this;
        $user->password = $hashed_password;
        $user->username = $username;

        if ($user->save()) {
            return ['status' => 1, 'id' => $user->id];

        } else {
            return ['status' => 0, 'msg' => 'db insert failed!'];

        }
    }

    //登录api
    public function login()
    {
        //dd(session('abc'));
        //dd(session('abc','cde'));

        $has_username_and_password = $this->has_username_and_password();
        //检查用户名和密码是否为空
        if (!$has_username_and_password) {
            return ['status' => 0, 'msg' => 'username and password are required!'];
        }

        $username = $has_username_and_password[0];
        $password = $has_username_and_password[1];

        //检查用户是否存在
        $user = $this->where('username', $username)->first();

        if (!$user)
            return ['status' => 0, 'msg' => 'username not exits!'];

        //检查密码是否正确
        $hashed_password = $user->password;
        if(!Hash::check($password,$hashed_password)){
            return ['status' => 0, 'msg' => 'invalid password!'];

        }

        //将用户信息写入session
        session()->put('username',$user->username);
        session()->put('user_id',$user->id);

        //dd(session()->all());

        return ['status' => 1, 'id' => $user->id];

    }

    public function has_username_and_password()
    {

        $username = rq('username');
        $password = rq('password');

        if ($username && $password) {
            return [$username, $password];
        }

        return false;
    }

    //检测用户是否登录
    public function is_logined_in(){
        //如果session存在user_id就返回user_id,否则就返回false
        return session('user_id')?:false;
    }

    public function change_password(){
        //检查是否登录
        if (!$this->is_logined_in()) {
            return ['status' => 0, 'msg' => 'login required'];
        }

        if (!rq('old_password') || !rq('new_password')) {
            return ['status' => 0, 'msg' => 'old_password and new_password is required'];
        }

        $user=$this->find(session('user_id'));

        if(!Hash::check(rq('old_password'),$user->password)){
            return ['status' => 0, 'msg' => 'invalid old_password'];
        }

        $user->password = bcrypt(rq('new_password'));
        return $user->save()?
            ['status' => 1]
            :['status' => 0, 'msg' => 'db update failed'];
    }

    //登出api
    public function logout()
    {
//        session()->flush();
//        dd(session()->all());
//        session()->put('username',null);
//        session()->put('user_id',null);
        //删除用户名和用户id
        session()->forget('username');
        session()->forget('user_id');
//        session()->pull('username');
//        session()->pull('user_id');
        //使用set有问题
//        session()->put('person.name','xiaoming');
//        session()->put('person.friend.hanmeimei.age','20');
//
//        dd(session()->all());
        return ['status' => 1];

        //return redirect('/');


    }

    public function answers()
    {
        return $this->belongsToMany('App\Answer')
            ->withPivot('vote')
            ->withTimestamps();
    }
}
