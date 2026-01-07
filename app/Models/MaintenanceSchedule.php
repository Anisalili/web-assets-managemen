<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MaintenanceSchedule extends Model
{
    use HasFactory;

    // Status constants
    const STATUS_TERJADWAL = "terjadwal";
    const STATUS_PERLU_MAINTENANCE = "perlu_maintenance";
    const STATUS_DALAM_PERBAIKAN = "dalam_perbaikan";
    const STATUS_SELESAI = "selesai";
    const STATUS_DIBATALKAN = "dibatalkan";

    // Frequency constants
    const FREQUENCY_HARIAN = "harian";
    const FREQUENCY_MINGGUAN = "mingguan";
    const FREQUENCY_BULANAN = "bulanan";
    const FREQUENCY_TRIWULAN = "triwulan";
    const FREQUENCY_SEMESTERAN = "semesteran";
    const FREQUENCY_TAHUNAN = "tahunan";

    protected $fillable = [
        "asset_id",
        "scheduled_date",
        "next_maintenance_date",
        "frequency",
        "description",
        "image_path",
        "assigned_to",
        "status",
    ];

    protected $casts = [
        "scheduled_date" => "date",
        "next_maintenance_date" => "date",
    ];

    /**
     * Get available status options
     */
    public static function getStatusOptions(): array
    {
        return [
            self::STATUS_TERJADWAL => "Terjadwal",
            self::STATUS_PERLU_MAINTENANCE => "Perlu Maintenance",
            self::STATUS_DALAM_PERBAIKAN => "Dalam Perbaikan",
            self::STATUS_SELESAI => "Selesai",
            self::STATUS_DIBATALKAN => "Dibatalkan",
        ];
    }

    /**
     * Get available frequency options
     */
    public static function getFrequencyOptions(): array
    {
        return [
            self::FREQUENCY_HARIAN => "Harian (Deadline: 1 hari)",
            self::FREQUENCY_MINGGUAN => "Mingguan (Deadline: 1 hari)",
            self::FREQUENCY_BULANAN =>
                "Bulanan - Setiap Tanggal 1 (Deadline: 5 hari)",
            self::FREQUENCY_TRIWULAN =>
                "Triwulan - Setiap Tanggal 1 (Deadline: 5 hari)",
            self::FREQUENCY_SEMESTERAN =>
                "Semesteran - Setiap Tanggal 1 (Deadline: 5 hari)",
            self::FREQUENCY_TAHUNAN =>
                "Tahunan - Setiap Tanggal 1 (Deadline: 5 hari)",
        ];
    }

    /**
     * Get deadline days based on frequency
     */
    public function getDeadlineDays(): int
    {
        return match ($this->frequency) {
            self::FREQUENCY_HARIAN, self::FREQUENCY_MINGGUAN => 1,
            self::FREQUENCY_BULANAN,
            self::FREQUENCY_TRIWULAN,
            self::FREQUENCY_SEMESTERAN,
            self::FREQUENCY_TAHUNAN
                => 5,
            default => 1,
        };
    }

    /**
     * Get deadline date
     */
    public function getDeadlineDate(): \Carbon\Carbon
    {
        return $this->scheduled_date->copy()->addDays($this->getDeadlineDays());
    }

    /**
     * Calculate next maintenance date based on frequency
     */
    public function calculateNextMaintenanceDate(): ?\Carbon\Carbon
    {
        $baseDate = $this->scheduled_date->copy();

        return match ($this->frequency) {
            self::FREQUENCY_HARIAN => $baseDate->addDay()->startOfDay(),
            self::FREQUENCY_MINGGUAN => $baseDate->addWeek()->startOfDay(),
            self::FREQUENCY_BULANAN => $baseDate->addMonth()->startOfMonth(),
            self::FREQUENCY_TRIWULAN => $baseDate->addMonths(3)->startOfMonth(),
            self::FREQUENCY_SEMESTERAN => $baseDate
                ->addMonths(6)
                ->startOfMonth(),
            self::FREQUENCY_TAHUNAN => $baseDate->addYear()->startOfMonth(),
            default => null,
        };
    }

    /**
     * Get the asset that owns this maintenance schedule
     */
    public function asset(): BelongsTo
    {
        return $this->belongsTo(Asset::class, "asset_id")->withTrashed();
    }

    /**
     * Get the user (teknisi) assigned to this maintenance
     */
    public function assignedUser(): BelongsTo
    {
        return $this->belongsTo(User::class, "assigned_to");
    }

    /**
     * Get all maintenance logs for this schedule
     */
    public function logs(): HasMany
    {
        return $this->hasMany(MaintenanceLog::class, "schedule_id");
    }

    /**
     * Check if maintenance is overdue
     */
    public function isOverdue(): bool
    {
        return $this->scheduled_date->isPast() &&
            in_array($this->status, [
                self::STATUS_TERJADWAL,
                self::STATUS_PERLU_MAINTENANCE,
            ]);
    }

    /**
     * Check if maintenance is due today or past
     */
    public function isDue(): bool
    {
        return $this->scheduled_date->isToday() ||
            $this->scheduled_date->isPast();
    }
}
