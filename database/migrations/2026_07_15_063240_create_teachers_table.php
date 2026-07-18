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
       Schema::create('teachers', function (Blueprint $table) {
            $table->string('teacher_id', 15)->primary(); // VARCHAR(15) PK
            $table->string('first_name', 50);
            $table->string('last_name', 50);
            $table->char('gender', 1);
            $table->string('email', 100)->unique();
            $table->string('contact_number', 20)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('teachers');
    }
};
