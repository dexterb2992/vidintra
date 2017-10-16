<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddBottomTextFieldsToVideoIntrosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('video_intros', function (Blueprint $table) {
            $table->string('bottom_text_left')->after('url_to_redirect')->nullable();
            $table->string('bottom_text_right')->after('bottom_text_left')->nullable();
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
            $table->dropColumn('bottom_text_left');
            $table->dropColumn('bottom_text_right');
        });
    }
}
