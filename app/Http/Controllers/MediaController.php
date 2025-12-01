<?php
namespace App\Http\Controllers;

use App\Models\Media;
use Illuminate\Http\Request;

class MediaController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'ref_table' => 'required|string',
            'ref_id' => 'required|integer',
            'file_url' => 'required|string',
            'caption' => 'nullable|string',
            'mime_type' => 'required|string',
            'sort_order' => 'nullable|integer'
        ]);

        $media = Media::create($validated);

        return response()->json([
            'message' => 'Media berhasil ditambahkan',
            'data' => $media
        ], 201);
    }

    public function destroy($id)
    {
        $media = Media::findOrFail($id);
        $media->delete();

        return response()->json(['message' => 'Media dihapus']);
    }
}
