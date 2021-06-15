<?php

namespace App\Telegram\Commands;

use App\Models\Dictionaries\StateDictionary;
use App\Models\TelegramUser;
use Telegram\Bot\Commands\Command;
use Telegram\Bot\Keyboard\Keyboard;
use Telegram\Bot\Laravel\Facades\Telegram;

class StartCommand extends Command
{
    protected $name = 'start';
    protected $description = "Initiates interactions";

    public function handle()
    {
        $keyboard = [[
            Keyboard::inlineButton(['text' => 'Without arguments', 'callback_data' => json_encode(['method' => 'meth'])]),
            Keyboard::inlineButton([
                'text' => 'With arguments',
                'callback_data' => json_encode(['method' => 'test', 'args' => ['arg1' => 'check', 'arg2' => 'peck']]),
            ]),
        ]];

        $user = $this->update->message->from;

        // TelegramUser::create([
        //     'id' => $user->id,
        //     'name' => $user->lastName . $user->firstName,
        //     'state' => StateDictionary::STATE_START,
        // ]);

        Telegram::sendMessage([
            'chat_id' => $this->update->message->chat->id,
            'text' => 'text',
            'reply_markup' => json_encode(['inline_keyboard' => $keyboard]),
        ]);
    }
}
