<?php

namespace Yaroskov\Html\Components;

class RemoveTags
{
    /**
     * @param string $data
     * @return string
     */
    public static function get(string $data): string
    {
        return trim(strip_tags($data));
    }
}