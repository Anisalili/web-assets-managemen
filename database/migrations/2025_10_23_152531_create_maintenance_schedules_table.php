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
        Schema::create("maintenance_schedules", function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("asset_id");
            $table->date("scheduled_date");
            $table->string("frequency", 20);
            $table->text("description")->nullable();
            $table->string("image_path")->nullable();
            $table->unsignedBigInteger("assigned_to")->nullable();
            $table->string("status", 20);
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
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists("maintenance_schedules");
    }
};
