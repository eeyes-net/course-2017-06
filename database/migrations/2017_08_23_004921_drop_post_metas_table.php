<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DropPostMetasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('post_metas');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::create('post_metas', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('post_id')->comment('post表的外键');
            $table->foreign('post_id')->references('id')->on('posts');
            $table->string('meta_key', 191)->index()->comment('键');
            $table->text('meta_value')->comment('值');
        });

        DB::table('courses')->orderBy('id')->chunk(100, function ($courses) {
            foreach ($courses as $course) {
                $course_post = DB::table('posts')->where('type', 'course')->where('title', $course->title)->where('excerpt', $course->excerpt)->first();
                DB::table('post_metas')->insert([
                    'post_id' => $course_post->id,
                    'meta_key' => 'credit',
                    'meta_value' => $course->credit,
                ]);
            }
        });

        DB::table('teachers')->orderBy('id')->chunk(100, function ($teachers) {
            foreach ($teachers as $teacher) {
                $teacher_post = DB::table('posts')->where('type', 'teacher')->where('title', $teacher->title)->where('excerpt', $teacher->excerpt)->where('content', $teacher->content)->first();
                DB::table('post_metas')->insert([
                    'post_id' => $teacher_post->id,
                    'meta_key' => 'department',
                    'meta_value' => $teacher->department,
                ]);
                DB::table('post_metas')->insert([
                    'post_id' => $teacher_post->id,
                    'meta_key' => 'email',
                    'meta_value' => $teacher->email,
                ]);
            }
        });
    }
}
