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
        Schema::table("asset_repairs", function (Blueprint $table) {
            // Drop old varchar column
            $table->dropColumn("repaired_by");
        });

        Schema::table("asset_repairs", function (Blueprint $table) {
            // Add new foreign key column
            $table
                ->foreignId("repaired_by")
                ->after("repair_end_date")
                ->constrained("users")
                ->onDelete("cascade");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table("asset_repairs", function (Blueprint $table) {
            $table->dropForeign(["repaired_by"]);
            $table->dropColumn("repaired_by");
        });

        Schema::table("asset_repairs", function (Blueprint $table) {
            $table->string("repaired_by", 100);
        });
    }
};
