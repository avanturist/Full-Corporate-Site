<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeArticlesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('articles', function (Blueprint $table) {
            // unsigned- поле повинно бути > 0
            $table->integer('user_id')->unsigned()->default(1);
            //зовнішній ключ таблички atnicles з табличкою users. references - звязок user_id(users) з полем id(articles)
            $table->foreign('user_id')->references('id')->on('users');

            // articles з categories (тобто конкретний пост з конкретною категорією)
            $table->integer('category_id')->unsigned()->defaul(1);
            $table->foreign('category_id')->references('id')->on('categories');


        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('articles', function (Blueprint $table) {
            //

        });
    }
}
