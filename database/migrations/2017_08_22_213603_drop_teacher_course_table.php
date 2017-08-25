<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class DropTeacherCourseTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('teacher_course');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::create('teacher_course', function (Blueprint $table) {
            $table->integer('teacher_id')->unsigned();
            $table->foreign('teacher_id')->references('id')->on('posts');
            $table->integer('course_id')->unsigned();
            $table->foreign('course_id')->references('id')->on('posts');
            $table->primary(['teacher_id', 'course_id']);
        });

        DB::table('course_teacher')->orderBy('course_id')->orderBy('teacher_id')->chunk(100, function ($course_teachers) {
            foreach ($course_teachers as $course_teacher) {
                $course = DB::table('courses')->where('id', $course_teacher->course_id)->first();
                $teacher = DB::table('teachers')->where('id', $course_teacher->teacher_id)->first();
                $course_post = DB::table('posts')->where('type', 'course')->where('title', $course->title)->where('excerpt', $course->excerpt)->first();
                $teacher_post = DB::table('posts')->where('type', 'teacher')->where('title', $teacher->title)->where('excerpt', $teacher->excerpt)->where('content', $teacher->content)->first();
                DB::table('teacher_course')->insert([
                    'course_id' => $course->id,
                    'teacher_id' => $teacher->id,
                ]);
            }
        });
    }
}
