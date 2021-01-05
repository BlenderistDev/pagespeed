<?php

namespace App\Http\Controllers;

use App\Components\Audits\AuditFacade;
use App\Models\Measurements;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class MeasurementsController extends Controller
{
    public function index(Request $request): Collection
    {
        $measureCollectionBuilder = AuditFacade::getAuditCollection();

        $filter = $request->input('filter', []);
        if (!empty($filter)) {
            foreach ($filter as $fieldName => $value) {
                $measureCollectionBuilder->addLikeFilter($fieldName, $value);
            }
        }

        $sort = $request->input('sort', []);
        if (!empty($sort['field']) && !empty($sort['way'])) {
            $measureCollectionBuilder->addSorting($sort['service'] ?? '', $sort['field'], $sort['way']);
        }

        $page = $request->input('page');
        $pageNumber = $page['page'] ?? 1;
        $onPage = $page['onPage'] ?? 10;

        return $measureCollectionBuilder->getCollection($pageNumber, $onPage);
    }

    public function store(Request $request, Measurements $measurements): void
    {
        $measurements->fill($request->only(['domain', 'comment']))->save();
    }
}
