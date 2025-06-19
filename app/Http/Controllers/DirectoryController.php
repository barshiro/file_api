<?php

namespace App\Http\Controllers;

use App\Models\Dir;
use Illuminate\Http\Request;

class DirectoryController extends Controller
{
    public function index()
    {
        $directories = Dir::with('parent', 'children', 'files')->get();
        return response()->json($directories);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'parent_dir' => 'nullable|exists:dirs,UUID_DIR',
        ]);

        $directory = Dir::create([
            'UUID_DIR' => \Str::uuid(),
            'name' => $request->name,
            'parent_dir' => $request->parent_dir,
        ]);

        return response()->json($directory, 201);
    }

    public function show($uuid)
    {
        $directory = Dir::where('UUID_DIR', $uuid)
            ->with('parent', 'children', 'files')
            ->firstOrFail();
        return response()->json($directory);
    }

    public function update(Request $request, $uuid)
    {
        $request->validate([
            'name' => 'sometimes|string|max:255',
            'parent_dir' => 'sometimes|nullable|exists:dirs,UUID_DIR',
        ]);

        $directory = Dir::where('UUID_DIR', $uuid)->firstOrFail();
        $directory->update($request->only(['name', 'parent_dir']));
        return response()->json($directory);
    }

    public function destroy($uuid)
    {
        $directory = Dir::where('UUID_DIR', $uuid)
            ->withCount('children', 'files')
            ->firstOrFail();

        if ($directory->children_count > 0 || $directory->files_count > 0) {
            return response()->json(['message' => 'Directory is not empty'], 400);
        }

        $directory->delete();
        return response()->json(['message' => 'Directory successfully deleted']);
    }
}