<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // SQLite requires recreating the table to remove foreign key
        DB::statement('PRAGMA foreign_keys = OFF');

        // Create temporary table without reported_by foreign key
        Schema::create('asset_damage_reports_temp', function (Blueprint $table) {
            $table->id();
            $table->foreignId('asset_id')->constrained('assets')->onDelete('cascade');
            $table->string('reported_by', 100)->nullable(); // String, not foreign key
            $table->foreignId('assigned_to')->nullable()->constrained('users')->onDelete('set null');
            $table->datetime('report_date');
            $table->string('severity', 20);
            $table->string('damage_type', 50)->nullable();
            $table->string('priority', 20)->default('medium');
            $table->text('description');
            $table->text('impact_on_operations')->nullable();
            $table->string('image_path')->nullable();
            $table->decimal('estimated_repair_cost', 15, 2)->nullable();
            $table->string('status', 20);
            $table->datetime('resolved_date')->nullable();
            $table->foreignId('resolved_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();
        });

        // Copy data
        DB::statement('INSERT INTO asset_damage_reports_temp SELECT * FROM asset_damage_reports');

        // Drop old table
        Schema::dropIfExists('asset_damage_reports');

        // Rename temp table
        Schema::rename('asset_damage_reports_temp', 'asset_damage_reports');

        DB::statement('PRAGMA foreign_keys = ON');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Recreate with foreign key on reported_by
        DB::statement('PRAGMA foreign_keys = OFF');

        Schema::create('asset_damage_reports_temp', function (Blueprint $table) {
            $table->id();
            $table->foreignId('asset_id')->constrained('assets')->onDelete('cascade');
            $table->foreignId('reported_by')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('assigned_to')->nullable()->constrained('users')->onDelete('set null');
            $table->datetime('report_date');
            $table->string('severity', 20);
            $table->string('damage_type', 50)->nullable();
            $table->string('priority', 20)->default('medium');
            $table->text('description');
            $table->text('impact_on_operations')->nullable();
            $table->string('image_path')->nullable();
            $table->decimal('estimated_repair_cost', 15, 2)->nullable();
            $table->string('status', 20);
            $table->datetime('resolved_date')->nullable();
            $table->foreignId('resolved_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();
        });

        DB::statement('INSERT INTO asset_damage_reports_temp SELECT * FROM asset_damage_reports');
        Schema::dropIfExists('asset_damage_reports');
        Schema::rename('asset_damage_reports_temp', 'asset_damage_reports');

        DB::statement('PRAGMA foreign_keys = ON');
    }
};
