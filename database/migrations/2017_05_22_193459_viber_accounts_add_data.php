<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ViberAccountsAddData extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('viber_accounts', function (Blueprint $table) {
            $table->string('name')->nullable();
            $table->string('avatar')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('viber_accounts', function (Blueprint $table) {
            $table->dropColumn('name');
            $table->dropColumn('avatar');
        });
    }
}
