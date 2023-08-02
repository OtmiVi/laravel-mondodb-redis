<?php

namespace App\Http\Controllers;

use App\Models\Movies;
use Illuminate\Http\Request;

class MoviesApiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $movies = \App\Models\Movies::paginate(24);
        return $movies;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'poster' => 'required',
            'title' => 'required',
            'fullplot' => 'required',
        ]);

        $item = Movies::create($request->post());

        return $item;
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $item = \App\Models\Movies::find($id);
        return $item;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'poster' => 'required',
            'title' => 'required',
            'fullplot' => 'required',
        ]);

        $item = \App\Models\Movies::find($id);
        $item->fill($request->post())->save();

        return $item;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $item = \App\Models\Movies::find($id);
        $item->delete();
        return true;
    }
}
