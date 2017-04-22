<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSourcesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sources', function (Blueprint $table) {
            $table->increments('id');
            $table->string('source_id')->unique();
            $table->string('name')->index();
            $table->text('description')->nullable();
            $table->string('url')->nullable();
            $table->string('category')->nullable();
            $table->string('language')->nullable();
            $table->string('country')->nullable();
            $table->string('urlsToLogosSmall')->nullable();
            $table->string('urlsToLogosMedium')->nullable();
            $table->string('urlsToLogosLarge')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sources');
    }
}
