<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Customer extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'phone',
        'address',
        'city',
        'postal_code',
        'company_name',
        'company_tax_id',
        'notes',
        'marketing_consent',
        'last_visit_at',
    ];

    protected $casts = [
        'marketing_consent' => 'boolean',
        'last_visit_at' => 'datetime',
    ];

    public function devices(): HasMany
    {
        return $this->hasMany(Device::class);
    }

    public function getFullNameAttribute(): string
    {
        return "{$this->first_name} {$this->last_name}";
    }
}
