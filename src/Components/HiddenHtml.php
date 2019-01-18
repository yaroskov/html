<?php

namespace Yaroskov\Html\Components;

class HiddenHtml
{
    /**
     * @param string $data
     * @return string
     */
    public static function get(string $data): string
    {
        return htmlentities($data, ENT_QUOTES, 'UTF-8');
    }
}