<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Keep this test route if needed for web testing
Route::get('/test-direct', function () {
    return response()->json(['message' => 'Api funciona']);
});