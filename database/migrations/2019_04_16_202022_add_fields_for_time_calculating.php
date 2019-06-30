<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldsForTimeCalculating extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('programs', function (Blueprint $table) {
            $table->decimal('processor_number_factor')->nullable();
            $table->decimal('processor_number_offset')->nullable()->default(0);
            $table->decimal('processor_frequency_factor')->nullable();
            $table->decimal('processor_frequency_offset')->nullable()->default(0);
            $table->decimal('processor_weight')->nullable()->default(1);

            $table->decimal('ram_generation_factor')->nullable();
            $table->decimal('ram_frequency_factor')->nullable();
            $table->decimal('ram_memory_size_factor')->nullable();
            $table->decimal('ram_generation_offset')->nullable()->default(0);
            $table->decimal('ram_frequency_offset')->nullable()->default(0);
            $table->decimal('ram_memory_size_offset')->nullable()->default(0);
            $table->decimal('ram_weight')->nullable()->default(1);
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
            $table->dropColumn('processor_number_factor');
            $table->dropColumn('processor_number_offset');
            $table->dropColumn('processor_frequency_factor');
            $table->dropColumn('processor_frequency_offset');
            $table->dropColumn('processor_weight');
            $table->dropColumn('ram_generation_factor');
            $table->dropColumn('ram_frequency_factor');
            $table->dropColumn('ram_memory_size_factor');
            $table->dropColumn('ram_generation_offset');
            $table->dropColumn('ram_frequency_offset');
            $table->dropColumn('ram_memory_size_offset');
            $table->dropColumn('ram_weight');
        });
    }
}
