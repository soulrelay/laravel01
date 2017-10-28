<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableQuestions extends Migration
{
    //php artisan make:migration create_table_questions --create=questions
    //php artisan migrate
    //php artisan migrate:rollback
    //php artisan make:model Question

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('questions', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title',64);
            $table->text('desc')->nullable()->comment('description');
            $table->unsignedInteger('user_id');
            $table->string('status',191)->default('ok');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('questions');
    }
}
