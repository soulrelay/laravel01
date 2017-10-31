<?php

namespace App\Http\Controllers;

use Illuminate\Support\Collection;

class CommonController extends Controller
{
    public function timeline()
    {
        /**问题：
         * 这里给了个limit的默认值2就没问题了，为什么paginate的默认值没有生效那?
         * */
        list($limit, $skip) = paginate(rq('page'), rq('limit', 3));
        /**
         * dd($limit); 打印发现$limit竟然是null而不是paginate设置的2
         * dd($skip); $skip正确 可能原因是：$limit这个变量在使用的时候如果为空则使用默认值，如果通过paginate封装成数组透传依然保留原来的传值
         * 解决方法：1、rq('limit', 2)使用默认值2   2、在paginate中透传时进行判空处理 目前采用的方法1
         */

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
