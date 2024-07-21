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
        Schema::create('accounts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('card_number')->unique();
            $table->string('card_last_digits', 4);
            $table->string('account_number', 11)->unique();
            $table->date('expiry_date');
            $table->decimal('balance');
            $table->string('currency', 3);
            $table->enum('banking_product', ['Personal', 'Company']);
            $table->enum('card_color', ['Blue', 'Yellow', 'Green', 'Purple']);
            $table->boolean('active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('accounts');
    }
};
