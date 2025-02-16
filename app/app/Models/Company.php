<?php

namespace App\Models;

use App\Models\Configuration\Configuration;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Company extends Model
{
    use HasFactory;

    public $rules = [
        'name' => 'required'
    ];

    public $fillable = [
        "id", "name", "response", "error_message", "profile_id"
    ];

    public $incrementing = false;

    public $keyType = 'string';

    protected $casts = [
        'response' => 'array'
    ];

    public function contacts(): HasMany
    {
        return $this->hasMany(Contacts::class);
    }

    public function status(): BelongsTo
    {
        return $this->belongsTo(Configuration::class);
    }
}
