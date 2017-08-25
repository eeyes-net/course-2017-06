<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCourseDownloadTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('course_download', function (Blueprint $table) {
            $table->integer('course_id')->unsigned();
            $table->foreign('course_id')->references('id')->on('posts');
            $table->integer('download_id')->unsigned();
            $table->foreign('download_id')->references('id')->on('downloads');
            $table->primary(['course_id', 'download_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('course_download');
    }
}
