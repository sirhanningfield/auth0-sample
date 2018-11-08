<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBankTransactionsTable extends Migration
{
    /**
     * Schema to store bank transactions (feed) against bank accounts and dates
     * Run the migrations.
     * @return void
     */
    public function up()
    {
        Schema::create('bank_transactions', function (Blueprint $table) {
            $table->increments('id');

            $table->unsignedInteger('account_id');
            $table->foreign('account_id')->references('id')->on('bank_accounts');

            $table->date('date');
            $table->string('description');
            $table->decimal('credit');
            $table->decimal('debit');


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
        Schema::dropIfExists('bank_transactions');
    }
}
