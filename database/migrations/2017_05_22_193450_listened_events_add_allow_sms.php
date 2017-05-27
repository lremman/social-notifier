<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ListenedEventsAddAllowSms extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('listened_events', function (Blueprint $table) {
            $table->integer('allow_sms');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('listened_events', function (Blueprint $table) {
            $table->dropColumn('allow_sms');
        });
    }
}
