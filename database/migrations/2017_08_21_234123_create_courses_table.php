<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateCoursesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('courses', function (Blueprint $table) {
            $table->increments('id');

            $table->text('title')->comment('名称');
            $table->text('excerpt')->comment('简介');
            $table->longText('content')->comment('内容');
            $table->integer('visit_count')->default('0')->comment('访问次数');
            $table->timestamps();

            $table->text('code')->comment('课程代码');
            $table->text('hours')->comment('学时');
            $table->text('credit')->comment('学分');
            $table->text('hours_per_week')->comment('周学时');
            $table->text('teaching_model')->comment('教学模式');
            $table->text('assessment_method')->comment('考核方式');
            $table->text('feature')->comment('特色');
        });

        DB::table('posts')->where('type', 'course')->orderBy('id')->chunk(100, function ($posts) {
            foreach ($posts as $post) {
                $course = [
                    'title' => $post->title,
                    'excerpt' => $post->excerpt,
                    'content' => '',
                    'visit_count' => $post->visit_count,
                    'created_at' => $post->created_at,
                    'updated_at' => $post->updated_at,
                    'code' => '',
                    'hours' => '',
                    'hours_per_week' => '',
                    'credit' => '',
                    'teaching_model' => '',
                    'assessment_method' => '',
                    'feature' => '',
                ];
                if (1 === preg_match('/课程代码：(.*?)\s*学时：(.*?)\s*学分：(.*?)\s*周学时：(.*?)/u', $post->content, $matches)) {
                    $course['code'] = $matches[1];
                    $course['hours'] = $matches[2];
                    $course['hours_per_week'] = $matches[3];
                    $course['credit'] = $matches[4];
                }
                DB::table('courses')->insert($course);
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
        Schema::dropIfExists('courses');
    }
}
