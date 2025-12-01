<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Asset extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        "asset_code",
        "name",
        "category_id",
        "room_id",
        "status",
        "owner",
        "private_owner",
        "purchase_date",
        "value",
        "last_update",
        "notes",
    ];

    protected $casts = [
        "purchase_date" => "date",
        "last_update" => "datetime",
        "value" => "decimal:2",
    ];

    /**
     * Get the category that owns this asset
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(AssetCategory::class, "category_id");
    }

    /**
     * Get the room where this asset is located
     */
    public function room(): BelongsTo
    {
        return $this->belongsTo(Room::class, "room_id");
    }

    /**
     * Get all status history for this asset
     */
    public function statusHistory(): HasMany
    {
        return $this->hasMany(AssetStatusHistory::class, "asset_id");
    }

    /**
     * Get all maintenance schedules for this asset
     */
    public function maintenanceSchedules(): HasMany
    {
        return $this->hasMany(MaintenanceSchedule::class, "asset_id");
    }

    /**
     * Get all maintenance logs for this asset
     */
    public function maintenanceLogs(): HasMany
    {
        return $this->hasMany(MaintenanceLog::class, "asset_id");
    }
}
