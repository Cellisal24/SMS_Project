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
       Schema::create('notifications', function (Blueprint $table) {
            $table->integer('notif_id')->autoIncrement();
            $table->integer('sender_user_id');
            $table->string('recipient_type', 20);
            $table->string('recipient_id', 20);
            $table->string('title', 150);
            $table->text('body');
            $table->dateTime('sent_at');
            $table->dateTime('read_at')->nullable();
            $table->timestamps();

            $table->foreign('sender_user_id')->references('user_id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};
