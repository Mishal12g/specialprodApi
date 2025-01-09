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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->dateTime('date', 6)->default(DB::raw('CURRENT_TIMESTAMP(6)'));
            $table->foreignId('customer_id')->constrained('users')->onDelete('cascade'); 
            $table->foreignId('executor_id')->constrained('users')->onDelete('cascade'); 
            $table->foreignId('transport_id')->constrained();
            $table->string('location');
            $table->timestamp('start_of_work');
            $table->string('status');
            $table->string('description')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
