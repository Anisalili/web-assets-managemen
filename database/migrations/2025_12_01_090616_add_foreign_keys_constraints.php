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
        // rooms -> buildings
        Schema::table("rooms", function (Blueprint $table) {
            $table
                ->foreign("building_id")
                ->references("id")
                ->on("buildings")
                ->onDelete("cascade");
        });

        // assets -> asset_categories, rooms
        Schema::table("assets", function (Blueprint $table) {
            $table
                ->foreign("category_id")
                ->references("id")
                ->on("asset_categories")
                ->onDelete("cascade");

            $table
                ->foreign("room_id")
                ->references("id")
                ->on("rooms")
                ->onDelete("set null");
        });

        // asset_status_history -> assets, rooms
        Schema::table("asset_status_history", function (Blueprint $table) {
            $table
                ->foreign("asset_id")
                ->references("id")
                ->on("assets")
                ->onDelete("cascade");

            $table
                ->foreign("previous_room_id")
                ->references("id")
                ->on("rooms")
                ->onDelete("set null");

            $table
                ->foreign("new_room_id")
                ->references("id")
                ->on("rooms")
                ->onDelete("set null");

            $table
                ->foreign("changed_by")
                ->references("id")
                ->on("users")
                ->onDelete("set null");
        });

        // maintenance_schedules -> assets, users
        Schema::table("maintenance_schedules", function (Blueprint $table) {
            $table
                ->foreign("asset_id")
                ->references("id")
                ->on("assets")
                ->onDelete("cascade");

            $table
                ->foreign("assigned_to")
                ->references("id")
                ->on("users")
                ->onDelete("set null");
        });

        // maintenance_logs -> maintenance_schedules, assets, users
        Schema::table("maintenance_logs", function (Blueprint $table) {
            $table
                ->foreign("schedule_id")
                ->references("id")
                ->on("maintenance_schedules")
                ->onDelete("set null");

            $table
                ->foreign("asset_id")
                ->references("id")
                ->on("assets")
                ->onDelete("cascade");

            $table
                ->foreign("performed_by")
                ->references("id")
                ->on("users")
                ->onDelete("set null");
        });

        // asset_damage_reports -> assets, users
        Schema::table("asset_damage_reports", function (Blueprint $table) {
            $table
                ->foreign("asset_id")
                ->references("id")
                ->on("assets")
                ->onDelete("cascade");

            $table
                ->foreign("reported_by")
                ->references("id")
                ->on("users")
                ->onDelete("set null");

            $table
                ->foreign("assigned_to")
                ->references("id")
                ->on("users")
                ->onDelete("set null");

            $table
                ->foreign("resolved_by")
                ->references("id")
                ->on("users")
                ->onDelete("set null");
        });

        // asset_repairs -> asset_damage_reports, assets, users
        Schema::table("asset_repairs", function (Blueprint $table) {
            $table
                ->foreign("damage_report_id")
                ->references("id")
                ->on("asset_damage_reports")
                ->onDelete("cascade");

            $table
                ->foreign("asset_id")
                ->references("id")
                ->on("assets")
                ->onDelete("cascade");

            $table
                ->foreign("repaired_by")
                ->references("id")
                ->on("users")
                ->onDelete("set null");

            $table
                ->foreign("assigned_to")
                ->references("id")
                ->on("users")
                ->onDelete("set null");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table("asset_repairs", function (Blueprint $table) {
            $table->dropForeign(["damage_report_id"]);
            $table->dropForeign(["asset_id"]);
            $table->dropForeign(["repaired_by"]);
            $table->dropForeign(["assigned_to"]);
        });

        Schema::table("asset_damage_reports", function (Blueprint $table) {
            $table->dropForeign(["asset_id"]);
            $table->dropForeign(["reported_by"]);
            $table->dropForeign(["assigned_to"]);
            $table->dropForeign(["resolved_by"]);
        });

        Schema::table("maintenance_logs", function (Blueprint $table) {
            $table->dropForeign(["schedule_id"]);
            $table->dropForeign(["asset_id"]);
            $table->dropForeign(["performed_by"]);
        });

        Schema::table("maintenance_schedules", function (Blueprint $table) {
            $table->dropForeign(["asset_id"]);
            $table->dropForeign(["assigned_to"]);
        });

        Schema::table("asset_status_history", function (Blueprint $table) {
            $table->dropForeign(["asset_id"]);
            $table->dropForeign(["previous_room_id"]);
            $table->dropForeign(["new_room_id"]);
            $table->dropForeign(["changed_by"]);
        });

        Schema::table("assets", function (Blueprint $table) {
            $table->dropForeign(["category_id"]);
            $table->dropForeign(["room_id"]);
        });

        Schema::table("rooms", function (Blueprint $table) {
            $table->dropForeign(["building_id"]);
        });
    }
};
