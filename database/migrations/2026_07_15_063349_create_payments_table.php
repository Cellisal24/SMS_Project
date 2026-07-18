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
       Schema::create('payments', function (Blueprint $table) {
            $table->string('invoice_id', 20)->primary();
            $table->string('student_id', 15);
            $table->string('description', 100);
            $table->decimal('total_fee', 10, 2);
            $table->decimal('discount', 10, 2)->default(0.00);
            $table->decimal('amount_paid', 10, 2);
            $table->date('payment_date');
            $table->timestamps();

            $table->foreign('student_id')->references('student_id')->on('students')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
