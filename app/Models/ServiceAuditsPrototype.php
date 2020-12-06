<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\HasOne;

abstract class ServiceAuditsPrototype extends Model
{
    use HasFactory;

    protected $fillable = ['audits_id', 'value', 'measurements_id'];

    abstract public function audit(): HasOne;

    abstract public function getServiceName(): string;

    abstract public function getHeaders(): Collection;
}
