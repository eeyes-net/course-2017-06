<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateCourseTeacherTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('course_teacher', function (Blueprint $table) {
            $table->integer('course_id')->unsigned();
            $table->foreign('course_id')->references('id')->on('courses');
            $table->integer('teacher_id')->unsigned();
            $table->foreign('teacher_id')->references('id')->on('teachers');
            $table->primary(['teacher_id', 'course_id']);
        });

        DB::table('teacher_course')->orderBy('teacher_id')->orderBy('course_id')->chunk(100, function ($teacher_courses) {
            foreach ($teacher_courses as $teacher_course) {
                try {
                    $course_post = DB::table('posts')->where('id', $teacher_course->course_id)->first();
                    $teacher_post = DB::table('posts')->where('id', $teacher_course->teacher_id)->first();
                    $course = DB::table('courses')->where('title', $course_post->title)->where('excerpt', $course_post->excerpt)->first();
                    $teacher = DB::table('teachers')->where('title', $teacher_post->title)->where('excerpt', $teacher_post->excerpt)->where('content', $teacher_post->content)->first();
                    $count = DB::table('course_teacher')->where('course_id', $course->id)->where('teacher_id', $teacher->id)->count();
                    if (!$count) {
                        DB::table('course_teacher')->insert([
                            'course_id' => $course->id,
                            'teacher_id' => $teacher->id,
                        ]);
                    }
                } catch (\Illuminate\Database\QueryException $e) {
                    echo $e->getMessage(), PHP_EOL;
                }
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('course_teacher');
    }
}
