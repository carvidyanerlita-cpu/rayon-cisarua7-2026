<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Member extends Model
{
    use HasFactory;

    protected $fillable = [
        'nis',
        'name',
        'piket_day',
        'is_pkl',
        'sanction_active',
        'sanction_until',
    ];

    protected function casts(): array
    {
        return [
            'is_pkl' => 'boolean',
            'sanction_active' => 'boolean',
            'sanction_until' => 'date',
        ];
    }

    public function piketLogs(): HasMany
    {
        return $this->hasMany(PiketLog::class);
    }

    public function latestPiketLog()
    {
        return $this->hasOne(PiketLog::class)->latestOfMany();
    }

    public function isUnderSanction(): bool
    {
        if (! $this->sanction_active) {
            return false;
        }

        if ($this->sanction_until && Carbon::parse($this->sanction_until)->endOfDay()->isPast()) {
            return false;
        }

        return true;
    }

    public function remainingSanctionDays(): int
    {
        if (! $this->sanction_active || ! $this->sanction_until) {
            return 0;
        }

        $until = Carbon::parse($this->sanction_until)->endOfDay();
        if ($until->isPast()) {
            return 0;
        }

        return max(0, (int) ceil(now()->diffInDays($until, false)));
    }
}
