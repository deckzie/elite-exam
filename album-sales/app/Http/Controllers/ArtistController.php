<?php

namespace App\Http\Controllers;

use App\Models\Artist;
use Illuminate\Http\Request;

class ArtistController extends Controller
{
    // ArtistController@index
    public function index()
    {
        return Artist::withCount('albums')
            ->withSum('albums', 'sales')
            ->get()
            ->map(function ($artist) {
                return [
                    'code' => $artist->code,
                    'name' => $artist->name,
                    'album_count' => $artist->albums_count,
                    'total_sales' => $artist->albums_sum_sales,
                ];
            });
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
