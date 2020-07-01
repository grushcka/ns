<?php

use Illuminate\Support\Facades\Route;

//User Register
Route::view('register', 'user.register.index')
    ->name('.register');

Route::post('register', 'RegisterController@register')
    ->name('.register');

//Email verification
Route::get('email/verify', 'VerificationController@show')
    ->name('.verification.notice');

Route::get('email/verify/{id}/{hash}', 'VerificationController@verify')
    ->name('.verification.verify');

Route::post('email/resend', 'VerificationController@resend')
    ->name('.verification.resend');


