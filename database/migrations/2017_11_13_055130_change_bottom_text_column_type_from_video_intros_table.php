<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeBottomTextColumnTypeFromVideoIntrosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('video_intros', function (Blueprint $table) {
            $table->text('bottom_text_left')->nullable()->change();
            $table->text('bottom_text_right')->nullable()->change();
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
            $table->string('bottom_text_left')->nullable()->change();
            $table->string('bottom_text_right')->nullable()->change();
        });
    }
}
