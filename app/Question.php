<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    //创建问题
    public function add()
    {
        //dd(rq());
        //检查是否登录
        if (!user_ins()->is_logined_in()) {
            return ['status' => 0, 'msg' => 'login required'];
        }

        //检查是否存在标题
        if (!rq('title')) {
            return ['status' => 0, 'msg' => 'required title'];
        }

        $this->title = rq('title');
        $this->user_id = session('user_id');
        if (rq('des')) {//如果存在描述，就添加描述
            $this->desc = rq('desc');
        }

        return $this->save() ?
            ['status' => 1, 'id' => $this->id] :
            ['status' => 0, 'msg' => 'db insert failed'];
    }

    public function change()
    {
        //检查是否登录
        if (!user_ins()->is_logined_in()) {
            return ['status' => 0, 'msg' => 'login required'];
        }

        if (!rq('id')) {
            return ['status' => 0, 'msg' => 'id is required'];
        }

        $question = $this->find(rq('id'));

        if (!$question) {
            return ['status' => 0, 'msg' => 'question not exits'];
        }

        if ($question->user_id != session('user_id')) {
            return ['status' => 0, 'msg' => 'permission denied'];
        }

        if (rq('title')) {
            $question->title = rq('title');
        }

        if (rq('desc')) {
            $question->desc = rq('desc');
        }
        //dd($question);

        return $question->save() ?
            ['status' => 1] :
            ['status' => 0, 'msg' => 'db update failed'];

    }

    //查看问题api
    public function read()
    {
        //请求参数中是否有id，如果有id就直接返回id所在的行
        if (rq('id'))
            return ['status' => 1, 'data' => $this->find(rq('id'))];

        //limit条件
        $limit = rq('limit') ?: 15;
        //$skip = ((rq('page')?:1)-1) * $limit;
        //skip条件 用于分页
        $skip = (rq('page') ? rq('page') - 1 : 0) * $limit;


        //构建query并返回collection数据
        $r = $this->orderBy('created_at')
            ->limit($limit)
            ->skip($skip)
            //->get(['id','title','desc','user_id','created_at','updated_at']);
            ->get();
        //->keyBy('id');
        return ['status' => 1, 'data' => $r];

    }
}
