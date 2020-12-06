<?php

namespace App\Http\Controllers;

use App\Models\Sites;
use Illuminate\Http\Request;


class SitesController extends Controller
{
    public function save(Request $request)
    {
        $oSite = new Sites();
        $oSite->domain = $request->input('domain');
        $oSite->save();
    }
}
