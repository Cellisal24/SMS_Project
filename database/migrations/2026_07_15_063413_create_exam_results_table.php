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
       Schema::create('exam_results', function (Blueprint $table) {
            $table->integer('result_id')->autoIncrement();
            $table->integer('exam_id');
            $table->string('student_id', 15);
            $table->decimal('score', 5, 2);
            $table->decimal('max_score', 5, 2);
            $table->string('remarks', 255)->nullable();
            $table->timestamps();

            $table->foreign('exam_id')->references('exam_id')->on('exams')->onDelete('cascade');
            $table->foreign('student_id')->references('student_id')->on('students')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('exam_results');
    }
};
