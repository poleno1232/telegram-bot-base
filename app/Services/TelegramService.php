<?php

namespace App\Services;

use BadMethodCallException;
use Illuminate\Support\Str;
use InvalidArgumentException;
use Telegram\Bot\Api as TelegramBot;
use Telegram\Bot\Objects\Update;

class TelegramService
{
    protected TelegramBot $bot;
    protected Update $update;

    protected const HANDLER_PATH = "App\Telegram\Handlers\\";

    /**
     * Set bot and update for inner use
     */
    public function setData(TelegramBot $bot, Update $update)
    {
        $this->bot = $bot;
        $this->update = $update;
    }

    /**
     * Handles incoming updates
     *
     * @param string $callbackQuery a JSON string with next structure: ['method' => 'name', 'args' => []]
     *
     * @return void
     */
    public function handleUpdates(string $callbackQuery)
    {
        $data = json_decode($callbackQuery, true);

        if (!isset($data['method'])) {
            return;
        }

        $args = $data['args'] ?? [];
        $handlerClass = static::HANDLER_PATH . Str::studly($data['method']) . 'Handler';

        if (!class_exists($handlerClass)) {
            throw new BadMethodCallException('Callback query supplied malformed method');
        }

        /** @var \App\Telegram\Handlers\AbstractHandler */
        $handler = new $handlerClass($args);

        $handler->handle($this->update);
    }
}
