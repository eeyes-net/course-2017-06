<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateTeachersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('teachers', function (Blueprint $table) {
            $table->increments('id');

            $table->text('title')->comment('名称');
            $table->text('excerpt')->comment('简介');
            $table->longText('content')->comment('内容');
            $table->integer('visit_count')->default('0')->comment('访问次数');
            $table->timestamps();

            $table->text('avatar')->comment('教师头像相对路径');
            $table->text('email')->comment('教师邮箱');
            $table->text('department')->comment('教师的学院或部门');
        });

        DB::table('posts')->where('type', 'teacher')->orderBy('id')->chunk(100, function ($posts) {
            foreach ($posts as $post) {
                $teacher = [
                    'title' => $post->title,
                    'excerpt' => $post->excerpt,
                    'content' => $post->content,
                    'visit_count' => $post->visit_count,
                    'created_at' => $post->created_at,
                    'updated_at' => $post->updated_at,
                    'avatar' => '',
                    'email' => '',
                    'department' => '',
                ];
                $post_metas = DB::table('post_metas')->where('post_id', $post->id)->get();
                foreach ($post_metas as $post_meta) {
                    switch ($post_meta->meta_key) {
                        case 'email':
                            $teacher['email'] = $post_meta->meta_value;
                            break;
                        case 'department':
                            $teacher['department'] = $post_meta->meta_value;
                            break;
                    }
                }
                DB::table('teachers')->insert($teacher);
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
        Schema::dropIfExists('teachers');
    }
}
