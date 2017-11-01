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
            return err('login required');
        }

        if (!rq('question_id') || !rq('content')) {
            return err('question_id and content is required');
        }

        $question = question_ins()->find(rq('question_id'));
        if (!$question) {
            return err('question not exists');
        }

        //检查是否重复回答
        $answered = $this
            ->where(['question_id' => rq('question_id'), 'user_id' => session('user_id')])
            ->count();

        if ($answered) {
            return err('duplicate answers');
        }

        $this->content = rq('content');
        $this->question_id = rq('question_id');
        $this->user_id = rq('user_id');

        return $this->save() ?
            suc(['id' => $this->id]) :
            err('db insert failed');
    }

    //更新回答api
    public function change()
    {
        //检查用户是否登录
        if (!user_ins()->is_logined_in()) {
            return err('login required');
        }

        if (!rq('id') || !rq('content')) {
            return err('id and content is required');
        }

        $answer = $this->find(rq('id'));
        if ($answer->user_id != session('user_id')) {
            return err('permission denied');
        }

        $answer->content = rq('content');

        return $answer->save() ?
            suc(null)
            : err('db update failed');

    }

    public function read_by_user_id($user_id)
    {
        $user = user_ins()->find($user_id);
        if (!$user)
            return err('user not exists');
        $r = $this->where('user_id', $user_id)
            ->get()->keyBy('id');
        return suc($r->toArray());
    }

    //查看回答api
    public function read()
    {
        if (!rq('id') && !rq('question_id') && !rq('user_id')) {
            return err('id or question_id or user_id is required');
        }

        if (rq('user_id')) {
            $user_id = rq('user_id') === 'self'
                ? session('user_id')
                : rq('user_id');
            return $this->read_by_user_id($user_id);
        }

        if (rq('id')) {
            $answer = $this
                ->with('user')
                ->with('users')
                ->find(rq('id'));
            if (!$answer) {
                return err('answer not exists');
            }

            return ['status' => 1, 'data' => $answer];
        }

        if (!question_ins()->find(rq('question_id'))) {
            return err('question not exists');
        }

        $answers = $this->where('question_id', rq('question_id'))
            ->get()
            ->keyBy('id');

        return suc(['data' => $answers]);
    }

    public function remove()
    {

    }

    //投票api
    public function vote()
    {
        //检查用户是否登录
        if (!user_ins()->is_logined_in()) {
            return err('login required');
        }
        if (!rq('id') || !rq('vote')) {
            return err('id and vote are required');
        }

        $answer = $this->find(rq('id'));
        if (!$answer) return err('answer not exists');

        /*1为赞同 2为反对 3为清空*/
        $vote = rq('vote');
        if ($vote != 1 && $vote != 2 && $vote != 3) {
            return err('invalid vote');
        }

        /*检查此用户是否在相同问题下投过票,如果投过票就删除投票*/
        $answer->users()
            ->newPivotStatement()
            ->where('user_id', session('user_id'))
            ->where('answer_id', rq('id'))
            ->delete();

        if ($vote == 3) {
            return suc();
        }

        //在连接表中增加数据
        $answer->users()->attach(session('user_id'), ['vote' => $vote]);

        return suc();
    }

    public function users()
    {
        return $this->belongsToMany('App\User')
            ->withPivot('vote')
            ->withTimestamps();
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
