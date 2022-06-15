<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user', function (Blueprint $table) {
            $table->id();
            $table->string('name', 50);
            $table->string('mother_name',50);
            $table->string('father_name',50);
            $table->string('email', 50)->unique();
            $table->string('password', 100);
            $table->string('file_path',100);
            $table->string('gender', 1);
            $table->boolean('is_admin', 1);
            $table->date('dob');
            $table->integer('age');
            $table->string('hobby',50);
            $table->string('address', 100);
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
        Schema::dropIfExists('user');
    }
}
