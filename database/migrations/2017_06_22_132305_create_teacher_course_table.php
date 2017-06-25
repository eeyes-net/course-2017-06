<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTeacherCourseTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('teacher_course', function (Blueprint $table) {
            $table->integer('teacher_id')->comment('教师post表的外键');
            $table->foreign('teacher_id')->references('id')->on('posts');
            $table->integer('course_id')->comment('课程post表的外键');
            $table->foreign('course_id')->references('id')->on('posts');
            $table->primary(['teacher_id', 'course_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('teacher_course');
    }
}
