<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('logs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('nomor_antrian');
            $table->string('nama');
            $table->string('msisdn_1');
            $table->string('msisdn_2')->nullable();
            $table->string('msisdn_3')->nullable();
            $table->string('keluhan')->nullable();
            $table->time('issued')->default('00:00:00')->nullable('true');
            $table->time('dipanggil')->default('00:00:00')->nullable('true');
            $table->time('selesai')->default('00:00:00')->nullable('true');
            $table->string('navigator')->nullable('true');
            $table->string('ambassador')->nullable('true');
            $table->string('keterangan')->nullable('true');
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
        Schema::dropIfExists('logs');
    }
}
