<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBankAccountsTable extends Migration
{
    /**
     * Shema for bank accounts
     * Run the migrations.
     * @return void
     */
    public function up()
    {
        Schema::create('bank_accounts', function (Blueprint $table) {
            $table->increments('id');

            $table->uuid('ledger_id');
            $table->foreign('ledger_id')->references('id')->on('ledgers');
            
            $table->unsignedInteger('bank_id');
            $table->foreign('bank_id')->references('id')->on('banks');

            
            $table->unsignedInteger('currency_id');
            $table->foreign('currency_id')->references('id')->on('currencies');

            $table->string('account_no');
            $table->string('name');
            $table->string('description');
            $table->string('type');
            $table->decimal('balance', 13, 2);

            $table->unsignedInteger('bank_feed');
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
        Schema::dropIfExists('bank_accounts');
    }
}
