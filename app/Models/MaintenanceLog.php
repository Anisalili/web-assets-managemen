<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MaintenanceLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'schedule_id',
        'asset_id',
        'performed_by',
        'date_performed',
        'result',
        'next_recommendation_date',
    ];

    protected $casts = [
        'date_performed' => 'datetime',
        'next_recommendation_date' => 'date',
    ];

    /**
     * Get the maintenance schedule that owns this log
     */
    public function schedule(): BelongsTo
    {
        return $this->belongsTo(MaintenanceSchedule::class, 'schedule_id');
    }

    /**
     * Get the asset that owns this maintenance log
     */
    public function asset(): BelongsTo
    {
        return $this->belongsTo(Asset::class, 'asset_id');
    }
}
