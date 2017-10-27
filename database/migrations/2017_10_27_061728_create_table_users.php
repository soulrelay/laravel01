<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            //Laravel 5.4 migrate时报错: Specified key was too long error
            //具体怎么设置 稍后再细致处理
            //https://segmentfault.com/a/1190000008416200
            $table->increments('id');
            $table->string('username',191)->unique();
            $table->string('email',191)->unique()->nullable();
            $table->text('avatar_url')->nullable();
            $table->string('phone',191)->unique()->nullable();
            $table->string('password',191);
            $table->text('intro')->nullable();
            $table->timestamps();
        });

        //php artisan migrate --pretend
        //php artisan migrate
        //php artisan migrate:rollback

        //https://laravel-china.org/topics/2147/automatic-loading-of-autoload-static-in-composer
        //Composer 中自动加载 autoload_static 问题

        //.env配置数据库问题
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
