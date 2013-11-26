<?php

namespace Starmind\Pygments;

abstract class Formatter
{
    protected $encoding = 'utf-8';
    
    abstract public function getCliParameters();
    abstract public function getFormat();

    /**
     * @param array $options
     * @return string
     */
    protected function buildExtraOptionsString(array $options)
    {
        $optionString = '';
        
        if (! isset($options['encoding'])) {
            $options['encoding'] = $this->encoding;
        }
        
        array_walk($options, function($value, $key) use (&$optionString) {
            $optionString .= sprintf('-P %s=%s ', $key, $value);
        });
        return trim($optionString);
    }
}
