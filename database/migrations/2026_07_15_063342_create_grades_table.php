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
       Schema::create('grades', function (Blueprint $table) {
            $table->integer('grade_id')->autoIncrement();
            $table->string('student_id', 15);
            $table->string('subject_id', 10);
            $table->string('semester', 15);
            $table->decimal('midterm_score', 5, 2)->nullable();
            $table->decimal('final_score', 5, 2)->nullable();
            $table->timestamps();

            $table->foreign('student_id')->references('student_id')->on('students')->onDelete('cascade');
            $table->foreign('subject_id')->references('subject_id')->on('subjects')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('grades');
    }
};
