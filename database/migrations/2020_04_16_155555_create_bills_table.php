<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBillsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bills', function (Blueprint $table) {
            $table->id();
            $table->integer('no')->unsigned();
            $table->date('bdate');
            $table->string('title');
            $table->string('description');
            $table->decimal('amount');

            $table->integer('payment_id')->unsigned();
            $table->integer('expense_id')->unsigned();
            $table->integer('account_id')->unsigned();
            $table->integer('department_id')->unsigned();
            $table->integer('period_id')->unsigned();
            $table->integer('site_id')->unsigned();
            $table->timestamps();

            $table->foreign('payment_id')->references('id')->on('payments');
            $table->foreign('expense_id')->references('id')->on('expenses');
            $table->foreign('account_id')->references('id')->on('accounts');
            $table->foreign('department_id')->references('id')->on('departments');
            $table->foreign('period_id')->references('id')->on('periods');
            $table->foreign('site_id')->references('id')->on('sites');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bills');
    }
}
