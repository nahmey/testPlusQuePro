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
        Schema::create('films', function (Blueprint $table) {
            $table->id();
            
            $table->string('title', 250)->nullable();
            $table->string('backdrop_path', 250)->nullable();
            $table->string('original_language', 250)->nullable();
            $table->string('original_title', 250)->nullable();
            $table->text('overview')->nullable();
            $table->string('poster_path', 250)->nullable();
            $table->string('media_type', 250)->nullable();

            $table->date('release_date')->nullable();

            $table->boolean('video')->default(false);
            $table->boolean('adult')->default(false);

            $table->string('popularity', 250)->nullable();
            $table->string('vote_average', 250)->nullable();
            $table->integer('vote_count')->nullable();

            $table->string('budget', 250)->nullable();
            $table->string('imdb_id', 250)->nullable();
            $table->string('revenue', 250)->nullable();
            $table->string('runtime', 250)->nullable();
            $table->string('status', 250)->nullable();
            $table->string('tagline', 250)->nullable();
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
        Schema::dropIfExists('films');
    }
};
