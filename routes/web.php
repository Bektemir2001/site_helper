<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/p', function () {
    $pages = \App\Models\Pages::all();
    $i = 0;
    dd($pages);
});


Route::get('/p1', [\App\Http\Controllers\DocumentController::class, 'store']);
Route::get('/p2', [\App\Http\Controllers\ElasticsearchController::class, 'index']);
Route::get('/p3', [\App\Http\Controllers\ElasticsearchController::class, 'store']);
