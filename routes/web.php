<?php

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
function paginate($page = 1, $limit = 2)
{
    $skip = ($page ? $page - 1 : 0) * $limit;
    return [$limit, $skip];

}

function rq($key = null, $default = null)
{
    if (!$key) return Request::all();
    return Request::get($key, $default);
}

function err($msg = null)
{
    return ['status' => 0, 'msg' => $msg];
}

function suc($data_to_merge = null)
{
    $data = ['status' => 1, 'data' => []];
    if ($data_to_merge)
        $data['data'] = array_merge($data['data'], $data_to_merge);
    return $data;
}

//检测用户是否登录
function is_logined_in()
{
    //如果session存在user_id就返回user_id,否则就返回false
    return session('user_id') ?: false;
}

function user_ins()
{
    return new App\User;
}

function question_ins()
{
    return new App\Question();
}

function answer_ins()
{
    return new App\Answer();
}

function comment_ins()
{
    return new App\Comment();
}

Route::get('/', function () {
    return view('index');
});

Route::any('api', function () {
    return ['version' => 0.1];
});

//Route::any('api/user', function () {
//    return 'user api!';
//});

//php artisan make:model User

Route::any('api/user/signup', function () {
    return user_ins()->signup();
});

Route::any('api/user/read', function () {
    return user_ins()->read();
});

Route::any('api/user/login', function () {
    return user_ins()->login();
});

Route::any('api/user/logout', function () {
    return user_ins()->logout();
});

//修改密码
Route::any('api/user/changepassword', function () {
    return user_ins()->change_password();
});

//找回密码
Route::any('api/user/retrieve_password', function () {
    return user_ins()->retrieve_password();
});

//验证找回密码
Route::any('api/user/validate_retrieve_password', function () {
    return user_ins()->validate_retrieve_password();
});

//用户是否存在
Route::any('api/user/exist', function () {
    return user_ins()->exist();
});


//question相关接口
Route::any('api/question/add', function () {
    return question_ins()->add();
});

Route::any('api/question/change', function () {
    return question_ins()->change();
});

Route::any('api/question/read', function () {
    return question_ins()->read();
});

Route::any('api/question/remove', function () {
    return question_ins()->remove();
});

//answer相关接口
Route::any('api/answer/add', function () {
    return answer_ins()->add();
});

Route::any('api/answer/change', function () {
    return answer_ins()->change();
});

Route::any('api/answer/read', function () {
    return answer_ins()->read();
});

Route::any('api/answer/remove', function () {
    return answer_ins()->remove();
});

Route::any('api/answer/vote', function () {
    return answer_ins()->vote();
});

//comment相关接口
Route::any('api/comment/add', function () {
    return comment_ins()->add();
});

Route::any('api/comment/change', function () {
    return comment_ins()->change();
});

Route::any('api/comment/read', function () {
    return comment_ins()->read();
});

Route::any('api/comment/remove', function () {
    return comment_ins()->remove();
});

//通用api
Route::any('api/timeline', 'CommonController@timeline');


