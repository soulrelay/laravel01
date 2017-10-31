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
            return err('login required');
        }

        //检查是否存在标题
        if (!rq('title')) {
            return err('required title');
        }

        $this->title = rq('title');
        $this->user_id = session('user_id');
        if (rq('desc')) {//如果存在描述，就添加描述
            $this->desc = rq('desc');
        }

        return $this->save() ?
            suc(['id' => $this->id] ):
            err('db insert failed');
    }

    public function change()
    {
        //检查是否登录
        if (!user_ins()->is_logined_in()) {
            return err('login required');
        }

        if (!rq('id')) {
            return err('id is required');
        }

        $question = $this->find(rq('id'));

        if (!$question) {
            return err('question not exits');
        }

        if ($question->user_id != session('user_id')) {
            return err('permission denied');
        }

        if (rq('title')) {
            $question->title = rq('title');
        }

        if (rq('desc')) {
            $question->desc = rq('desc');
        }
        //dd($question);

        return $question->save() ?
            suc(null) :
            err('db update failed');

    }

    //查看问题api
    public function read()
    {
        //请求参数中是否有id，如果有id就直接返回id所在的行
        if (rq('id'))
            return ['status' => 1, 'data' => $this->find(rq('id'))];

        //limit条件
        //skip条件 用于分页
        list($limit, $skip) = paginate(rq('page'), rq('limit'),5);

        //构建query并返回collection数据
        $r = $this->orderBy('created_at')
            ->limit($limit)
            ->skip($skip)
            //->get(['id','title','desc','user_id','created_at','updated_at']);
            ->get();
        //->keyBy('id');
        return suc(['data' => $r]);

    }

    //删除问题api
    public function remove()
    {
        //检查是否登录
        if (!user_ins()->is_logined_in()) {
            return err('login required');
        }

        if (!rq('id')) {
            return err('id is required');
        }

        $question = $this->find(rq('id'));

        if (!$question) {
            return err('question not exists');
        }

        if (session('user_id') != $question->user_id) {
            return err('permission denied');
        }

        return $question->delete() ? suc(null)
            : err('db delete failed');

    }

    public function user(){
        return $this->belongsTo('App\User');
    }
}
