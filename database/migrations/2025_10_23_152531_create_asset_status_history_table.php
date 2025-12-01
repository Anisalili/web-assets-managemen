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
