<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class EditDefaultValueForWeights extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('programs', function (Blueprint $table) {
            $table->decimal('processor_weight')->nullable()->default(0.5)->change();
            $table->decimal('ram_weight')->nullable()->default(0.5)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('programs', function (Blueprint $table) {
            $table->decimal('processor_weight')->nullable()->default(1)->change();
            $table->decimal('ram_weight')->nullable()->default(1)->change();
        });
    }
}
