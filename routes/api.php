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

Route::post('sendEmailVerification', function(\App\Http\Requests\SendVerificationCodeRequest $user){
    $user = $user->validated();

    $verificationCode = \App\Models\VerificationCode::create([
        'user_id' => $user['id'],
        'code' => mt_rand(100000, 999999),
        'expires_at' => Carbon::now()->addMinutes(2)
    ]);

    return $verificationCode->code;
})->name('sendEmailVerification');

Route::post('checkEmailVerification', function(\App\Http\Requests\CheckVerificationCodeRequest $verificationCode){
    $user = User::first();
    $verificationCode = $verificationCode->validated();

    if ($user->verification_code->where('expires_at','>=', Carbon::now())->sortByDesc('expires_at')->first()){
        $codeFromDB = $user->verification_code->where('expires_at','>=', Carbon::now())->sortByDesc('expires_at')->first()->code;
    } else {
        return response()->json([
            'message' => 'expired verification code'
        ], 401);
    }

    $codeFromUser = $verificationCode['code'];
    if ((int)$codeFromDB===(int)$codeFromUser){
        $user->update(['extra_verified_expires_at' => Carbon::now()->addMinutes(15)]);
        return response($user->extra_verified_expires_at, 200);
    }
    return response()->json([
        'message' => 'wrong verification code'
    ], 401);
})->name('checkEmailVerification');

Route::patch('updateProtectedFields', function(Request $request){

        $user = User::first();
        $data = [];

        if ($request->has('my_attribute')){
            $data['my_attribute'] = $request->input('my_attribute');
        }

        $user=User::findOrFail($user->id);
        $user->update($data);

        return $user;
})->middleware('extraVerified')->name('updateProtectedFields');

Route::post('testTelegram', [\App\Http\Controllers\TelegramVerification::class, 'sendMessage']);

