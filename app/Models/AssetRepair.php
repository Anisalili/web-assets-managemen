<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AssetRepair extends Model
{
    protected $fillable = [
        "damage_report_id",
        "asset_id",
        "repair_start_date",
        "repair_end_date",
        "repaired_by",
        "repair_description",
        "spare_parts_used",
        "repair_cost",
        "status",
        "notes",
    ];

    protected $casts = [
        "repair_start_date" => "datetime",
        "repair_end_date" => "datetime",
        "repair_cost" => "decimal:2",
    ];

    public function damageReport(): BelongsTo
    {
        return $this->belongsTo(AssetDamageReport::class, "damage_report_id");
    }

    public function asset(): BelongsTo
    {
        return $this->belongsTo(Asset::class);
    }
}
