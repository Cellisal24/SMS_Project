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
       Schema::create('schedules', function (Blueprint $table) {
            $table->integer('schedule_id')->autoIncrement();
            $table->string('class_id', 10);
            $table->string('subject_id', 10);
            $table->string('teacher_id', 15);
            $table->string('day_of_week', 15);
            $table->time('start_time');
            $table->time('end_time');
            $table->timestamps();

            $table->foreign('class_id')->references('class_id')->on('classes')->onDelete('cascade');
            $table->foreign('subject_id')->references('subject_id')->on('subjects')->onDelete('cascade');
            $table->foreign('teacher_id')->references('teacher_id')->on('teachers')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('schedules');
    }
};
