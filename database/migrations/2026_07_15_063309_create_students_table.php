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
       Schema::create('students', function (Blueprint $table) {
            $table->string('student_id', 15)->primary();
            $table->string('first_name', 50);
            $table->string('last_name', 50);
            $table->char('gender', 1);
            $table->date('date_of_birth');
            $table->string('class_id', 10); // Foreign Key
            $table->string('parent_phone', 20)->nullable();
            $table->string('status', 20);
            $table->timestamps();

            $table->foreign('class_id')->references('class_id')->on('classes')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
