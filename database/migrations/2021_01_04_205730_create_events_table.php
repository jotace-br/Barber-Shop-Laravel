<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('auditory');
            $table->string('event_type');
            $table->string('description');
            $table->integer('people_quantity');
            $table->smallInteger('status')->nullable()->default(1);
            $table->smallInteger('fk_user')->nullable();
            $table->smallInteger('fk_sector')->nullable();
            $table->date('start_at');
            $table->date('end_at');
            $table->json('items');
            $table->json('emails');
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
        Schema::dropIfExists('events');
    }
}
