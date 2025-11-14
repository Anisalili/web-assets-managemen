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
            $table
                ->foreignId("damage_report_id")
                ->constrained("asset_damage_reports")
                ->onDelete("cascade");
            $table
                ->foreignId("asset_id")
                ->constrained("assets")
                ->onDelete("cascade");
            $table->datetime("repair_start_date");
            $table->datetime("repair_end_date")->nullable();
            $table->string("repaired_by", 100);
            $table->unsignedBigInteger("assigned_to")->nullable();
            $table->text("repair_description");
            $table->text("spare_parts_used")->nullable();
            $table->decimal("repair_cost", 15, 2)->default(0);
            $table->string("status", 20); // pending, in_progress, completed, failed
            $table->text("notes")->nullable();
            $table->timestamps();
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
