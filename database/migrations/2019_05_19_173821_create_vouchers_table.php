<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVouchersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vouchers', function (Blueprint $table) {
            $table->increments('id');
            $table->string('code')->unique();
            $table->string('type');
            $table->dateTime('accounting_date');
            $table->integer('object_id')->unsigned();
            $table->string('name_payer');
            $table->string('addrress');
            $table->string('reason');
            $table->integer('money_id')->unsigned();
            $table->string('exchange_rate');
            $table->string('account_to');
            $table->string('account_from');
            $table->string('status');
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
        Schema::dropIfExists('vouchers');
    }
}
