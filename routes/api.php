<?php

use App\Http\Controllers\Services\ExtraVerification\EmailVerification;
use App\Http\Controllers\Services\ExtraVerification\SmsVerification;
use App\Http\Controllers\Services\ExtraVerification\TelegramVerification;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::apiResource('users', \App\Http\Controllers\UserController::class);

Route::post('sendVerificationCode', [\App\Http\Controllers\ExtraVerificationCotroller::class, 'sendVerificationCode'])->name('sendVerificationCode');

Route::post('checkVerificationCode',[\App\Http\Controllers\ExtraVerificationCotroller::class, 'checkVerificationCode'])->name('checkVerificationCode');

Route::patch('updateProtectedFields',[\App\Http\Controllers\ExtraVerificationCotroller::class, 'updateProtectedFields'])->middleware('extraVerified')->name('updateProtectedFields');

