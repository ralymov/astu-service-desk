<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTicketsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('positions', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->unique();
            $table->timestamps();
        });
        Schema::create('locations', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('code')->unique();
            $table->timestamps();
        });
        Schema::create('departments', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->unique();
            $table->unsignedInteger('location_id')->nullable();
            $table->foreign('location_id')->references('id')->on('locations');
            $table->timestamps();
        });
        Schema::create('department_positions', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('department_id');
            $table->foreign('department_id')->references('id')->on('departments');
            $table->unsignedInteger('position_id');
            $table->foreign('position_id')->references('id')->on('positions');
            $table->timestamps();
        });
        Schema::create('employee_types', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('code')->unique();
            $table->timestamps();
        });
        Schema::create('employees', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->unsignedInteger('position_id')->nullable();
            $table->foreign('position_id')->references('id')->on('positions');
            $table->unsignedInteger('department_id')->nullable();
            $table->foreign('department_id')->references('id')->on('departments');
            $table->unsignedInteger('type_id')->nullable();
            $table->foreign('type_id')->references('id')->on('employee_types');
            $table->timestamps();
        });
        Schema::table('users', function (Blueprint $table) {
            $table->unsignedInteger('employee_id')->nullable();
            $table->foreign('employee_id')->references('id')->on('employees');
        });
        Schema::create('ticket_types', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->unique();
            $table->timestamps();
        });
        Schema::create('ticket_priorities', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('code')->unique();
            $table->timestamps();
        });
        Schema::create('ticket_statuses', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->unique();
            $table->string('rgb', 7)->unique()->nullable();
            $table->timestamps();
        });
        Schema::create('tickets', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->text('description');

            $table->string('applicant_name')->nullable();
            $table->unsignedInteger('applicant_location_id')->nullable();
            $table->foreign('applicant_location_id')->references('id')->on('locations');
            $table->unsignedInteger('applicant_id')->nullable();
            $table->foreign('applicant_id')->references('id')->on('employees');

            $table->unsignedInteger('employee_id')->nullable();
            $table->foreign('employee_id')->references('id')->on('employees');

            $table->unsignedInteger('type_id');
            $table->foreign('type_id')->references('id')->on('ticket_types');

            $table->unsignedInteger('priority_id')->nullable();
            $table->foreign('priority_id')->references('id')->on('ticket_priorities');

            $table->unsignedInteger('status_id')->nullable();
            $table->foreign('status_id')->references('id')->on('ticket_statuses');

            $table->dateTime('closed_at')->nullable();
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
        Schema::dropIfExists('tickets');
        Schema::dropIfExists('ticket_statuses');
        Schema::dropIfExists('ticket_priorities');
        Schema::dropIfExists('ticket_types');
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('employee_id');
        });
        Schema::dropIfExists('employees');
        Schema::dropIfExists('employee_types');
        Schema::dropIfExists('department_positions');
        Schema::dropIfExists('departments');
        Schema::dropIfExists('locations');
        Schema::dropIfExists('positions');
    }
}
