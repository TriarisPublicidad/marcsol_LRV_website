<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Support\LogOptions;
use Spatie\Activitylog\Models\Concerns\LogsActivity;

class Redirect301 extends Model
{
    use HasFactory, SoftDeletes, LogsActivity;

    protected $table = 'redirects_301';

    protected $fillable = [
        'url_origen',
        'url_destino',
        'status',
        'hits',
    ];

    protected $casts = [
        'status' => 'boolean',
        'hits' => 'integer',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logAll()
            ->logOnlyDirty()
            ->dontLogEmptyChanges();
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('status', true);
    }
}
