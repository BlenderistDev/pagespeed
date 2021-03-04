<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

abstract class ServiceAuditsPrototype extends Model
{
    use HasFactory;

    protected $fillable = ['audits_id', 'value', 'measurements_id'];

    protected $appends = ['x', 'y'];

    abstract public function audit(): HasOne;

    abstract public function measurement(): BelongsTo;

    abstract public function getServiceName(): string;

    abstract public function getHeaders(): Collection;

    public function scopeByFilter(Builder $query, array $filter): Builder
    {
        foreach($filter as $field => $value) {
            if (!is_array($value)) {
                $value = [$value];
            }
            $query->whereIn($field, $value);
        }
        return $query;
    }

    public function scopeByDomain(Builder $query, string $domain): Builder
    {
        $query->whereHas('measurement', function(Builder $query) use ($domain) {
            return $query->where('domain', '=', $domain);
        });
        return $query;
    }

    public function scopeByMeasurement(Builder $query, int $measurementId): Builder
    {
        $query->whereHas('measurement', function(Builder $query) use ($measurementId) {
            return $query->where('measurements_id', '=', $measurementId);
        });
        return $query;
    }

    public function getXAttribute(): string
    {
        return $this->created_at;
    }

    public function getYAttribute(): float
    {
        $y = (float) $this->value;
        while ($y > 1) {
            $y = $y / 10;
        }
        return (float) $y;
    }
}
