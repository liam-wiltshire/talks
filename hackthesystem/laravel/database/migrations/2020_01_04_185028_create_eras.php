<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEras extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('eras', function (Blueprint $table) {
            $table->integer('id');
            $table->timestamps();
            $table->string('year');
        });

        \Illuminate\Support\Facades\DB::table('eras')->insert(
            [
                [
                    'id' => 1,
                    'year' => 1900,
                ],
                [
                    'id' => 1,
                    'year' => 1810,
                ],
                [
                    'id' => 2,
                    'year' => 1810,
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
        Schema::dropIfExists('eras');
    }
}
