<?php

namespace App\Http\Controllers;

use App\Models\Artist;
use Illuminate\Http\Request;

class ArtistController extends Controller
{
    public function index()
    {
        return Artist::with('albums')->get();
    }

    public function store(Request $request)
    {
        $artist = Artist::create($request->only('name'));
        return response()->json($artist, 201);
    }

    public function show($code)
    {
        return Artist::with('albums')->findOrFail($code);
    }

    public function update(Request $request, $code)
    {
        $artist = Artist::findOrFail($code);
        $artist->update($request->only('name'));
        return response()->json($artist);
    }

    public function destroy($code)
    {
        Artist::destroy($code);
        return response()->json(null, 204);
    }
}
