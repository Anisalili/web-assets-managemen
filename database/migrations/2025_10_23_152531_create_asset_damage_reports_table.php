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
        Schema::create("asset_damage_reports", function (Blueprint $table) {
            $table->id();
            $table
                ->foreignId("asset_id")
                ->constrained("assets")
                ->onDelete("cascade");
            $table->string("reported_by", 100);
            $table->datetime("report_date");
            $table->string("severity", 20);
            $table->string("damage_type", 50)->nullable(); // mechanical, electrical, structural, etc
            $table->string("priority", 20)->default("medium"); // low, medium, high, critical
            $table->text("description");
            $table->text("impact_on_operations")->nullable();
            $table->string("image_path")->nullable();
            $table->decimal("estimated_repair_cost", 15, 2)->nullable();
            $table->string("status", 20);
            $table->datetime("resolved_date")->nullable();
            $table->string("resolved_by", 100)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists("asset_damage_reports");
    }
};
