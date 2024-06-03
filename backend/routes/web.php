<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RaMController;


Route::get('/', function () {
    return view('welcome');
});

Route::get('/api/characters', [RaMController::class, 'getCharacters']);
Route::get('/api/characters/{characterId}', [RaMController::class, 'getCharacterDetails']);


