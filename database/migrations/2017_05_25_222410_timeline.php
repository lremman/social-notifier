<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Timeline extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('timelines', function (Blueprint $table) {
            $table->increments('id');
            $table->string('avatar_image')->nullable();
            $table->string('attached_photo')->nullable();
            $table->string('provider')->nullable();
            $table->string('page_url')->nullable();
            $table->text('description')->nullable();
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
        Schema::dropIfExists('timelines');
    }
}
