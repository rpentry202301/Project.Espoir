<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {

            $table->id();

            // ここにカラムを追加していく
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->boolean('admin_flag')->default(false);

            //メール送信機能 (デフォルトはnull。利用時は別途設定が必要)
            // $table->timestamp('email_verified_at')->nullable();

            $table->rememberToken(); //ログインしているかどうかを判断するためのトークン。
            $table->timestamps();
        });
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
};
