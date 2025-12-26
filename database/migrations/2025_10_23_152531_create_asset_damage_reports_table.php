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
            $table->unsignedBigInteger("asset_id");
            $table->string("reported_by", 100)->nullable(); // String, not foreign key
            $table->unsignedBigInteger("assigned_to")->nullable();
            $table->datetime("report_date");
            $table->string("severity", 20);
            $table->string("damage_type", 50)->nullable();
            $table->string("priority", 20)->default("medium");
            $table->text("description");
            $table->text("impact_on_operations")->nullable();
            $table->string("image_path")->nullable();
            $table->decimal("estimated_repair_cost", 15, 2)->nullable();
            $table->string("status", 20);
            $table->datetime("resolved_date")->nullable();
            $table->unsignedBigInteger("resolved_by")->nullable();
            $table->timestamps();

            // Foreign key constraints
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

            $table
                ->foreign("resolved_by")
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
        Schema::dropIfExists("asset_damage_reports");
    }
};
