<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RenameFileToLedger extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Rename company_file to `ledger`
        // Add "product" to ledger.
        // Add business_id to ledger.

        // Ledger: an abstract accounting entitity. Maps to a Financio biz or Premier serial+fileno.
        // User: someone that can login
        // Banking: Entity (i.e. RHB/DBS/etc)
        // BankAccount: A bank account (account num, name/alias, etc.) FK -> banking + ledger.
        // BankTransaction: <data/descript/credit/debit + FK-> bank_account.
        

        // CompanyFiles Resource -> `ledger` -> "Where Product = "Premier".
        // Business Resoruce -> `ledger` -> "where Product = Financio".
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
