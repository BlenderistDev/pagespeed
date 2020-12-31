<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegularAuditsPost;
use App\Models\RegularAudits;
use Illuminate\Http\Response;
use Illuminate\Support\Collection;

class RegularAuditsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(): Collection
    {
        return RegularAudits::all()->sortByDesc('created_at');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param RegularAuditsPost $request
     * @return Response
     */
    public function store(RegularAuditsPost $request)
    {
        if ($request->validated()) {
            RegularAudits::updateOrCreate(['id' =>$request->input('id')], $request->all());
        }
    }
}
