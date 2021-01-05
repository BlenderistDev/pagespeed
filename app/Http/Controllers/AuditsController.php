<?php

namespace App\Http\Controllers;

use App\Models\Audits;
use App\Models\DesktopAudits;

class AuditsController extends Controller
{
    public function index(): array
    {
        return [
            'desktop' => DesktopAudits::all(),
            'mobile' => Audits::all(),
        ];
    }
}
