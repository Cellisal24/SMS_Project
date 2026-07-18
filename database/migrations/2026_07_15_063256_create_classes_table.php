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
        Schema::create('classes', function (Blueprint $table) {
            $table->string('class_id', 10)->primary();
            $table->string('class_name', 30);
            $table->integer('level_id'); // Foreign Key
            $table->string('room_number', 15)->nullable();
            $table->integer('academic_year');
            $table->timestamps();

            $table->foreign('level_id')->references('level_id')->on('grade_levels')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('classes');
    }
};
