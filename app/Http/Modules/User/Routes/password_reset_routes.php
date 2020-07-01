<?php

use Illuminate\Support\Facades\Route;

//Password reset
Route::view('password/reset', 'user.register.passwords.email')
    ->name('password.request');

Route::post('password/email', 'ForgotPasswordController@sendResetLinkEmail')
    ->name('password.email');

Route::get('password/reset/{token}', 'ResetPasswordController@showResetForm')
    ->name('password.reset');

Route::post('password/reset', 'ResetPasswordController@reset')
    ->name('password.update');

//Password Confirm
Route::view('password/confirm', 'user.register.passwords.confirm')
    ->name('password.confirm.form');

Route::post('password/confirm', 'ConfirmPasswordController@confirm')
    ->name('password.confirm');
