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
        Schema::create("assets", function (Blueprint $table) {
            $table->id();
            $table->string("asset_code", 50)->unique();
            $table->string("name", 150);
            $table->unsignedBigInteger("category_id");
            $table->unsignedBigInteger("room_id")->nullable();
            $table->string("status", 20);
            $table->string("owner", 100)->nullable();
            $table->string("private_owner", 100)->nullable();
            $table->date("purchase_date")->nullable();
            $table->decimal("value", 15, 2)->nullable();
            $table->string("image_path")->nullable();
            $table->datetime("last_update")->nullable();
            $table->text("notes")->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists("assets");
    }
};
