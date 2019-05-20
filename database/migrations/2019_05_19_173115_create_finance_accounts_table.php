<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFinanceAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('finance_accounts', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('code')->unique();
            $table->string('name');
            $table->string('type');
            $table->integer('level');
            $table->integer('parent_id');
            $table->bigInteger('surplus_debit');
            $table->bigInteger('surplus_credit');
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
        Schema::dropIfExists('finance_accounts');
    }
}
