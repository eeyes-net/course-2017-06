<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class DropPostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('posts');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->increments('id');
            $table->string('type', 20)->comment('分类：course|teacher')->index();
            $table->text('title')->comment('名称');
            $table->text('excerpt')->comment('简介');
            $table->longText('content')->comment('内容');
            $table->integer('visit_count')->default('0')->comment('访问次数');
            $table->timestamps();
        });

        DB::table('courses')->orderBy('id')->chunk(100, function ($courses) {
            foreach ($courses as $course) {
                DB::table('posts')->insert([
                    'type' => 'course',
                    'title' => $course->title,
                    'excerpt' => $course->excerpt,
                    'content' => "课程代码：{$course->code}\r\n学时：{$course->hours}\r\n学分：{$course->credit}\r\n周学时：{$course->hours_per_week}",
                    'visit_count' => $course->visit_count,
                    'created_at' => $course->created_at,
                    'updated_at' => $course->updated_at,
                ]);
            }
        });

        DB::table('teachers')->orderBy('id')->chunk(100, function ($teachers) {
            foreach ($teachers as $teacher) {
                DB::table('posts')->insert([
                    'type' => 'teacher',
                    'title' => $teacher->title,
                    'excerpt' => $teacher->excerpt,
                    'content' => $teacher->content,
                    'visit_count' => $teacher->visit_count,
                    'created_at' => $teacher->created_at,
                    'updated_at' => $teacher->updated_at,
                ]);
            }
        });
    }
}
