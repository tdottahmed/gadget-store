<?php

use Illuminate\Support\Facades\Route;

Route::get('manifest.json', function () {
    return response()->file(public_path('manifest.json'), ['Content-Type' => 'application/json']);
});