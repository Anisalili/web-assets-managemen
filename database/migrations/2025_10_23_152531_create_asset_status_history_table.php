<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('asset_status_history', function (Blueprint $table) {
            $table->id();
            $table->foreignId('asset_id')->constrained('assets')->onDelete('cascade');
            $table->foreignId('previous_room_id')->nullable()->constrained('rooms')->onDelete('set null');
            $table->foreignId('new_room_id')->nullable()->constrained('rooms')->onDelete('set null');
            $table->string('previous_status', 20)->nullable();
            $table->string('new_status', 20);
            $table->string('changed_by', 100);
            $table->datetime('change_date');
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('asset_status_history');
    }
};
