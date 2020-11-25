<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAchievementTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->tinyInteger('school_id', 1);
            $table->string('first_name');
            $table->string('last_name');
            $table->string('full_name');
            $table->integer('age');
            $table->timestamps();
        });
        {
            Schema::create('achievements', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('user_id')->unique();
                $table->foreign('user_id')
                ->references('id')
                    ->on('users');
                $table->date('insert_date');
                $table->string('presence_absence')->nullable();
                $table->date('start_time');
                $table->date('end_time')->nullable();
                $table->string('visit_support')->nullable();
                $table->tinyInteger('food', 1)->default(0);
                $table->tinyInteger('outside_support', 1)->default(0);
                $table->tinyInteger('medical__support')->default(0);
                $table->string('note')->nullable();
                $table->string('stamp')->nullable();
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
        Schema::dropIfExists('achievement');
    }
}
