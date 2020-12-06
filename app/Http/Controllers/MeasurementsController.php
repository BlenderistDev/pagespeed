<?php

namespace App\Http\Controllers;

use App\Models\Measurements;
use App\Services\MeasureCollectionBuilder;
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
        $oMeasureCollectionBuilder = new MeasureCollectionBuilder();

        $sFilter = $request->input('filter', '');
        if ($sFilter) {
            $oMeasureCollectionBuilder->addLikeFilter('domain', $sFilter);
        }

        $sSortField = $request->input('sortField'. '');
        $sSortWay = $request->input('sortWay', '');
        $sSortService = (string) $request->input('sortServiceName', '');

        if ($sSortField) {
            $oMeasureCollectionBuilder->addSorting($sSortService, $sSortField, $sSortWay);
        }

        $iPage = $request->input('page');
        $iOnPage = $request->input('onPage');
        return $oMeasureCollectionBuilder->parse($iPage, $iOnPage);
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
