<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMarksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('marks', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('course_id');
            $table->unsignedInteger('student_id');
            $table->unsignedInteger('semester_id');
            $table->unsignedInteger('subject_id');
            $table->unsignedTinyInteger('marks');
            $table->timestamps();

            $table->foreign('course_id')->references('id')->on('courses')->onDelete('CASCADE');
            $table->foreign('student_id')->references('id')->on('users')->onDelete('CASCADE');
            $table->foreign('semester_id')->references('id')->on('semesters')->onDelete('CASCADE');
            $table->foreign('subject_id')->references('id')->on('subjects')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('marks');
    }
}
