<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RefactorUsersDepartments extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_departments', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->unique();
            $table->unsignedInteger('location_id')->nullable();
            $table->foreign('location_id')->references('id')->on('locations');
            $table->timestamps();
        });
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('department_id');
        });
        Schema::table('users', function (Blueprint $table) {
            $table->unsignedInteger('department_id')->nullable();
            $table->foreign('department_id')->references('id')->on('user_departments');
            $table->string('email')->nullable()->unique();
        });
        Schema::table('tickets', function (Blueprint $table) {
            $table->unsignedInteger('department_id')->nullable();
            $table->foreign('department_id')->references('id')->on('user_departments');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tickets', function (Blueprint $table) {
            $table->dropColumn('department_id');
        });
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('department_id');
            $table->dropColumn('email');
        });
        Schema::table('users', function (Blueprint $table) {
            $table->unsignedInteger('department_id')->nullable();
            $table->foreign('department_id')->references('id')->on('departments');
        });
        Schema::dropIfExists('user_departments');
    }
}
