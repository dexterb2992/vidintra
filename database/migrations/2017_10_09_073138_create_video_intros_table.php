<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVideoIntrosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('video_intros', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('user_id')->unsigned()->index();
            $table->foreign('user_id')->references('id')->on('users');

            $table->text('slug')->nullable();

            // Video Options
            $table->string('video_source')->nullable();
            $table->string('youtube_id')->nullable();
            $table->string('m4v')->nullable();
            $table->string('ogv')->nullable();
            $table->integer('video_size_width')->default(1280);
            $table->integer('video_size_height')->default(720);
            $table->string('video_fit')->default('fill');
            $table->string('volume')->default(80); // 0-100
            $table->string('action_after_end')->default('redirect'); // or loop

            // Redirect Options
            $table->text('url_to_rewrite')->nullable();
            $table->text('url_to_redirect')->nullable();

            // Logo Options
            $table->string('logo_img')->nullable();

            // Skip Intro Button Options
            $table->boolean('skipintro_is_enabled')->default(0);
            $table->string('skipintro_text')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('video_intros');
    }
}
