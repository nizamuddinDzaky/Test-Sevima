<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('t_posting', function (Blueprint $table) {
            $table->increments('id')->unsigned(false);
            $table->integer('user_id');
            $table->integer('image');
            $table->string('caption');
            $table->string('description')->nullable(true);
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('user_id')->references('id')->on('users');
        });

        Schema::create('t_posting_comment', function (Blueprint $table) {
            $table->increments('id')->unsigned(false);
            $table->integer('user_id');
            $table->integer('posting_id');
            $table->string('comment');
            $table->string('description')->nullable(true);
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('posting_id')->references('id')->on('t_posting');
        });

        Schema::create('t_posting_like', function (Blueprint $table) {
            $table->increments('id')->unsigned(false);
            $table->integer('user_id');
            $table->integer('posting_id');
            $table->string('description')->nullable(true);
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('posting_id')->references('id')->on('t_posting');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
