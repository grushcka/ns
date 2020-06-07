<?php

use Illuminate\Support\Facades\Route;

Route::get('profile/{user?}', 'ProfileController@index');

Route::get('profile/edit/{user?}', 'ProfileController@edit')
    ->name('.edit');

Route::post('profile/edit/{user?}', 'ProfileController@update')
    ->name('.update');

Route::post('profile/delete/{user?}', 'ProfileController@delete')
    ->name('.delete');
