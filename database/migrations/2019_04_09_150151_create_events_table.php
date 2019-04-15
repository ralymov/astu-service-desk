<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            $table->increments('id');
            $table->string('name');
            $table->date('date');
            $table->unsignedInteger('computers_number');
            $table->jsonb('computers')->nullable();
            $table->timestamps();
        });

        Schema::create('processors', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->unsignedInteger('processors_number');
            $table->unsignedInteger('frequency');
            $table->timestamps();
        });
        Schema::create('ram', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->unsignedInteger('generation');
            $table->unsignedInteger('frequency');
            $table->unsignedInteger('memory_size');
            $table->timestamps();
        });

        Schema::create('programs', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->timestamps();
        });


//        Schema::create('computer_components', function (Blueprint $table) {
//            $table->increments('id');
//            $table->string('name');
//            $table->timestamps();
//        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('events');
        Schema::dropIfExists('processors');
        Schema::dropIfExists('ram');
        Schema::dropIfExists('programs');


//        Schema::dropIfExists('computer_components');
    }
}
