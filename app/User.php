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
            return err('username and password are required!');
        }

        $username = $has_username_and_password[0];
        $password = $has_username_and_password[1];

        //检查用户名是否存在
        $user_exists = $this
            ->where('username', $username)
            ->exists();

        if ($user_exists) {
            return err('username not exists');
        }

        //加密密码
        //$hashed_password = Hash::make($password);
        $hashed_password = bcrypt($password);
        //dd($hashed_password);

        //存入数据库
        $user = $this;
        $user->password = $hashed_password;
        $user->username = $username;
        //TODO 临时处理方法：创建数据库的时候 这个设置为不可为空字段 所以需要给个默认值
        $user->phone_captcha = '';

        if ($user->save()) {
            return suc(['id' => $user->id]);

        } else {
            return err('db insert failed!');

        }
    }

    //获取用户信息api
    public function read()
    {
        if (!rq('id')) {
            return err('required id');
        }
        $get = ['id', 'username', 'avatar_url', 'intro'];
        $user = $this->find(rq('id'), $get);
        $data = $user->toArray();

        $answer_count = answer_ins()->where('user_id', rq('id'))->count();
        $question_count = question_ins()->where('user_id', rq('id'))->count();

        $data['answer_count'] = $answer_count;

        $data['question_count'] = $question_count;

//使用关联表 得事先建立关联表  否则会报错
//        $answer_count = $user->answers()->count();
//        $question_count = $user->questions()->count();
        return suc($data);
    }

    //登录api
    public function login()
    {
        //dd(session('abc'));
        //dd(session('abc','cde'));

        $has_username_and_password = $this->has_username_and_password();
        //检查用户名和密码是否为空
        if (!$has_username_and_password) {
            return err('username and password are required!');
        }

        $username = $has_username_and_password[0];
        $password = $has_username_and_password[1];

        //检查用户是否存在
        $user = $this->where('username', $username)->first();

        if (!$user)
            return err('username not exits!');

        //检查密码是否正确
        $hashed_password = $user->password;
        if (!Hash::check($password, $hashed_password)) {
            return err('invalid password!');

        }

        //将用户信息写入session
        session()->put('username', $user->username);
        session()->put('user_id', $user->id);

        //dd(session()->all());

        return suc(['id' => $user->id]);

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
    public function is_logined_in()
    {
        //如果session存在user_id就返回user_id,否则就返回false
        return is_logined_in();
    }

    //修改密码api
    public function change_password()
    {
        //检查是否登录
        if (!$this->is_logined_in()) {
            return err('login required');
        }

        if (!rq('old_password') || !rq('new_password')) {
            return err('old_password and new_password are required');
        }

        $user = $this->find(session('user_id'));

        if (!Hash::check(rq('old_password'), $user->password)) {
            return err('invalid old_password');
        }

        $user->password = bcrypt(rq('new_password'));
        return $user->save() ?
            suc(null)
            : err('db update failed');
    }

    //找回密码api
    public function retrieve_password()
    {
        if ($this->is_robot())
            return err('max frequency reached');

        if (!rq('phone')) {
            return err('phone is required');
        }

        $user = $this->where('phone', rq('phone'))->first();
        if (!$user) return err('invalid phone number');

        $captcha = $this->generate_captcha();
        $user->phone_captcha = $captcha;
        if ($user->save()) {
            $this->send_sms();
            $this->update_robot_time();
            return suc();
        } else {
            return err('db update failed');
        }
    }

    //验证找回密码api
    public function validate_retrieve_password()
    {
        if ($this->is_robot(2))
            return err('max frequency reached');

        if (!rq('phone') || !rq('phone_captcha') || !rq('new_password')) {
            return err('phone, new_password and phone_captcha are required');
        }

        $user = $this->where([
            'phone' => rq('phone'),
            'phone_captcha' => rq('phone_captcha')
        ])->first();

        if (!$user)
            return err('invalid phone or invalid phone_captcha');

        $user->password = bcrypt(rq('new_password'));
        $this->update_robot_time();
        return $user->save() ? suc()
            : err('db update failed');
    }

    public function is_robot($time = 10)
    {
        if (!session('last_active_time'))
            return false;
        $current_time = time();
        $last_active_time = session('last_active_time');
        return ($current_time - $last_active_time < 10);
    }

    public function update_robot_time()
    {
        //为下一次机器人调用检查做准备
        session() . set('last_active_time', time());
    }

    //生成验证码
    public function generate_captcha()
    {
        return rand(1000, 9999);
    }

    //发送短信
    public function send_sms()
    {
        return true;
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
        return suc(null);

        //return redirect('/');


    }

    public function exist(){
     return suc(['count' => $this->where(rq())->count()]);
    }

    public function answers()
    {
        return $this->belongsToMany('App\Answer')
            ->withPivot('vote')
            ->withTimestamps();
    }

    public function questions()
    {
        return $this->belongsToMany('App\Question')
            ->withPivot('vote')
            ->withTimestamps();
    }
}
