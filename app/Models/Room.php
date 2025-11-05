<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Room extends Model
{
    protected $fillable = [
        'room_code',
        'building_id',
        'name',
        'description',
    ];

    /**
     * Get the building that owns this room
     */
    public function building(): BelongsTo
    {
        return $this->belongsTo(Building::class);
    }

    /**
     * Get all assets in this room
     */
    public function assets(): HasMany
    {
        return $this->hasMany(Asset::class);
    }
}
