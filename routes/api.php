<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DirectoryController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\TagController;

// Маршруты для аутентификации (оставим, но без защиты)
Route::post('auth/login', [AuthController::class, 'login']);
Route::post('auth/register', [AuthController::class, 'register']);
Route::get('auth/me', [AuthController::class, 'me']);
Route::put('auth/me', [AuthController::class, 'update']);
Route::post('auth/logout', [AuthController::class, 'logout']);

// Маршруты для директорий
Route::get('directories', [DirectoryController::class, 'index']);
Route::post('directories', [DirectoryController::class, 'store']);
Route::get('directories/{uuid}', [DirectoryController::class, 'show']);
Route::put('directories/{uuid}', [DirectoryController::class, 'update']);
Route::delete('directories/{uuid}', [DirectoryController::class, 'destroy']);

// Маршруты для файлов
Route::post('files/upload', [FileController::class, 'upload']);
Route::get('files/{uuid}', [FileController::class, 'show']);
Route::get('files/{uuid}/download', [FileController::class, 'download']);
Route::put('files/{uuid}', [FileController::class, 'update']);
Route::delete('files/{uuid}', [FileController::class, 'destroy']);

// Маршруты для тегов
Route::get('tags', [TagController::class, 'index']);
Route::post('tags', [TagController::class, 'store']);
Route::delete('tags/{uuid}', [TagController::class, 'destroy']);
Route::post('files/{uuid}/tags', [FileController::class, 'attachTag']);
Route::delete('files/{uuid}/tags/{tag_uuid}', [FileController::class, 'detachTag']);