<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PulangComment extends Model
{
    use HasFactory;

    protected $fillable = [
        'author_name',
        'traffic_status',
        'date',
        'comment',
    ];

    protected function casts(): array
    {
        return [
            'date' => 'date',
        ];
    }
}
