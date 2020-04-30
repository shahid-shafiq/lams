<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAssetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('assets', function (Blueprint $table) {
            $table->id();
            $table->string('code');
            $table->string('description');
            $table->integer('count')->unsigned();
            $table->date('purchased');
            $table->decimal('amount');
            $table->string('location');

            $table->integer('category_id')->unsigned();
            $table->integer('item_id')->unsigned();
            $table->integer('site_id')->unsigned();

            $table->foreign('category_id')->references('id')->on('categories');
            $table->foreign('item_id')->references('id')->on('items');
            $table->foreign('site_id')->references('id')->on('sites');

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
        Schema::dropIfExists('assets');
    }
}
