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
        Schema::table("asset_damage_reports", function (Blueprint $table) {
            // Drop old varchar columns
            $table->dropColumn(["reported_by", "resolved_by"]);
        });

        Schema::table("asset_damage_reports", function (Blueprint $table) {
            // Add new foreign key columns
            $table
                ->foreignId("reported_by")
                ->after("asset_id")
                ->constrained("users")
                ->onDelete("cascade");
            $table
                ->foreignId("resolved_by")
                ->nullable()
                ->after("resolved_date")
                ->constrained("users")
                ->onDelete("set null");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table("asset_damage_reports", function (Blueprint $table) {
            $table->dropForeign(["reported_by"]);
            $table->dropForeign(["resolved_by"]);
            $table->dropColumn(["reported_by", "resolved_by"]);
        });

        Schema::table("asset_damage_reports", function (Blueprint $table) {
            $table->string("reported_by", 100);
            $table->string("resolved_by", 100)->nullable();
        });
    }
};
