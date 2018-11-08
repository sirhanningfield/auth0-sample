<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLedgerBankCredentialsTable extends Migration
{
    /**
     * Schema for storing Oauth credentials for a ledger connected to a bank
     *
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ledger_bank_credentials', function (Blueprint $table) {
            $table->increments('id');
            $table->uuid('ledger_id');
            $table->foreign('ledger_id')->references('id')->on('ledgers');
            
            $table->unsignedInteger('bank_id');
            $table->foreign('bank_id')->references('id')->on('banks');

            $table->unsignedInteger('status');
            $table->string('access_token');
            $table->string('refresh_token');
            $table->string('access_token_expiry');
            $table->string('refresh_token_expiry');
            $table->string('auth_code');
            $table->string('state');

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
        Schema::dropIfExists('ledger_bank_credentials');
    }
}
