<?php

namespace App\Core\Util;

class StrHelper
{
    public static function filterAccents(string $value): string
    {
        return preg_replace('/[^a-z]/i', '', iconv('UTF-8', 'ASCII//TRANSLIT', $value));
    }

}
