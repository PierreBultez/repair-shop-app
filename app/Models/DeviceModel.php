<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class DeviceModel extends Model
{
    use HasFactory;

    protected $fillable = [
        'device_type_id',
        'device_brand_id',
        'name',
        'model_number',
        'specifications'
    ];

    protected $casts = [
        'specifications' => 'array'
    ];

    public function deviceType(): BelongsTo
    {
        return $this->belongsTo(DeviceType::class);
    }

    public function brand(): BelongsTo
    {
        return $this->belongsTo(DeviceBrand::class, 'device_brand_id');
    }

    public function devices(): HasMany
    {
        return $this->hasMany(Device::class);
    }

    public function getFullNameAttribute(): string
    {
        return "{$this->brand->name} {$this->name}";
    }
}
