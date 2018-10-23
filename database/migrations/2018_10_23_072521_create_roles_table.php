<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRolesTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('roles', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('display_name');
            $table->string('code')->unique();
            $table->timestamps();
        });
        Schema::table('users', function (Blueprint $table) {
            $table->smallInteger('role_id')->unsigned()->nullable();
            $table->foreign('role_id')->references('id')->on('roles')
                ->onUpdate('restrict')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('role_id');
        });
        Schema::dropIfExists('roles');
    }
}
