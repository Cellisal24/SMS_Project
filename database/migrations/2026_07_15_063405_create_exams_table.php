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
        Schema::create('exams', function (Blueprint $table) {
            $table->integer('exam_id')->autoIncrement();
            $table->string('subject_id', 10);
            $table->string('class_id', 10);
            $table->string('room_id', 10);
            $table->string('semester', 15);
            $table->date('exam_date');
            $table->time('start_time');
            $table->time('end_time');
            $table->integer('academic_year');
            $table->timestamps();

            $table->foreign('subject_id')->references('subject_id')->on('subjects')->onDelete('cascade');
            $table->foreign('class_id')->references('class_id')->on('classes')->onDelete('cascade');
            $table->foreign('room_id')->references('room_id')->on('rooms')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('exams');
    }
};
