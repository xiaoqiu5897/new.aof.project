<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVoucherDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('voucher_details', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('voucher_id')->unsigned();
            $table->integer('debit_account_id')->unsigned();
            $table->integer('credit_account_id')->unsigned();
            $table->bigInteger('amount_money');
            $table->string('content');
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
        Schema::dropIfExists('voucher_details');
    }
}
