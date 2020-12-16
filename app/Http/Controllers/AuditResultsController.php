<?php

namespace App\Http\Controllers;

use App\Components\Audits\Audits;
use Illuminate\Http\Request;

class AuditResultsController extends Controller
{
    public function index(Request $request)
    {
        $idList = $request->input('idList', []);
        $audit = new Audits();
        return $audit->getAuditResults($idList);
    }
}