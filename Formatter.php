<?php

namespace Starmind\Pygments;

abstract class Formatter
{
    abstract public function getCliParameters();
    abstract public function getFormat();

    /**
     * @param array $options
     * @return string
     */
    protected function buildExtraOptionsString(array $options)
    {
        $optionString = '';
        array_walk($options, function($value, $key) use (&$optionString) {
            $optionString .= sprintf('-P %s=%s ', $key, $value);
        });
        return trim($optionString);
    }
}
