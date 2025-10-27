<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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
}
