<?php


use Illuminate\Support\Facades\Route;

Route::post('login', 'LoginController@login')
    ->name('.login');

Route::post('logout', 'LoginController@logout')
    ->name('.logout');

Route::view('login', 'auth::login');
