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
        Schema::create("maintenance_logs", function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("schedule_id")->nullable();
            $table->unsignedBigInteger("asset_id");
            $table->unsignedBigInteger("performed_by")->nullable();
            $table->datetime("date_performed");
            $table->text("result")->nullable();
            $table->text("spare_parts_used")->nullable();
            $table->decimal("maintenance_cost", 15, 2)->nullable();
            $table->date("next_recommendation_date")->nullable();
            $table->text("notes")->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists("maintenance_logs");
    }
};
