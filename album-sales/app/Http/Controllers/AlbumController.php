<?php

namespace App\Http\Controllers;

use App\Models\Album;
use Illuminate\Http\Request;

class AlbumController extends Controller
{
    public function index()
    {
        return Album::with('artist')->get();
    }

    public function store(Request $request)
    {
        $album = Album::create($request->only('artist_code', 'name', 'year', 'sales', 'cover'));
        return response()->json($album, 201);
    }

    public function show($id)
    {
        return Album::with('artist')->findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $album = Album::findOrFail($id);
        $album->update($request->only('artist_code', 'name', 'year', 'sales', 'cover'));
        return response()->json($album);
    }

    public function destroy($id)
    {
        Album::destroy($id);
        return response()->json(null, 204);
    }
}
