<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOccurrences extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('occurrences', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();
            $table->string('category', 25);
            $table->string('word', 50);
            $table->unsignedInteger('count')->default(0);

            $table->unique(['category', 'word']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('occurrences');
    }
}
