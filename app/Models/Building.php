<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Building extends Model
{
    protected $fillable = [
        'building_code',
        'name',
        'description',
    ];

    /**
     * Get all rooms for this building
     */
    public function rooms(): HasMany
    {
        return $this->hasMany(Room::class);
    }

    /**
     * Get the count of rooms in this building
     */
    public function getRoomsCountAttribute(): int
    {
        return $this->rooms()->count();
    }
}
