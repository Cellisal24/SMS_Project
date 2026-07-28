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
        Schema::create('reports', function (Blueprint $table) {
            $table->integer('report_id')->autoIncrement();
            $table->string('student_id', 15);
            $table->string('class_id', 10);
            $table->string('semester', 15);
            $table->integer('academic_year');
            $table->decimal('total_score', 5, 2)->nullable();
            $table->decimal('average_score', 5, 2)->nullable();
            $table->integer('class_rank')->nullable();
            $table->decimal('attendance_percentage', 5, 2)->nullable();
            $table->text('teacher_comments')->nullable();
            $table->string('generated_by', 15)->nullable();
            $table->dateTime('generated_at')->nullable();
            $table->string('status', 20)->default('draft');
            $table->timestamps();

            $table->foreign('student_id')->references('student_id')->on('students')->onDelete('cascade');
            $table->foreign('class_id')->references('class_id')->on('classes')->onDelete('cascade');
            $table->foreign('generated_by')->references('teacher_id')->on('teachers')->onDelete('set null');

            $table->unique(['student_id', 'semester', 'academic_year']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reports');
    }
};