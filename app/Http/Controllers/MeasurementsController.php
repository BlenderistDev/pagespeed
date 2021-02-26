<?php

namespace App\Http\Controllers;

use App\Components\Audits\Audits;
use App\Models\Measurements;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class MeasurementsController extends Controller
{
    private const ON_PAGE_DEFAULT = 10;

    public function index(Request $request): Collection
    {
        $measureCollectionBuilder = Audits::getAuditCollection();

        $filter = $request->input('filter', []);
        foreach ($filter as $fieldName => $value) {
            $measureCollectionBuilder->addLikeFilter($fieldName, $value);
        }

        $lessFilter = $request->input('lessFilter', []);
        foreach ($lessFilter as $fieldName => $value) {
            $measureCollectionBuilder->addLessFilter($fieldName, $value);
        }

        $moreFilter = $request->input('moreFilter', []);
        foreach ($moreFilter as $fieldName => $value) {
            $measureCollectionBuilder->addMoreFilter($fieldName, $value);
        }

        $sort = $request->input('sort', []);
        if (!empty($sort['field']) && !empty($sort['way'])) {
            $measureCollectionBuilder->addSorting($sort['service'] ?? '', $sort['field'], $sort['way']);
        }

        $page = $request->input('page');
        $pageNumber = $page['page'] ?? 1;
        $onPage = $page['onPage'] ?? self::ON_PAGE_DEFAULT;

        return $measureCollectionBuilder->getCollection($pageNumber, $onPage);
    }

    public function store(Request $request, Measurements $measurements): void
    {
        $measurements->fill($request->only(['domain', 'comment']))->save();
    }
}
