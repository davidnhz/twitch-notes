<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStreamerNotesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('streamer_notes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('streamer_id');
            $table->string('content');
            $table->string('game_name');
            $table->string('stream_title');
            $table->string('thumbnail')->nullable();
            $table->timestamps();

            $table->foreign('streamer_id')->references('id')->on('streamers')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('notes');
    }
}
