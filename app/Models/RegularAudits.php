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

    protected $timezone;

    protected $unfillable = ['id', 'created_at', 'updated_at'];

    protected $fillable = ['url', 'minute', 'hour', 'month_day', 'month', 'week_day'];

    public function getCronStringAttribute(): string
    {
        return "{$this->minute} {$this->hour} {$this->month_day} {$this->month} {$this->week_day}";
    }

    public function isDue(): bool
    {
        $date = Carbon::now();

        if ($this->timezone)
        {
            $date->setTimezone($this->timezone);
        }
        return CronExpression::factory($this->cron_string)->isDue($date->toDateTimeString());
    }

    public function nextDue(): Carbon
    {
        return Carbon::instance(CronExpression::factory($this->cron_string)->getNextRunDate());
    }

    public function lastDue(): Carbon
    {
        return Carbon::instance(CronExpression::factory($this->cron_string)->getPreviousRunDate());
    }
}
