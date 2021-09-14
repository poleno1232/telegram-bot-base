<?php

namespace App\Http\Controllers;

use App\Services\TelegramService;
use Illuminate\Http\Request;
use Telegram\Bot\Laravel\Facades\Telegram;

class WebhookController extends Controller
{
    protected TelegramService $service;

    public function hook(Request $request)
    {
        $update = Telegram::getWebhookUpdate();
        $bot = Telegram::bot();
        $this->service = new TelegramService();

        if ($update->hasCommand()) {
            $bot->processCommand($update);
        } else {
            $this->service->setData($bot, $update);

            if (isset($update['callback_query'])) {
                $this->service->handleUpdates($update['callback_query']['data']);
            }
        }

        return response();
    }
}
