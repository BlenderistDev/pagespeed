<?php

namespace App\Http\Controllers;

use App\Models\Audits;
use App\Models\DesktopAudits;
use Illuminate\Http\Request;

class AuditsController extends Controller
{
    public function index()
    {
        return [
            'desktop' => DesktopAudits::all(),
            'mobile' => Audits::all(),
        ];
    }
}
