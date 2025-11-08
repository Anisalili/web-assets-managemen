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
        Schema::table('maintenance_schedules', function (Blueprint $table) {
            // Drop old column
            $table->dropColumn('assigned_to');
        });

        Schema::table('maintenance_schedules', function (Blueprint $table) {
            // Add new foreign key column
            $table->foreignId('assigned_to')->nullable()->after('description')->constrained('users')->onDelete('set null');

            // Add next_maintenance_date for recurring schedules
            $table->date('next_maintenance_date')->nullable()->after('scheduled_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('maintenance_schedules', function (Blueprint $table) {
            $table->dropForeign(['assigned_to']);
            $table->dropColumn(['assigned_to', 'next_maintenance_date']);
        });

        Schema::table('maintenance_schedules', function (Blueprint $table) {
            $table->string('assigned_to', 100)->nullable();
        });
    }
};
