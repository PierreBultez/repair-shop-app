<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Device extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'customer_id',
        'device_model_id',
        'serial_number',
        'imei',
        'color',
        'capacity',
        'condition_notes',
        'has_password',
        'password',
        'accessories'
    ];

    protected $casts = [
        'has_password' => 'boolean',
        'accessories' => 'array'
    ];

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function deviceModel(): BelongsTo
    {
        return $this->belongsTo(DeviceModel::class);
    }

    public function getFullNameAttribute(): string
    {
        $model = $this->deviceModel;
        $brand = $model->brand;

        $capacity = $this->capacity ? ", {$this->capacity}" : '';
        $color = $this->color ? ", {$this->color}" : '';

        return "{$brand->name} {$model->name}{$capacity}{$color}";
    }
}
