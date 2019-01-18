<?php

namespace Yaroskov\Html;

use Yaroskov\Html\Components\Attr;
use Yaroskov\Html\Components\RemoveTags;
use Yaroskov\Html\Components\ClearGarbage;
use Yaroskov\Html\Components\HiddenHtml;
use Yaroskov\Html\Components\Table;

use Yaroskov\Html\Components\Tag\TagBuilder;

class Html
{
    /**
     * @param string $input_string
     * @param string $attribute
     * @return string
     */
    public static function attr(string $input_string, string $attribute = 'href'): string
    {
        return Attr::get($input_string, $attribute);
    }

    /**
     * @param string $data
     * @return string
     */
    public static function clean(string $data): string
    {
        return RemoveTags::get($data);
    }

    /**
     * @param string $data
     * @return string
     */
    public static function clearGarbage(string $data): string
    {
        return ClearGarbage::get($data);
    }

    /**
     * @param string $data
     * @return string
     */
    public static function hiddenHtml(string $data): string
    {
        return HiddenHtml::get($data);
    }

    /**
     * @param string $table
     * @return array
     */
    public static function table(string $table): array
    {
        return Table::get($table);
    }

    /**
     * @param string $input_string
     * @param string $element
     * @return TagBuilder
     */
    public static function tag(string $input_string, string $element): TagBuilder
    {
        return new TagBuilder($input_string, $element);
    }
}