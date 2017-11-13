<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFrameOptionsToVideoIntrosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('video_intros', function (Blueprint $table) {
            $table->double('frame_border_width')->default(40);
            $table->double('frame_border_radius')->default(2);
            $table->string('frame_border_bg_color')->default("#fff");
            $table->string('frame_border_bg_image')->default('')->nullable();
            $table->string('frame_border_bg_position')->default('')->nullable();
            $table->string('frame_border_bg_repeat')->default('')->nullable();
            $table->string('frame_border_bg_size')->default('')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('video_intros', function (Blueprint $table) {
            $table->dropColumn('frame_border_width');
            $table->dropColumn('frame_border_radius');
            $table->dropColumn('frame_border_bg_color');
            $table->dropColumn('frame_border_bg_image');
            $table->dropColumn('frame_border_bg_position');
            $table->dropColumn('frame_border_bg_repeat');
            $table->dropColumn('frame_border_bg_size');
        });
    }
}
