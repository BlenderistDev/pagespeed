<?php

namespace App\Http\Controllers;

use App\Components\Audits\Audits;
use Illuminate\Http\Request;

class AuditResultsController extends Controller
{
    public function index(Request $request): array
    {
        $filter = $request->input('filter', []);
        return Audits::getAuditResults($filter);
    }

    public function domain(Request $request): array
    {
        $domain = $request->input('domain');
        return Audits::getAuditResultsByDomain($domain);
    }
}
