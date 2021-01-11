<?php

namespace App\Http\Controllers;

use App\Components\Audits\AuditFacade;
use Illuminate\Http\Request;

class AuditResultsController extends Controller
{
    public function index(Request $request): array
    {
        $filter = $request->input('filter', []);
        return AuditFacade::getAuditResults($filter);
    }
}
