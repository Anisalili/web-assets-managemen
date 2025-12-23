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
        Schema::table('asset_damage_reports', function (Blueprint $table) {
            // Drop foreign key constraints first (MySQL requirement)
            $table->dropForeign(['reported_by']);
            $table->dropForeign(['resolved_by']);
        });

        Schema::table('asset_damage_reports', function (Blueprint $table) {
            // Now change column types
            $table->string('reported_by', 100)->nullable()->change();
            $table->string('resolved_by', 100)->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('asset_damage_reports', function (Blueprint $table) {
            // Change back to unsignedBigInteger
            $table->unsignedBigInteger('reported_by')->nullable()->change();
            $table->unsignedBigInteger('resolved_by')->nullable()->change();
        });

        Schema::table('asset_damage_reports', function (Blueprint $table) {
            // Add foreign key constraints back
            $table->foreign('reported_by')->references('id')->on('users')->onDelete('set null');
            $table->foreign('resolved_by')->references('id')->on('users')->onDelete('set null');
        });
    }
};
