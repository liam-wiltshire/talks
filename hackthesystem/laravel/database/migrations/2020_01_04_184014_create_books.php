<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBooks extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('books', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();
            $table->string('title', 50);
            $table->string('author', 50);
            $table->integer('era_id');
        });

        \Illuminate\Support\Facades\DB::table('books')->insert(
            [
                [
                    'title' => 'Pride and Prejudice',
                    'author' => 'Jane Austen',
                    'era_id' => 1,
                ],
                [
                    'title' => 'Lord of the Flies',
                    'author' => 'William Golding',
                    'era_id' => 2,
                ],
            ]
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('books');
    }
}
