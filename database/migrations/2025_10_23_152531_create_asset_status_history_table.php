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
        Schema::create("asset_status_history", function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("asset_id");
            $table->unsignedBigInteger("previous_room_id")->nullable();
            $table->unsignedBigInteger("new_room_id")->nullable();
            $table->string("previous_status", 20)->nullable();
            $table->string("new_status", 20);
            $table->unsignedBigInteger("changed_by")->nullable();
            $table->datetime("change_date");
            $table->text("notes")->nullable();
            $table->timestamps();

            // Foreign key constraints
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
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists("asset_status_history");
    }
};
