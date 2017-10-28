<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    //添加回答api
    public function add()
    {

        //检查用户是否登录
        if (!user_ins()->is_logined_in()) {
            return ['status' => 0, 'msg' => 'login required'];
        }

        if (!rq('question_id') || !rq('content')) {
            return ['status' => 0, 'msg' => 'question_id and content is required'];
        }

        $question = question_ins()->find(rq('question_id'));
        if (!$question) {
            return ['status' => 0, 'msg' => 'question not exists'];
        }

        //检查是否重复回答
        $answered = $this
            ->where(['question_id' => rq('question_id'), 'user_id' => session('user_id')])
            ->count();

        if($answered){
            return ['status' => 0, 'msg' => 'duplicate answers'];
        }

        $this->content = rq('content');
        $this->question_id = rq('question_id');
        $this->user_id = rq('user_id');

        return $this->save()?
            ['status' => 1, 'id' => $this->id]:
            ['status' => 0, 'msg' => 'db insert failed'];



    }
}
