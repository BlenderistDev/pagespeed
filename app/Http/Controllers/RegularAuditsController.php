<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegularAuditsPost;
use App\Models\RegularAudits;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class RegularAuditsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(): Collection
    {
        return RegularAudits::all()->sortByDesc('created_at');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\RegularAuditsPost  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RegularAuditsPost $request)
    {
        if ($request->validated()) {
            RegularAudits::updateOrCreate(['id' =>$request->input('id')], $request->all());
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
      if ($request->validate()) {
        RegularAudits::updateOrCreate($request->input('id'), $request->all());
      }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
