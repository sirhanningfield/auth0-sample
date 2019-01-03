<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DropPasswordAndRenameSecretkeyToAuthId extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //Drop password column
        Schema::table('users', function (Blueprint $table) {
          $table->dropColumn('password');
        });

          // Rename secret_key to auth_id
          Schema::table('users', function(Blueprint $table) {
            $table->renameColumn('secret_key', 'auth_id');
            $table->unique('auth_id');
        });  
        
        Schema::table('users', function (Blueprint $table) {
            $table->string('name')->nullable()->change();
        });        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('password');
        });

        Schema::table('users', function (Blueprint $table) {
            $table->renameColumn('auth_id', 'secret_key');
            $table->dropForeign('auth_id');
        });

        Schema::table('users', function (Blueprint $table) {
            $table->string('name')->nullable(false)->change();
        });        
    }
}
