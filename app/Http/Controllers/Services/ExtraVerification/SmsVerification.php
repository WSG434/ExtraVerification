<?php

namespace App\Http\Controllers\Services\ExtraVerification;


class SmsVerification implements SendVerificationInterface
{

    public static function sendCode($to, $code) :void
    {
//        sendSMS($to, $code);
    }
}
