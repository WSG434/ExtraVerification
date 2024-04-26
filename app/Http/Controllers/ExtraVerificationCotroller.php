<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Services\ExtraVerification\EmailVerification;
use App\Http\Controllers\Services\ExtraVerification\SmsVerification;
use App\Http\Controllers\Services\ExtraVerification\TelegramVerification;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class ExtraVerificationCotroller extends Controller
{
    public function sendVerificationCode(\App\Http\Requests\SendVerificationCodeRequest $request)
    {
        $request = $request->validated();

        $verificationCode = \App\Models\VerificationCode::create([
            'user_id' => $request['id'],
            'verification_type_id' => \App\Models\VerificationType::query()->where('name', $request['verification_type'])->value('id'),
            'code' => mt_rand(100000, 999999),
            'expires_at' => Carbon::now()->addMinutes(2)
        ]);

        switch ($request['verification_type']){
            case 'Email':
                EmailVerification::sendCode($request['email'], $verificationCode->code);
                break;
            case 'SMS':
                SmsVerification::sendCode($request['number'], $verificationCode->code);
                break;
            case 'Telegram':
                TelegramVerification::sendCode($request['telegramChatId'], $verificationCode->code);
                break;
            default:
                return response()->json([
                    'message' => 'verification type not exist'
                ], 404);
        }

        return $verificationCode->code;
    }

    public function checkVerificationCode(\App\Http\Requests\CheckVerificationCodeRequest $verificationCode)
    {
        $user = User::first();
        $verificationCode = $verificationCode->validated();

        if ($user->verification_code->where('expires_at', '>=', Carbon::now())->sortByDesc('expires_at')->first()) {
            $codeFromDB = $user->verification_code->where('expires_at', '>=', Carbon::now())->sortByDesc('expires_at')->first()->code;
        } else {
            return response()->json([
                'message' => 'expired verification code'
            ], 401);
        }

        $codeFromUser = $verificationCode['code'];
        if ((int)$codeFromDB === (int)$codeFromUser) {
            $user->update(['extra_verified_expires_at' => Carbon::now()->addMinutes(15)]);
            return response($user->extra_verified_expires_at, 200);
        }
        return response()->json([
            'message' => 'wrong verification code'
        ], 401);
    }

    public function updateProtectedFields(Request $request)
    {

        $user = User::first();
        $data = [];

        if ($request->has('my_attribute')) {
            $data['my_attribute'] = $request->input('my_attribute');
        }

        $user = User::findOrFail($user->id);
        $user->update($data);

        return $user;
    }

}
