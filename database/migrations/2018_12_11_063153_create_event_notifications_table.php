<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEventNotificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('event_notifications', function (Blueprint $table) {
            $table->increments('id');
            $table->dateTime('time');
            $table->string('time_tz');
            $table->string('event_name');
            $table->string('provider');
            $table->string('source')->nullable();
            $table->string('filename');
            $table->dateTime('expiry');
            $table->string('expiry_tz');
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
        Schema::dropIfExists('event_notifications');
    }
}
