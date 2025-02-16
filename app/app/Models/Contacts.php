<?php

namespace App\Models;

use App\Models\Configuration\Configuration;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Contacts extends Model
{
    use HasFactory;

    public $fillable = [
        "id", "name", "phone", "email", "date_of_birth", "company_id", "error_message", "response", "contact_id"
    ];

    public $incrementing = false;

    public $keyType = 'string';

    protected $casts = [
        'response' => 'array'
    ];

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    public function status(): BelongsTo
    {
        return $this->belongsTo(Configuration::class);
    }
}
