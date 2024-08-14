<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('day_pit', function (Blueprint $table) {
            $table->foreignId('day_id')->constrained();
            $table->foreignId('pit_id')->constrained();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('day_pit', function (Blueprint $table) {
            $table->dropForeign(['day_id']);
            $table->dropColumn(['day_id']);
            $table->dropForeign(['pit_id']);
            $table->dropColumn(['pit_id']);
        });
    }
};
