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
        Schema::table("maintenance_logs", function (Blueprint $table) {
            // Drop old column
            $table->dropColumn("performed_by");
        });

        Schema::table("maintenance_logs", function (Blueprint $table) {
            // Add new foreign key column
            $table
                ->foreignId("performed_by")
                ->nullable()
                ->after("asset_id")
                ->constrained("users")
                ->onDelete("set null");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table("maintenance_logs", function (Blueprint $table) {
            $table->dropForeign(["performed_by"]);
            $table->dropColumn("performed_by");
        });

        Schema::table("maintenance_logs", function (Blueprint $table) {
            $table->string("performed_by", 100);
        });
    }
};
