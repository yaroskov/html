<?php

namespace Yaroskov\Html\Components\Tag;

use Yaroskov\Data\Data;

class TagInner
{
    /**
     * @param string $input_string
     * @param string $key_word
     * @return string
     */
    public function trimBeforeKeyWord(string $input_string, string $key_word): string
    {
        if ($key_word && $key_word != '' &&
            ($start_point = mb_strpos($input_string, $key_word)) !== false) {

            $input_string = mb_substr($input_string, $start_point, null);
        }

        return $input_string;
    }

    /**
     * @param string $input_data
     * @param string $start_tag
     * @param string $end_tag
     * @return array
     */
    public function searching(string $input_data, string $start_tag, string $end_tag): array
    {
        $results = array();
        $data_word = $input_data;

        $inner_start_tag = $this->startTag($start_tag);

        $start_point = mb_strpos($data_word, $start_tag, 0);

        do {
            $working_word = mb_substr($data_word, $start_point, null);

            $ended_word = $this->endingSearch($working_word, $inner_start_tag, $end_tag);

            $results[] = $ended_word;
            $data_word = str_replace($ended_word, '', $data_word);
            $start_point = mb_strpos($data_word, $start_tag, 0);
        } while ($start_point !== false && $ended_word != '');

        if (count($results) == 0) $results[] = "";

        return $results;
    }

    /**
     * @param string $start_tag
     * @return string
     */
    public function startTag(string $start_tag): string
    {
        if (mb_substr($start_tag, 0, 1) == '<')
            $inner_start_tag = Data::removeEndOfLine($start_tag, ' ');
        else $inner_start_tag = $start_tag;

        return $inner_start_tag;
    }

    /**
     * @param string $working_word
     * @param string $inner_start_tag
     * @param string $end_tag
     * @return string
     */
    public function endingSearch(string $working_word, string $inner_start_tag, string $end_tag): string
    {
        $end_tag_point = 0;
        $end_tags_number = 0;
        $start_tags_number = 0;

        do {
            $ended_word = $working_word;
            $end_tag_point_previous = $end_tag_point;
            $end_tag_point = mb_strpos($ended_word, $end_tag, $end_tag_point);
            if ($end_tag_point !== false) {
                $end_tag_point = $end_tag_point + mb_strlen($end_tag);
                $ended_word = mb_substr($ended_word, 0, $end_tag_point);

                $end_tags_number = substr_count($ended_word, $end_tag);
                $start_tags_number = substr_count($ended_word, $inner_start_tag);
            } else {
                $ended_word = mb_substr($ended_word, 0, $end_tag_point_previous);
            }
        } while ($end_tags_number < $start_tags_number && $end_tag_point !== false);

        return $ended_word;
    }

    /**
     * @param string $searching_string
     * @param string $element_name
     * @return array
     */
    public function searchByAttr(string $searching_string, string $element_name): array
    {
        $results = array();

        do {
            $element_name_position = mb_strpos($searching_string, $element_name, 0) + mb_strlen($element_name);
            $search_tag_name_string = mb_substr($searching_string, 0, $element_name_position);
            $start_of_tag_position = mb_strrpos($search_tag_name_string, '<');
            $start_of_tag = mb_substr($search_tag_name_string, $start_of_tag_position);

            $end_of_tag_position = mb_strpos($start_of_tag, ' ');
            $start_tag = mb_substr($start_of_tag, 0, $end_of_tag_position);

            if ($start_tag == '<input' || $start_tag == '<img') {
                $end_tag = '/>';
            } else {
                $end_tag = str_replace('<', '</', $start_tag) . '>';
            }

            $results[] = $this->searching($searching_string, $start_of_tag, $end_tag)[0];

            $searching_string = mb_substr($searching_string, $element_name_position);
        } while (mb_strpos($searching_string, $element_name) !== false);

        return $results;
    }

    /**
     * @param string $input_string
     * @param string $element
     * @param string $attribute
     * @return array
     */
    public function passThroughAttributes(string $input_string, string $element, string $attribute): array
    {
        if ($attribute == '') {
            $attributes = array('id', 'class', $attribute);
        } else {
            $attributes = array($attribute);
        }

        $quotes = array('"', "'");

        foreach ($attributes as $attr) {
            foreach ($quotes as $quote) {
                $element_name = $attr . '=' . $quote . $element . $quote;

                if (mb_strpos($input_string, $element_name) !== false) {
                    $results = $this->searchByAttr($input_string, $element_name);
                    break;
                } else {
                    $results = array('');
                }
            }
        }

        return $results;
    }
}