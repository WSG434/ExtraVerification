<?php

namespace App\Http\Controllers\Services\ExtraVerification;

interface SendVerificationInterface
{
    public static function sendCode($to, $code);
}
