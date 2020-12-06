<?php

namespace App\Services;

use App\Models\Measurements;
use App\Models\PageSpeedDesktopAudits;
use App\Models\PageSpeedMobileAudits;
use Illuminate\Support\Collection;

class MeasureCollectionBuilder
{
    private $measurements;

    /**
     * @var AuditService[] $auditServices
     */
    private array $auditServices = [];

    public function __construct()
    {
        $this->measurements = Measurements::with('measure')->with('measureDesktop');
        $this->auditServices['measureDesktop'] = new AuditService(new PageSpeedDesktopAudits());
        $this->auditServices['measure'] = new AuditService(new PageSpeedMobileAudits());
    }

    public function addSorting(string $sortService, string $sortField, string $sortWay = 'ASC')
    {
        if (!empty($sortService)) {
            if ($sortService === 'desktop') {
                $oModel = new PageSpeedDesktopAudits();
            } else if ($sortService === 'mobile') {
                $oModel = new PageSpeedMobileAudits();
            }
            if ($oModel) {
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
        } else {
            $this->measurements->orderBy($sortField, $sortWay);
        }
    }

    public function addLikeFilter(string $filterField, $value)
    {
        $this->measurements->where($filterField, 'LIKE', "%$value%");
    }

    public function getCollection(int $page = 0, int $onPage = 10): Collection
    {
        return collect($this->measurements->paginate($onPage, ['*'], 'page', $page)->items());
    }

    public function getCount(): int
    {
        return $this->measurements->count();
    }

    public function parse(int $page, int $onPage): array
    {
        $count = $this->getCount();
        $measurements = $this->getCollection($page, $onPage);

        $aRes = [
            'measurements' => $measurements->sortBy('domain'),
            'count' => $count,
            'services' => [],
        ];

        foreach($this->auditServices as $linkName => $auditService) {
            $aRes['services'][$auditService->getServiceName()]['audits'] = $auditService->parseServicesFromCollection($measurements, $linkName);
            $aRes['services'][$auditService->getServiceName()]['headers'] = $auditService->getHeaders();
        }
        return $aRes;
    }
}