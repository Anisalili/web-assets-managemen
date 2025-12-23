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
            // Drop the foreign key constraint on reported_by
            $table->dropForeign(['reported_by']);
        });

        Schema::table('asset_damage_reports', function (Blueprint $table) {
            // Change the column to string
            $table->string('reported_by', 100)->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('asset_damage_reports', function (Blueprint $table) {
            // Change column back to unsignedBigInteger for foreign key
            $table->unsignedBigInteger('reported_by')->nullable()->change();
        });

        Schema::table('asset_damage_reports', function (Blueprint $table) {
            // Re-add the foreign key constraint
            $table->foreign('reported_by')->references('id')->on('users')->onDelete('set null');
        });
    }
};
