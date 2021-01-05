<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegularAuditsPost;
use App\Models\RegularAudits;
use Illuminate\Support\Collection;

class RegularAuditsController extends Controller
{
    public function index(): Collection
    {
        return RegularAudits::all()->sortByDesc('created_at');
    }

    public function store(RegularAuditsPost $request): void
    {
        if ($request->validated()) {
            RegularAudits::updateOrCreate(['id' =>$request->input('id')], $request->all());
        }
    }
}
