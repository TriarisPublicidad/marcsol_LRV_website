<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;
use Spatie\Activitylog\Support\LogOptions;
use Spatie\Activitylog\Models\Concerns\LogsActivity;

class MediaAsset extends Model
{
    use HasFactory, SoftDeletes, LogsActivity;

    protected $fillable = [
        'titulo',
        'archivo',
        'disco',
        'carpeta',
        'tipo',
        'mime_type',
        'tamano_bytes',
        'ancho',
        'alto',
        'alt',
        'descripcion',
        'user_id',
    ];

    protected $casts = [
        'tamano_bytes' => 'integer',
        'ancho' => 'integer',
        'alto' => 'integer',
    ];

    protected $appends = [
        'url',
        'tamano_formateado',
        'dimensiones_texto',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function getUrlAttribute(): string
    {
        if (empty($this->archivo)) {
            return '';
        }

        if (str_starts_with($this->archivo, 'http://') || str_starts_with($this->archivo, 'https://')) {
            return $this->archivo;
        }

        if (str_starts_with($this->archivo, '/storage/')) {
            return asset($this->archivo);
        }

        return Storage::disk($this->disco ?? 'public')->url($this->archivo);
    }

    public function getTamanoFormateadoAttribute(): string
    {
        $bytes = $this->tamano_bytes ?? 0;

        if ($bytes >= 1048576) {
            return number_format($bytes / 1048576, 2) . ' MB';
        }

        if ($bytes >= 1024) {
            return number_format($bytes / 1024, 1) . ' KB';
        }

        return $bytes . ' B';
    }

    public function getDimensionesTextoAttribute(): ?string
    {
        if ($this->ancho && $this->alto) {
            return "{$this->ancho} × {$this->alto} px";
        }

        return null;
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logAll()
            ->logOnlyDirty();
    }
}
