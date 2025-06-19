<?php

namespace App\Http\Controllers;

use App\Models\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FileController extends Controller
{
    public function show($uuid)
    {
        $file = File::where('UUID_FILE', $uuid)
            ->with('directory', 'tags')
            ->firstOrFail();

        return response()->json($file);
    }

    public function upload(Request $request)
    {
        $request->validate([
            'file' => 'required|file',
            
        ]);

        $uploadedFile = $request->file('file');
        $path = $uploadedFile->store('files', 'local');
        $fileSize = $uploadedFile->getSize();
        $fileType = $uploadedFile->getClientOriginalExtension();
        $fileName = $uploadedFile->getClientOriginalName();

        $file = File::create([
            'UUID_FILE' => \Str::uuid(),
            'UUID_USER' => '14bb2d14-9950-434f-8a6d-b5c2bd21d967', // Фиксированный UUID пользователя
            'UUID_DIR' => '01a4d274-3c8f-4bed-bd78-e8406d64a272',
            'name' => $fileName,
            'size' => $fileSize,
            'type' => $fileType,
            'path' => $path,
        ]);

        return response()->json($file, 201);
    }

    public function download($uuid)
    {
        $file = File::where('UUID_FILE', $uuid)->firstOrFail();
        return Storage::disk('local')->download($file->path, $file->name);
    }

    public function update(Request $request, $uuid)
    {
        $request->validate([
            'name' => 'sometimes|string|max:255',
            'directory' => 'sometimes|exists:dirs,UUID_DIR',
        ]);

        $file = File::where('UUID_FILE', $uuid)->firstOrFail();
        $file->update($request->only(['name', 'UUID_DIR']));
        return response()->json($file);
    }

    public function destroy($uuid)
    {
        $file = File::where('UUID_FILE', $uuid)->firstOrFail();
        Storage::disk('local')->delete($file->path);
        $file->delete();
        return response()->json(['message' => 'File successfully deleted']);
    }

    public function attachTag(Request $request, $uuid)
    {
        $request->validate(['tag_uuid' => 'required|exists:tags,UUID_TAG']);
        $file = File::where('UUID_FILE', $uuid)->firstOrFail();
        $file->tags()->attach($request->tag_uuid);
        return response()->json($file->load('tags'));
    }

    public function detachTag($uuid, $tagUuid)
    {
        $file = File::where('UUID_FILE', $uuid)->firstOrFail();
        $file->tags()->detach($tagUuid);
        return response()->json($file->load('tags'));
    }
}