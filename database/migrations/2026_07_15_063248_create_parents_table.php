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
       Schema::create('parents', function (Blueprint $table) {
            $table->string('parent_id', 15)->primary(); // VARCHAR(15) PK
            $table->string('first_name', 50);
            $table->string('last_name', 50);
            $table->string('phone', 20);
            $table->string('email', 100)->nullable();
            $table->string('national_id', 30)->unique();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('parents');
    }
};
