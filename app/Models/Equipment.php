<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Equipment extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'equipment_type_id',
        'serial_number',
        'note'
    ];

    public function equipmentType(): BelongsTo
    {
        return $this->belongsTo(EquipmentType::class);
    }

    public function scopeSerialNumber(Builder $query, ?string $serial = null): Builder
    {
        if ($serial) {
            $query->where('serial_number', $serial);
        }
        return $query;
    }

    public function scopeNote(Builder $query, ?string $note = null): Builder
    {
        if ($note) {
            $query->where('note', 'like', "%{$note}%");
        }
        return $query;
    }

    public function scopeTypeName(Builder $query, ?string $typeName = null): Builder
    {
        if ($typeName) {
            $query->whereHas('equipmentType', fn($q) => $q->where('name', 'like', "{$typeName}%"));
        }
        return $query;
    }
}
