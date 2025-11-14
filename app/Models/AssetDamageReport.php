<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AssetDamageReport extends Model
{
    protected $fillable = [
        "asset_id",
        "reported_by",
        "report_date",
        "severity",
        "damage_type",
        "priority",
        "description",
        "impact_on_operations",
        "image_path",
        "estimated_repair_cost",
        "status",
        "resolved_date",
        "resolved_by",
    ];

    protected $casts = [
        "report_date" => "datetime",
        "resolved_date" => "datetime",
        "estimated_repair_cost" => "decimal:2",
    ];

    public function asset(): BelongsTo
    {
        return $this->belongsTo(Asset::class);
    }

    public function repairs(): HasMany
    {
        return $this->hasMany(AssetRepair::class, "damage_report_id");
    }
}
