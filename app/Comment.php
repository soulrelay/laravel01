<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    //添加评论api
    public function add()
    {
        //检查用户是否登录
        if (!user_ins()->is_logined_in()) {
            return ['status' => 0, 'msg' => 'login required'];
        }

        if (!rq('content')) {
            return ['status' => 0, 'msg' => 'empty content'];
        }

        if (!rq('question_id') && !rq('answer_id') || //none
            rq('question_id') && rq('answer_id') //all
        ) {
            return ['status' => 0, 'msg' => 'question_id or answer_id is required'];
        }

        if (rq('question_id')) {
            $question = question_ins()->find(rq('question_id'));
            if (!$question)
                return ['status' => 0, 'msg' => 'question not exists'];
            $this->question_id = rq['question_id'];
        } else {
            $answer = answer_ins()->find(rq('answer_id'));
            if (!$answer)
                return ['status' => 0, 'msg' => 'answer not exists'];
            $this->answer_id = rq('answer_id');
        }

        if (rq('reply_to')) {
            $target = $this->find(rq('reply_to'));
            if (!$target)
                return ['status' => 0, 'msg' => 'target comment not exists'];
            if ($target->user_id == session('user_id'))
                return ['status' => 0, 'msg' => 'cannot reply_to yourself'];
            $this->reply_to = rq('reply_to');
        }

        $this->content = rq('content');
        $this->user_id = session('user_id');

        return $this->save() ?
            ['status' => 1, 'id' => $this->id] :
            ['status' => 0, 'msg' => 'db insert failed'];
    }

    public function change()
    {

    }

    public function read()
    {
        if (!rq('question_id') && !rq('answer_id')){
            return ['status' => 0, 'msg' => 'question_id or answer_id is required'];
        }
        if (rq('question_id')) {
          $question = question_ins()->find(rq('question_id'));
          if(!$question)  return ['status' => 0, 'msg' => 'question not exists'];
            $data = $this->where('question_id',rq('question_id'))->get();
        }
        else {
            $answer = question_ins()->find(rq('answer_id'));
            if(!$answer)  return ['status' => 0, 'msg' => 'answer not exists'];
            $data = $this->where('answer_id',rq('answer_id'))->get();
        }

        return ['status' => 1, 'data' => $data->keyBy('id')];
    }

    //删除评论的api
    public function remove()
    {
        //检查用户是否登录
        if (!user_ins()->is_logined_in()) {
            return ['status' => 0, 'msg' => 'login required'];
        }

        if (!rq('id')) {
            return ['status' => 0, 'msg' => 'id is required'];
        }

        $comment = $this->find(rq('id'));
        if (!$comment) {
            return ['status' => 0, 'msg' => 'comment not exists'];
        }

        if (session('user_id') != $comment->user_id) {
            return ['status' => 0, 'msg' => 'permission denied'];
        }

        //删除回复该评论的评论
        $this->where('reply_to', rq('id'))->delete();
        //再删除该评论
        return $comment->delete() ? ['status' => 1]
            : ['status' => 0, 'msg' => 'db delete failed'];

    }
}
