<?php

namespace App\Models\Dictionaries;

class StateDictionary extends Dictionary
{
    public const STATE_START = 'start';
    public const STATE_MIDDLE = 'middle';

    public static function getDictionary(): array
    {
        return [];
    }
}
