<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MaintenanceSchedule extends Model
{
    use HasFactory;

    protected $fillable = [
        'asset_id',
        'scheduled_date',
        'frequency',
        'description',
        'assigned_to',
        'status',
    ];

    protected $casts = [
        'scheduled_date' => 'date',
    ];

    /**
     * Get the asset that owns this maintenance schedule
     */
    public function asset(): BelongsTo
    {
        return $this->belongsTo(Asset::class, 'asset_id');
    }

    /**
     * Get all maintenance logs for this schedule
     */
    public function logs(): HasMany
    {
        return $this->hasMany(MaintenanceLog::class, 'schedule_id');
    }
}
