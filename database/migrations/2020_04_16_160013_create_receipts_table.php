<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReceiptsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('receipts', function (Blueprint $table) {
            $table->id();
            $table->integer('no').unsigned();
            $table->date('rdate');
            $table->string('title');
            $table->string('description');
            $table->decimal('amount');

            $table->integer('payment_id').unsigned();
            $table->integer('income_id').unsigned();
            $table->integer('account_id').unsigned();
            $table->integer('department_id').unsigned();
            $table->integer('period_id').unsigned();
            $table->integer('member_id').unsigned();

            $table->date('fdate');
            $table->date('tdate');

            $table->integer('site_id').unsigned();
            $table->timestamps();

            $table->foreign('payment_id')->references('id')->on('payments');
            $table->foreign('income_id')->references('id')->on('incomes');
            $table->foreign('department_id')->references('id')->on('departments');
            $table->foreign('period_id')->references('id')->on('periods');
            $table->foreign('member_id')->references('id')->on('members');
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
        Schema::dropIfExists('receipts');
    }
}
