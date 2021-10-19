<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();
            $table->string('email', 128);
            $table->string('password', 256);
        });

        \Illuminate\Support\Facades\DB::table('users')->insert(
            [
                [
                    'created_at' => date("Y-m-d"),
                    'updated_at' => date("Y-m-d"),
                    'email' => 'liam@tebex.co.uk',
                    'password' => password_hash('testtest123', PASSWORD_DEFAULT)
                ],
                [
                    'created_at' => date("Y-m-d"),
                    'updated_at' => date("Y-m-d"),
                    'email' => 'liam@w.iltshi.re',
                    'password' => password_hash('testtest123', PASSWORD_DEFAULT)
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
        Schema::dropIfExists('users');
    }
}
