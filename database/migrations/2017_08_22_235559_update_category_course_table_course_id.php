<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class UpdateCategoryCourseTableCourseId extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::rename('category_course', 'category_course_backup');

        Schema::create('category_course', function (Blueprint $table) {
            $table->integer('category_id')->unsigned();
            $table->foreign('category_id')->references('id')->on('categories');
            $table->integer('course_id')->unsigned();
            $table->foreign('course_id')->references('id')->on('courses');
            $table->primary(['category_id', 'course_id']);
        });

        DB::table('category_course_backup')->orderBy('category_id')->orderBy('course_id')->chunk(100, function ($category_courses) {
            foreach ($category_courses as $category_course) {
                $course_post = DB::table('posts')->where('id', $category_course->course_id)->first();
                $course = DB::table('courses')->where('title', $course_post->title)->where('excerpt', $course_post->excerpt)->first();
                try {
                    DB::table('category_course')->insert([
                        'category_id' => $category_course->category_id,
                        'course_id' => $course->id,
                    ]);
                } catch (\Illuminate\Database\QueryException $e) {
                    // INSERT IGNORE
                    if (false === strpos($e->getMessage(), 'Duplicate entry')) {
                        throw $e;
                    }
                }
            }
        });

        Schema::dropIfExists('category_course_backup');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::rename('category_course', 'category_course_backup');

        Schema::create('category_course', function (Blueprint $table) {
            $table->integer('category_id')->unsigned();
            $table->foreign('category_id')->references('id')->on('categories');
            $table->integer('course_id')->unsigned();
            $table->foreign('course_id')->references('id')->on('posts');
            $table->primary(['category_id', 'course_id']);
        });

        DB::table('category_course_backup')->orderBy('category_id')->orderBy('course_id')->chunk(100, function ($category_courses) {
            foreach ($category_courses as $category_course) {
                $course = DB::table('courses')->where('id', $category_course->course_id)->first();
                $course_post = DB::table('posts')->where('type', 'course')->where('title', $course->title)->where('excerpt', $course->excerpt)->first();
                DB::table('category_course')->insert([
                    'category_id' => $category_course->category_id,
                    'course_id' => $course_post->id,
                ]);
            }
        });

        Schema::dropIfExists('category_course_backup');
    }
}
