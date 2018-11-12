<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddScopeToLedgerBankCredentials extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasColumn('ledger_bank_credentials', 'scope')) {
            Schema::table('ledger_bank_credentials', function (Blueprint $table) {
                $table->text('scope')->nullable();
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasColumn('ledger_bank_credentials', 'scope')) {
            Schema::table('ledger_bank_credentials', function (Blueprint $table) {
                $table->dropColumn('scope');
            });
        }
    }
}
