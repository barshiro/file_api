<?php
namespace App\Http\Controllers;

use App\Models\Tag;
use Illuminate\Http\Request;

class TagController extends Controller
{
    public function index()
    {
        return response()->json(Tag::all());
    }

    public function store(Request $request)
    {
        $request->validate(['name' => 'required|string|max:50|unique:tags']);
        $tag = Tag::create([
            'UUID_TAG' => \Str::uuid(),
            'name' => $request->name,
        ]);
        return response()->json($tag, 201);
    }

    public function destroy($uuid)
    {
        $tag = Tag::findOrFail($uuid);
        $tag->delete(); // Каскадно удалит записи в file_tag
        return response()->json(['message' => 'Tag deleted']);
    }
}