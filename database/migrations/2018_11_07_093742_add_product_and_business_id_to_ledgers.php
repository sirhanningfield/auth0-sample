<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddProductAndBusinessIdToLedgers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Add product column to legers
        if (!Schema::hasColumn('ledgers', 'product')) {
            Schema::table('ledgers', function (Blueprint $table) {
                $table->text('product')->nullable();
            });
        }

        // Add business_id column to ledgers
        if (!Schema::hasColumn('ledgers', 'business_id')) {
            Schema::table('ledgers', function (Blueprint $table) {
                $table->text('business_id')->nullable();
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
        //
        if (Schema::hasColumn('ledgers', 'product')) {
            Schema::table('ledgers', function (Blueprint $table) {
                $table->dropColumn('product');
            });
        }

        if (Schema::hasColumn('ledgers', 'business_id')) {
            Schema::table('ledgers', function (Blueprint $table) {
                $table->dropColumn('business_id');
            });
        }
    }
}
