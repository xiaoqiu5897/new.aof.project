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
            $table->date('accounting_date');
            $table->integer('object_id')->unsigned()->nullable();
            $table->string('name_payer');
            $table->string('addrress')->nullable();
            $table->string('reason');
            $table->string('money')->nullable();
            $table->string('exchange_rate')->nullable();
            $table->string('account_to')->nullable();
            $table->integer('bank_account_id')->unsigned()->nullable();
            $table->string('status')->default(0);
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
