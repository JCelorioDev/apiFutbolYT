<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EquipoController;
use App\Http\Controllers\JugadorController;

Route::controller(EquipoController::class)->group(function () {
    Route::get('/equipo', 'index');
    Route::post('/equipo', 'store');
    Route::get('/equipo/{id}', 'show');
    Route::post('/equipo/{id}', 'update');
    Route::delete('/equipo/{id}', 'destroy');
});

Route::controller(JugadorController::class)->group(function (){
    Route::get('/jugador', 'index');
    Route::post('/jugador', 'store');
    Route::get('/jugador/{id}', 'show');
    Route::put('/jugador/{id}', 'update');
    Route::delete('/jugador/{id}', 'destroy');
});



