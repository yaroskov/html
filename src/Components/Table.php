<?php

namespace Yaroskov\Html\Components;

use Yaroskov\Html\Html;

class Table
{
    /**
     * @param string $table
     * @return array
     */
    public static function get(string $table): array
    {
        $tr = Html::tag($table, 'tr')->get()->data();
        $td = array();
        for ($i = 0; $i < count($tr); $i++) {
            $td[] = Html::tag($tr[$i], 'td')->get()->data();
        }
        return $td;
    }
}