<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAddressToCompanyFile extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasColumn('company_files', 'address')) {
            Schema::table('company_files', function (Blueprint $table) {
                $table->text('address')->nullable();
            });
        }

        if (!Schema::hasColumn('company_files', 'name')) {
            Schema::table('company_files', function (Blueprint $table) {
                $table->text('name')->nullable();
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
        if (Schema::hasColumn('company_files', 'address')) {
            Schema::table('company_files', function (Blueprint $table) {
                $table->dropColumn('address');
            });
        }

        if (Schema::hasColumn('company_files', 'name')) {
            Schema::table('company_files', function (Blueprint $table) {
                $table->dropColumn('name');
            });
        }
    }
}
