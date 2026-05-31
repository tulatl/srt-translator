<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVideosTable extends Migration
{
    public function up()
    {
        Schema::create('videos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->nullable();
            $table->string('language')->nullable();
            $table->string('target_language')->nullable();
            $table->string('str_path')->nullable();
            $table->string('translated_str_path')->nullable();
            $table->float('size', 15, 2)->nullable();
            $table->string('duration')->nullable();
            $table->string('status')->nullable();
            $table->datetime('expired_at')->nullable();
            $table->string('token')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
