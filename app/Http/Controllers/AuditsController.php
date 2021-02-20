<?php

namespace App\Http\Controllers;

use App\Models\Audits;
use App\Models\DesktopAudits;
use Illuminate\Support\Facades\Request;

class AuditsController extends Controller
{
    public function index(): array
    {
        return [
            'desktop' => DesktopAudits::all()->keyBy('id'),
            'mobile' => Audits::all()->keyBy('id'),
        ];
    }
}
