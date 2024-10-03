<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/{pathMatch}', function(){
    return view('welcome');
})->where('pathMatch', ".*");

Route::get('/dashboard', function(){
    return view('welcome');
})->middleware('auth:sanctum');