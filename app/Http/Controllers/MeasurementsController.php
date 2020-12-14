<?php

namespace App\Http\Controllers;

use App\Components\Audits\Audits;
use App\Components\Audits\PageSpeed\MeasureCollectionBuilder;
use App\Models\Measurements;

use Illuminate\Http\Request;

class MeasurementsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $audits = new Audits();
        $oMeasureCollectionBuilder = $audits->getAuditCollection();

        $filter = $request->input('filter', []);
        if (!empty($filter['field']) && !empty($filter['value'])) {
            $oMeasureCollectionBuilder->addLikeFilter($filter['field'], $filter['value']);
        }

        $sort = $request->input('sort', []);
        if (!empty($sort['field']) && !empty($sort['way'])) {
            $oMeasureCollectionBuilder->addSorting($sort['service'] ?? '', $sort['field'], $sort['way']);
        }

        $page = $request->input('page');
        $pageNumber = $page['page'] ?? 1;
        $onPage = $page['onPage'] ?? 10;

        return $oMeasureCollectionBuilder->getCollection($pageNumber, $onPage);
        return [
            'count' => $oMeasureCollectionBuilder->getCount(),
            'measurements' => $oMeasureCollectionBuilder->getCollection($pageNumber, $onPage),
        ];
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $oMeasurements = new Measurements([
            'domain' => $request->input('domain'),
        ]);
        $oMeasurements->save();
    }
}
