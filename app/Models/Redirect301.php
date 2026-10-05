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

    protected static function booted(): void
    {
        static::saved(function () {
            static::clearCache();
        });

        static::deleted(function () {
            static::clearCache();
        });

        static::restored(function () {
            static::clearCache();
        });
    }

    public static function getCachedMap(): array
    {
        return \Illuminate\Support\Facades\Cache::rememberForever('active_301_redirects', function () {
            return static::active()->pluck('url_destino', 'url_origen')->toArray();
        });
    }

    public static function clearCache(): void
    {
        \Illuminate\Support\Facades\Cache::forget('active_301_redirects');
    }
}
