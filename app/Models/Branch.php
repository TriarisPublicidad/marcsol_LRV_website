<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Support\LogOptions;
use Spatie\Activitylog\Models\Concerns\LogsActivity;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Branch extends Model
{
    use HasFactory, SoftDeletes, HasSlug, LogsActivity;

    protected $fillable = [
        'nombre',
        'slug',
        'direccion',
        'ciudad',
        'telefono',
        'email',
        'mapa_lat',
        'mapa_lng',
        'horarios',
        'imagen',
        'status',
    ];

    protected $casts = [
        'status' => 'boolean',
        'mapa_lat' => 'decimal:7',
        'mapa_lng' => 'decimal:7',
    ];

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('nombre')
            ->saveSlugsTo('slug')
            ->doNotGenerateSlugsOnUpdate();
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logAll()
            ->logOnlyDirty()
            ->dontLogEmptyChanges();
    }

    public function promotions(): HasMany
    {
        return $this->hasMany(Promotion::class, 'sucursal_id');
    }

    public function events(): HasMany
    {
        return $this->hasMany(Event::class, 'sucursal_id');
    }
}
