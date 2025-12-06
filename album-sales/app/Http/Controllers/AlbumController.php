<?php

namespace App\Http\Controllers;

use App\Models\Album;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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

        $data = $request->only('artist_code', 'name', 'year', 'sales');

        if ($request->hasFile('cover')) {
            
            if ($album->cover && Storage::disk('public')->exists($album->cover)) {
                Storage::disk('public')->delete($album->cover);
            }

            $path = $request->file('cover')->store('covers', 'public');
            
            $data['cover'] = $path;
        }

        $album->update($data);

        return redirect()->back();
    }

    public function destroy($id)
    {
        Album::destroy($id);
        return redirect()->back();
    }
}
