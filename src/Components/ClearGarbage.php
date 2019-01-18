<?php

namespace Yaroskov\Html\Components;

class ClearGarbage
{
    /**
     * @param string $data
     * @return string
     */
    public static function get(string $data): string
    {
        $replaces = array(
            ' ' => array('&#x20;'),
            '' => array('&nbsp;', "\n", '&#171;', '&#160;', '&#187;', '&middot;', '&#128293;', '&#128077;', '&#216;'),
            '"' => array('&quot;', '&laquo;', '&raquo;', '&#034;'),
            '-' => array('&mdash;'),
            '(' => array('&#x28;'),
            '/' => array('&#x2f;'),
            ':' => array('&#x3a;'),
            '&' => array('&amp;')
        );

        foreach ($replaces as $i => $replace) {
            foreach ($replace as $j => $symbol) {
                $data = str_replace($symbol, $i, $data);
            }
        }

        $data = preg_replace('/\s\s+/', ' ', $data);
        $data = trim($data);

        return $data;
    }
}