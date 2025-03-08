<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class DeviceBrand extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public function deviceModels(): HasMany
    {
        return $this->hasMany(DeviceModel::class);
    }
}
