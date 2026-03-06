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
        Schema::table('maintenances', function (Blueprint $table) {
            $table->string('status')->default('bekliyor')->after('total_cost');
        });

        Schema::table('maintenance_parts', function (Blueprint $table) {
            $table->boolean('is_completed')->default(false)->after('note');
            $table->foreignId('completed_by')->nullable()->constrained('accounts')->nullOnDelete()->after('is_completed');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('maintenances', function (Blueprint $table) {
            //
        });
    }
};
