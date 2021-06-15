<?php

namespace App\Telegram\Handlers;

use Telegram\Bot\Laravel\Facades\Telegram;
use Telegram\Bot\Objects\Update;

class TestHandler extends AbstractHandler
{
    protected function trigger(): bool
    {
        return true;
    }

    public function process(Update $update)
    {
        Telegram::sendMessage(['text' => $this->arg1, 'chat_id' => $update['callback_query']['message']['chat']['id']]);
    }
}
