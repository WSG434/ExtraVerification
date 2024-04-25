<?php

namespace App\Http\Controllers;

use DefStudio\Telegraph\Models\TelegraphBot;
use DefStudio\Telegraph\Models\TelegraphChat;
use Illuminate\Http\Request;


class TelegramVerification extends Controller
{
    public function sendMessage()
    {

        $chat = TelegraphChat::first();
        $chat->markdown("*Hello!*\n\nI'm here!")->send();
    }
}
