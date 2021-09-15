<?php

namespace App\Telegram\Handlers;

use Telegram\Bot\Objects\Update;

abstract class AbstractHandler
{
    protected array $attributes;

    public function __construct(array $args)
    {
        $this->attributes = $args;
    }

    public function __get($name)
    {
        return $this->attributes[$name] ?? null;
    }

    public function handle(Update $update)
    {
        if ($this->trigger()) {
            $this->process($update);
        }
    }

    abstract protected function trigger(): bool;

    abstract protected function process(Update $update);
}
