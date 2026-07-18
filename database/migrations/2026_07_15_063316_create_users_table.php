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
        Schema::create('users', function (Blueprint $table) {
            $table->integer('user_id')->autoIncrement();
            $table->string('username', 50)->unique();
            $table->string('password_hash', 255);
            $table->string('role', 20);
            $table->string('student_id', 15)->nullable(); // Foreign Key
            $table->string('teacher_id', 15)->nullable(); // Foreign Key
            $table->timestamps();

            $table->foreign('student_id')->references('student_id')->on('students')->onDelete('set null');
            $table->foreign('teacher_id')->references('teacher_id')->on('teachers')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
