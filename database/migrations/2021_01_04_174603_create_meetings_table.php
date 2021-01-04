<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMeetingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('meetings', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('description');
            $table->string('motif');
            $table->string('room');
            $table->time('start_at', $precision = 0);
            $table->time('end_at', $precision = 0);
            $table->date('date');
            $table->smallInteger('status')->nullable()->default(1);
            $table->smallInteger('fk_user')->nullable();
            $table->smallInteger('fk_sector')->nullable();
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
        Schema::dropIfExists('meetings');
    }
}
