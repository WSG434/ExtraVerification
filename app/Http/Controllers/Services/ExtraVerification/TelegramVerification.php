<?php

namespace App\Http\Controllers\Services\ExtraVerification;

use DefStudio\Telegraph\Models\TelegraphChat;


class TelegramVerification implements SendVerificationInterface
{
    public static function sendCode($to, $code) :void
    {
        $chat = TelegraphChat::findOrCreate([
            'chat_id' => $to,
            'name' => "chat".$to
        ]);
        $chat->markdown("Your code: ".$code)->send();
    }
}
