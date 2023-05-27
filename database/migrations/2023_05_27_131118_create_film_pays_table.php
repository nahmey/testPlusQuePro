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
        Schema::create('film_pays', function (Blueprint $table) {
            $table->id();

            $table->integer('film_id')->nullable()->index();
            $table->foreign('film_id')->references('id')->on('films');

            $table->integer('pays_id')->nullable()->index();
            $table->foreign('pays_id')->references('id')->on('pays');

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
        Schema::dropIfExists('film_pays');
    }
};
