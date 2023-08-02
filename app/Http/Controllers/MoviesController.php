<?php

namespace App\Http\Controllers;

use App\Helpers\Cacher;
use App\Models\Movies;
use Illuminate\Http\Request;

class MoviesController extends Controller
{
    private  $cacher;

    public function __construct(){
        $this->cacher =  new Cacher();
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $movies = \App\Models\Movies::paginate(24);

        
        return view('movies', compact('movies'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('create');
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

        $this->cacher->setCached('movie_'.$item->id, $item->toJson());
        return redirect()->route('movies.index')->with('success','Movie has been created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $cachedData = $this->cacher->getCached('movie_'.$id);
        if($cachedData){
            $item= $cachedData;
        }else{
            $item = \App\Models\Movies::find($id);
            $this->cacher->setCached('movie_'.$item->id, $item->toJson());
        }
        return view('movie', compact('item'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $item = \App\Models\Movies::find($id);
        return view('edit', compact('item'));
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
        $this->cacher->setCached('movie_'.$item->id, $item->toJson());

        return redirect()->route('movies.index')->with('success','Movie Has Been updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $item = \App\Models\Movies::find($id);
        $this->cacher->removeCached('movie_'.$item->id);
        $item->delete();
        return redirect()->route('movies.index')->with('success','Movie has been deleted successfully');
    }
}
