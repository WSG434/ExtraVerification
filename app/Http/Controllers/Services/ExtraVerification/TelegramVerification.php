<?php

namespace App\Http\Controllers\Services\ExtraVerification;

use DefStudio\Telegraph\Models\TelegraphBot;
use DefStudio\Telegraph\Models\TelegraphChat;


class TelegramVerification implements SendVerificationInterface
{
    public static function sendCode($to, $code) :void
    {
        $bot = TelegraphBot::firstOrCreate([
            'token' => env('TELEGRAM_BOT_TOKEN'),
            'name' => 'ExtraVerificationBot'
        ]);

        $chat = $bot->chats()->firstOrCreate([
            'chat_id' => $to,
            'name' => "chat".$to
        ]);
        $chat->markdown("Your code: ".$code)->send();
    }
}
