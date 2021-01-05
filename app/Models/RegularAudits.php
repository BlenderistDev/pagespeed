<?php

namespace App\Models;

use Cron\CronExpression;
use Illuminate\Console\Scheduling\ManagesFrequencies;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class RegularAudits extends Model
{
    use HasFactory;
    use ManagesFrequencies;

    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function getCronStringAttribute(): string
    {
        return "{$this->minute} {$this->hour} {$this->month_day} {$this->month} {$this->week_day}";
    }

    public function isDue(): bool
    {
        $date = Carbon::now();
        $cronExpression = new CronExpression($this->cron_string);
        return $cronExpression->isDue($date->toDateTimeString());
    }
}
