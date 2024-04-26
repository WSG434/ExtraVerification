<?php

namespace App\Http\Controllers\Services\ExtraVerification;


class EmailVerification implements SendVerificationInterface
{

    public static function sendCode($to, $code) :void
    {
//        mailto($to, $code);
    }
}
