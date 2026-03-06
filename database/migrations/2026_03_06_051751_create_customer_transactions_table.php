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
        Schema::create('customer_transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->constrained()->onDelete('cascade');
            $table->foreignId('maintenance_id')->nullable()->constrained()->onDelete('set null');
            $table->enum('type', ['debt', 'payment']);
            $table->decimal('amount', 10, 2);
            $table->enum('payment_method', ['nakit', 'kart', 'borc'])->nullable();
            $table->string('description')->nullable();
            $table->datetime('date');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customer_transactions');
    }
};
