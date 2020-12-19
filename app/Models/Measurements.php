<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Measurements extends Model
{
    use HasFactory;

    protected $fillable = ['domain', 'comment', 'user_id'];

    public function measure(): HasMany
    {
        return $this->hasMany(PageSpeedMobileAudits::class);
    }

    public function measureDesktop(): HasMany
    {
        return $this->hasMany(PageSpeedDesktopAudits::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
