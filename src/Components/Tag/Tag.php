<?php

namespace Yaroskov\Html\Components\Tag;

use Yaroskov\Html\Html;

class Tag extends TagInner
{
    protected $input_string;
    protected $element;
    protected $attribute;
    protected $key_word;

    /**
     * Tag constructor.
     * @param TagBuilder $tag_builder
     */
    public function __construct(TagBuilder $tag_builder)
    {
        $this->input_string = $tag_builder->input_string;
        $this->element = $tag_builder->element;
        $this->attribute = $tag_builder->attribute;
        $this->key_word = $tag_builder->key_word;
    }

    /**
     * @return array
     */
    public function data(): array
    {
        $input_string = $this->input_string;
        $key_word = $this->key_word;
        $element = $this->element;
        $attribute = $this->attribute;

        $input_string = $this->trimBeforeKeyWord($input_string, $key_word);

        if (!$attribute) {
            $attribute = '';
        }

        $start_tag = '<' . $element;

        if ($element == 'input' || $element == 'img') {
            $end_tag = '/>';
        } else {
            $end_tag = '</' . $element . '>';
        }

        if ($attribute == '' && mb_strpos($input_string, $start_tag) !== false) {

            $results = $this->searching($input_string, $start_tag, $end_tag);
        } else {

            $results = $this->passThroughAttributes($input_string, $element, $attribute);
        }

        foreach ($results as $i => $result) {
            $results[$i] = Html::clearGarbage($result);
        }

        if ($attribute === 'id') {
            $results = $results[0];
        }

        return $results;
    }

    /**
     * @return array
     */
    public function text(): array
    {
        $results = $this->data();

        foreach ($results as $i => $result) {
            $results[$i] = strip_tags($result);
        }

        return $results;
    }
}