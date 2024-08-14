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
        Schema::create('pits', function (Blueprint $table) {
            $table->id();

            $table->string('titolo')->nullable(false);
            $table->string('immagine')->nullable(false);
            $table->text('Descrizione');
            $table->string('Note');
            $table->boolean('Visitato');

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
        Schema::dropIfExists('pits');
    }
};
