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
        // Rename company_files to `ledgers`
        Schema::rename('company_files', 'ledgers');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // rename `ledgers` back to `company_files`
        Schema::rename('ledgers', 'company_files');
    }
}
