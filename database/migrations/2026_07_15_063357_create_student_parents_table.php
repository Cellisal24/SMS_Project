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
       Schema::create('student_parents', function (Blueprint $table) {
            $table->integer('id')->autoIncrement();
            $table->string('student_id', 15);
            $table->string('parent_id', 15);
            $table->string('relationship', 30);
            $table->boolean('is_primary');
            $table->timestamps();

            $table->foreign('student_id')->references('student_id')->on('students')->onDelete('cascade');
            $table->foreign('parent_id')->references('parent_id')->on('parents')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student_parents');
    }
};
