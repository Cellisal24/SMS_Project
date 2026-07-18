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
       Schema::create('activity_logs', function (Blueprint $table) {
            $table->integer('log_id')->autoIncrement();
            $table->integer('user_id');
            $table->string('action', 50);
            $table->string('table_name', 50);
            $table->string('record_id', 20);
            $table->json('old_value')->nullable();
            $table->json('new_value')->nullable();
            $table->dateTime('created_at'); 
            // ចំណាំ៖ អាចប្រើ $table->timestamps() ជំនួសបាន លុះត្រាតែចង់ទុកតែ created_at មួយមុខ
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('activity_logs');
    }
};
