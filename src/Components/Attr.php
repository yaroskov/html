<?php

namespace Yaroskov\Html\Components;

class Attr
{
    /**
     * @param string $input_string
     * @param string $attribute
     * @return string
     */
    public static function get(string $input_string, string $attribute = 'href'): string
    {
        $reg_els = array('="([^"]*)"/i', "='([^']*)'/i");

        $output = array();
        foreach ($reg_els as $reg_el) {
            preg_match('/' . $attribute . $reg_el, $input_string, $output);
            if (count($output) > 0) {
                $input_string = $output[1];
                break;
            }
        }

        if (count($output) == 0) {
            $input_string = '';
        }

        return $input_string;
    }
}