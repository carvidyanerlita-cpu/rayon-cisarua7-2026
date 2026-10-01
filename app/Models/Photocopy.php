<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Photocopy extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'distance',
        'hours',
        'map_url',
        'price_list',
    ];

    protected function casts(): array
    {
        return [
            'price_list' => 'array',
        ];
    }
}
