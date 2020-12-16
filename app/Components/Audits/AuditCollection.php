<?php

namespace App\Components\Audits;

use App\Models\Measurements;
use Illuminate\Support\Collection;

class AuditCollection
{
    private $measurements;

    /**
     * @var IAuditService[] $auditServices
     */
    private array $auditServices = [];

    public function __construct($auditServices)
    {
        $this->measurements = Measurements::with($this->getRelations());
        $this->auditServices = $auditServices;
    }

    public function addSorting(string $serviceName, string $sortField, string $sortWay = 'ASC'): void
    {
        if (!empty($serviceName)) {
            $service = $this->getServiceByName($serviceName);
            if ($service) {
                $this->addServiceSort($service, $sortField, $sortWay);
            }
        } else {
            $this->measurements->orderBy($sortField, $sortWay);
        }
    }

    public function addLikeFilter(string $filterField, $value): void
    {
        $this->measurements->where($filterField, 'LIKE', "%$value%");
    }

    public function getCount(): int
    {
        return $this->measurements->count();
    }

    private function getServiceByName($serviceName): ?IAuditService
    {
        return $this->auditServices[$serviceName] ?? null;
    }

    private function getRelations(): array
    {
        foreach ($this->auditServices as $service) {
            $relations []= $service->getLinkName();
        }
        return $relations ?? [];
    }

    private function addServiceSort(IAuditService $service, string $sortField, string $sortWay = 'ASC'): void
    {
        $oModel = $service->getAuditResultFactory()->make();
        $oQuery = $oModel->select('value')
            ->whereColumn($oModel->getTable() . '.measurements_id', 'measurements.id')
            ->where('audits_id', $sortField)
            ->latest();

        if ($sortWay === "ASC") {
          $this->measurements->orderBy($oQuery->take(1));
        } else {
          $this->measurements->orderByDesc($oQuery->take(1));
        }
    }

    public function getCollection(int $page = 0, int $onPage = 10): Collection
    {
        return collect($this->measurements->paginate($onPage, ['*'], 'page', $page));
    }
}