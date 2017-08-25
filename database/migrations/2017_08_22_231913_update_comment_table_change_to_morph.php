<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class UpdateCommentTableChangeToMorph extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('comments', function (Blueprint $table) {
            $table->integer('commentable_id')->unsigned()->nullable();
            $table->string('commentable_type', 50)->default('');
            $table->index(['commentable_id', 'commentable_type']);
        });

        DB::table('comments')->orderBy('id')->chunk(100, function ($comments) {
            foreach ($comments as $comment) {
                $post = DB::table('posts')->where('id', $comment->post_id)->first();
                switch ($post->type) {
                    case 'course':
                        $course = DB::table('courses')->where('title', $post->title)->where('excerpt', $post->excerpt)->first();
                        $commentable_id = $course->id;
                        $commentable_type = 'App\Course';
                        break;
                    case 'teacher':
                        $teacher = DB::table('teachers')->where('title', $post->title)->where('excerpt', $post->excerpt)->where('content', $post->content)->first();
                        $commentable_id = $teacher->id;
                        $commentable_type = 'App\Teacher';
                        break;
                }
                DB::table('comments')->where('id', $comment->id)->update([
                    'commentable_id' => $commentable_id,
                    'commentable_type' => $commentable_type,
                ]);
            }
        });

        Schema::table('comments', function (Blueprint $table) {
            $table->dropColumn('post_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('comments', function (Blueprint $table) {
            $table->integer('post_id')->unsigned()->comment('post表的外键');
            $table->foreign('post_id')->references('id')->on('posts');
        });

        DB::table('comments')->orderBy('id')->chunk(100, function ($comments) {
            foreach ($comments as $comment) {
                switch ($comment->commentable_type) {
                    case 'App\Course':
                        $course = DB::table('courses')->where('id', $comment->commentable_id)->first();
                        $post = DB::table('posts')->where('type', 'course')->where('title', $course->title)->where('excerpt', $course->excerpt)->first();
                        break;
                    case 'App\Teacher':
                        $teacher = DB::table('teachers')->where('id', $comment->commentable_id)->first();
                        $post = DB::table('posts')->where('type', 'teacher')->where('title', $teacher->title)->where('excerpt', $teacher->excerpt)->where('content', $teacher->content)->first();
                        break;
                }
                DB::table('comments')->where('id', $comment->id)->update([
                    'post_id' => $post->id,
                ]);
            }
        });

        Schema::table('comments', function (Blueprint $table) {
            $table->dropColumn('commentable_id');
            $table->dropColumn('commentable_type');
        });
    }
}
