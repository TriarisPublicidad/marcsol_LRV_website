<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Support\LogOptions;
use Spatie\Activitylog\Models\Concerns\LogsActivity;

class MenuItem extends Model
{
    use HasFactory, SoftDeletes, LogsActivity;

    protected $fillable = [
        'titulo',
        'url',
        'orden',
        'ubicacion',
        'parent_id',
        'status',
    ];

    protected $casts = [
        'orden' => 'integer',
        'status' => 'boolean',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logAll()
            ->logOnlyDirty()
            ->dontLogEmptyChanges();
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(MenuItem::class, 'parent_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(MenuItem::class, 'parent_id')->orderBy('orden', 'asc');
    }

    public function scopeHeader(Builder $query): Builder
    {
        return $query->where('ubicacion', 'header')
            ->where('status', true)
            ->whereNull('parent_id')
            ->orderBy('orden', 'asc');
    }

    public function scopeFooter(Builder $query): Builder
    {
        return $query->where('ubicacion', 'footer')
            ->where('status', true)
            ->whereNull('parent_id')
            ->orderBy('orden', 'asc');
    }
}
