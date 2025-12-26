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
        Schema::create("asset_repairs", function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("damage_report_id");
            $table->unsignedBigInteger("asset_id");
            $table->datetime("repair_start_date");
            $table->datetime("repair_end_date")->nullable();
            $table->unsignedBigInteger("repaired_by")->nullable();
            $table->unsignedBigInteger("assigned_to")->nullable();
            $table->text("repair_description");
            $table->text("spare_parts_used")->nullable();
            $table->decimal("repair_cost", 15, 2)->nullable();
            $table->string("status", 20);
            $table->text("notes")->nullable();
            $table->timestamps();

            // Foreign key constraints
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
        Schema::dropIfExists("asset_repairs");
    }
};
