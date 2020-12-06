<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePagespeedDesktopAuditsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('page_speed_desktop_audits', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->integer('audits_id');
            $table->integer('measurements_id');
            $table->string('value');
            // $table->foreign('measurements_id')->references('id')->on('measurements');
            // $table->foreign('audits_id')->references('id')->on('audits');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('page_speed_desktop_audits');
    }
}
