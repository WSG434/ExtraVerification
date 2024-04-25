<?php

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::apiResource('users', \App\Http\Controllers\UserController::class);

Route::post('sendEmailVerification', function(\App\Http\Requests\EmailVerificationRequest $user){
    $user = $user->validated();

    $verificationCode = \App\Models\VerificationCode::create([
        'user_id' => $user['id'],
        'code' => mt_rand(100000, 999999),
        'expires_at' => Carbon::now()->addMinutes(2)
    ]);

    return $verificationCode->code;
})->name('sendEmailVerification');

Route::post('checkEmailVerification', function(Request $request){
    $user = User::first();
    $codeFromDB = $user->verification_code->where('expires_at','>=', Carbon::now())->sortByDesc('expires_at')->first()->code;
    $codeFromUser = $request->code;
    if ((int)$codeFromDB===(int)$codeFromUser){
        $user->update(['extra_verified_expires_at' => Carbon::now()->addMinutes(15)]);
        return response($user->extra_verified_expires_at, 200);
    }
    return response(false, 401);
})->name('checkEmailVerification');

Route::patch('updateProtectedFields', function(Request $request){
   return "updated";
})->name('updateProtectedFields');
