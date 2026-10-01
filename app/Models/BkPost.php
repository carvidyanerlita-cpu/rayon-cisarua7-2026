<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BkPost extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'title',
        'image',
        'content',
        'author',
        'category',
        'status',
        'response',
    ];

    public function scopeArticles(Builder $query): Builder
    {
        return $query->where('type', 'ARTICLE');
    }

    public function scopeCurhats(Builder $query): Builder
    {
        return $query->where('type', 'CURHAT_ANONIM');
    }
}