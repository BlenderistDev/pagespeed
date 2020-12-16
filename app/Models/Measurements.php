<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Measurements extends Model
{
    use HasFactory;

    protected $fillable = ['domain', 'comment'];

    public function measure(): HasMany
    {
        return $this->hasMany(PageSpeedMobileAudits::class);
    }

    public function measureDesktop(): HasMany
    {
        return $this->hasMany(PageSpeedDesktopAudits::class);
    }
}
