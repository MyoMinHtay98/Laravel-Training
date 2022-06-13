<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('student', function (Blueprint $table) {
            $table->id();
            $table->string('student_name', 50);
            $table->string('email', 50)->unique();
            $table->string('password', 100);
            $table->string('gender', 1);
            $table->boolean('is_active');
            $table->date('dob');
            $table->integer('age');
            $table->string('address', 100);
            $table->string('file_path',100);
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
        Schema::dropIfExists('student');
    }
}
