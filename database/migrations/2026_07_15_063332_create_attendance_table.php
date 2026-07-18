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
       Schema::create('attendance', function (Blueprint $table) {
            $table->integer('attendance_id')->autoIncrement();
            $table->string('student_id', 15);
            $table->integer('schedule_id');
            $table->date('date');
            $table->string('status', 15);
            $table->string('leave_reason', 255)->nullable();
            $table->timestamps();

            $table->foreign('student_id')->references('student_id')->on('students')->onDelete('cascade');
            $table->foreign('schedule_id')->references('schedule_id')->on('schedules')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attendance');
    }
};
