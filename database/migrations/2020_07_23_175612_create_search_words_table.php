<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSearchWordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('search_words', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->biginteger('item_id')->unsigned();
            $table->foreign('item_id')->references('id')->on('items');
            $table->string('search_word');
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
        Schema::dropIfExists('search_words');
    }
}
