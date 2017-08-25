<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateCourseDownloadTableCourseId extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::rename('course_download', 'course_download_backup');

        Schema::create('course_download', function (Blueprint $table) {
            $table->integer('course_id')->unsigned();
            $table->foreign('course_id')->references('id')->on('courses');
            $table->integer('download_id')->unsigned();
            $table->foreign('download_id')->references('id')->on('downloads');
            $table->primary(['course_id', 'download_id']);
        });

        DB::table('course_download_backup')->orderBy('course_id')->orderBy('download_id')->chunk(100, function ($course_downloads) {
            foreach ($course_downloads as $course_download) {
                $course_post = DB::table('posts')->where('id', $course_download->course_id)->first();
                $course = DB::table('courses')->where('title', $course_post->title)->where('excerpt', $course_post->excerpt)->first();
                try {
                    DB::table('course_download')->insert([
                        'course_id' => $course->id,
                        'download_id' => $course_download->download_id,
                    ]);
                } catch (\Illuminate\Database\QueryException $e) {
                    // INSERT IGNORE
                    if (false === strpos($e->getMessage(), 'Duplicate entry')) {
                        throw $e;
                    }
                }
            }
        });

        Schema::dropIfExists('course_download_backup');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::rename('course_download', 'course_download_backup');

        Schema::create('course_download', function (Blueprint $table) {
            $table->integer('course_id')->unsigned();
            $table->foreign('course_id')->references('id')->on('categories');
            $table->integer('download_id')->unsigned();
            $table->foreign('download_id')->references('id')->on('posts');
            $table->primary(['course_id', 'download_id']);
        });

        DB::table('course_download_backup')->orderBy('course_id')->orderBy('download_id')->chunk(100, function ($course_downloads) {
            foreach ($course_downloads as $course_download) {
                $course = DB::table('courses')->where('id', $course_download->course_id)->first();
                $course_post = DB::table('posts')->where('type', 'course')->where('title', $course->title)->where('excerpt', $course->excerpt)->first();
                DB::table('course_download')->insert([
                    'course_id' => $course_post->id,
                    'download_id' => $course_download->download_id,
                ]);
            }
        });

        Schema::dropIfExists('course_download_backup');
    }
}
