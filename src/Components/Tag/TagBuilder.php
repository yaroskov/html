<?php

namespace Yaroskov\Html\Components\Tag;

class TagBuilder
{
    public $input_string;
    public $element;
    public $attribute = '';
    public $key_word = false;

    /**
     * TagBuilder constructor.
     * @param string $input_string
     * @param string $element
     */
    public function __construct(string $input_string, string $element)
    {
        $this->input_string = $input_string;
        $this->element = $element;
    }

    /**
     * @param string $attribute
     * @return $this
     */
    public function attribute(string $attribute)
    {
        $this->attribute = $attribute;
        return $this;
    }

    /**
     * @param string $key_word
     * @return $this
     */
    public function keyWord(string $key_word)
    {
        $this->key_word = $key_word;
        return $this;
    }

    /**
     * @return array
     */
    public function get(): array
    {
        return (new Tag($this))->data();
    }

    /**
     * @return array
     */
    public function text(): array
    {
        return (new Tag($this))->text();
    }
}