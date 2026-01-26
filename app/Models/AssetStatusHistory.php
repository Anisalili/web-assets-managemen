<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AssetStatusHistory extends Model
{
    protected $table = 'asset_status_history';

    protected $fillable = [
        'asset_id',
        'previous_room_id',
        'new_room_id',
        'previous_status',
        'new_status',
        'changed_by',
        'change_date',
        'notes',
    ];

    protected $casts = [
        'change_date' => 'datetime',
    ];

    /**
     * Get the asset that owns this history
     */
    public function asset(): BelongsTo
    {
        return $this->belongsTo(Asset::class, 'asset_id')->withTrashed();
    }

    /**
     * Get the previous room
     */
    public function previousRoom(): BelongsTo
    {
        return $this->belongsTo(Room::class, 'previous_room_id');
    }

    /**
     * Get the new room
     */
    public function newRoom(): BelongsTo
    {
        return $this->belongsTo(Room::class, 'new_room_id');
    }

    /**
     * Get the user who made the change
     */
    public function changedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'changed_by');
    }
}
