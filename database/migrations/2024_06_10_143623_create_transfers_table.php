<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('transfers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sender_id')->constrained('accounts')->onDelete('cascade');
            $table->foreignId('receiver_id')->constrained('accounts')->onDelete('cascade');
            $table->string('message', 40);
            $table->decimal('amount');
            $table->string('currency', 3);
            $table->enum('category', ['Education', 'Food', 'Hygiene', 'Transport', 'Work', 'Investments', 'Others']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transfers');
    }
};
