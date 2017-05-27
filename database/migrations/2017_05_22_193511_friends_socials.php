<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class FriendsSocials extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('friends_socials', function (Blueprint $table) {
            $table->increments('id');
            $table->string('provider');
            $table->integer('friend_id');
            $table->integer('remote_id');
            $table->string('remote_first_name')->nullable();
            $table->string('remote_last_name')->nullable();
            $table->text('description')->nullable();
            $table->string('remote_image')->nullable();

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
        Schema::dropIfExists('friends_socials');
    }
}
