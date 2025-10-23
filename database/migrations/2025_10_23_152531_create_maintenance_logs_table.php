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
        Schema::create('maintenance_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('schedule_id')->nullable()->constrained('maintenance_schedules')->onDelete('set null');
            $table->foreignId('asset_id')->constrained('assets')->onDelete('cascade');
            $table->string('performed_by', 100);
            $table->datetime('date_performed');
            $table->text('result')->nullable();
            $table->date('next_recommendation_date')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('maintenance_logs');
    }
};
