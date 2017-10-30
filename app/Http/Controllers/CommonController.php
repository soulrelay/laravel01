<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class CommonController extends Controller
{
    public function timeline()
    {
        //TODO 有问题 后面再分析
        //list($limit, $skip) = paginate(rq('page'), rq('limit'));
        $limit = 5;
        $skip = (rq('page') ? rq('page') - 1 : 0) * $limit;
        $questions = question_ins()
            ->limit($limit)
            ->with('user')
            ->skip($skip)
            ->orderBy('created_at', 'desc')
            ->get();

        $answers = answer_ins()
            ->limit($limit)
            ->with('users')
            ->with('user')
            ->skip($skip)
            ->orderBy('created_at', 'desc')
            ->get();
//        dd($questions->toArray());
//        dd($answers->toArray());
        //合并数据
        $collection = new Collection;
        $data = $collection->merge($questions)->merge($answers);
        $data = $data->sortByDesc(function ($item) {
            return $item->created_at;
        });

        $data = $data->values()->all();
        return ['status' => 1, 'data' => $data];
    }
}
