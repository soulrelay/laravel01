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
            return err('login required');
        }

        if (!rq('content')) {
            return err('empty content');
        }

        if (!rq('question_id') && !rq('answer_id') || //none
            rq('question_id') && rq('answer_id') //all
        ) {
            return err('question_id or answer_id is required');
        }

        if (rq('question_id')) {
            $question = question_ins()->find(rq('question_id'));
            if (!$question)
                return err('question not exists');
            $this->question_id = rq['question_id'];
        } else {
            $answer = answer_ins()->find(rq('answer_id'));
            if (!$answer)
                return err('answer not exists');
            $this->answer_id = rq('answer_id');
        }

        if (rq('reply_to')) {
            $target = $this->find(rq('reply_to'));
            if (!$target)
                return err('target comment not exists');
            if ($target->user_id == session('user_id'))
                return err('cannot reply_to yourself');
            $this->reply_to = rq('reply_to');
        }

        $this->content = rq('content');
        $this->user_id = session('user_id');

        return $this->save() ?
            suc(['id' => $this->id]):
            err('db insert failed');
    }

    public function change()
    {

    }

    public function read()
    {
        if (!rq('question_id') && !rq('answer_id')){
            return err('question_id or answer_id is required');
        }
        if (rq('question_id')) {
          $question = question_ins()->find(rq('question_id'));
          if(!$question)  return err('question not exists');
            $data = $this->where('question_id',rq('question_id'))->get();
        }
        else {
            $answer = question_ins()->find(rq('answer_id'));
            if(!$answer)  return err('answer not exists');
            $data = $this->where('answer_id',rq('answer_id'))->get();
        }

        $data = $data->keyBy('id');
        return suc(['data' => $data]);
    }

    //删除评论的api
    public function remove()
    {
        //检查用户是否登录
        if (!user_ins()->is_logined_in()) {
            return err('login required');
        }

        if (!rq('id')) {
            return err('id is required');
        }

        $comment = $this->find(rq('id'));
        if (!$comment) {
            return err('comment not exists');
        }

        if (session('user_id') != $comment->user_id) {
            return err('permission denied');
        }

        //删除回复该评论的评论
        $this->where('reply_to', rq('id'))->delete();
        //再删除该评论
        return $comment->delete() ? suc(null)
            : err('db delete failed');

    }
}
