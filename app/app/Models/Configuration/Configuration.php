<?php

namespace App\Models\Configuration;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Configuration extends Model
{
    use HasFactory;

    public array $rules = [
        'key' => 'required',
        'value' => 'required',
        'name' => 'required'
    ];

    public $fillable = [
        "key", "value", "name"
    ];

    public $incrementing = false;

    public static function boot(): void
    {
        parent::boot();
        self::creating(function ($model) {
            $model->id = (string) Str::uuid();
        });
    }
}
