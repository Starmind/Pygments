Pygments PHP Library
====================

The Pygments PHP library provides a way to work with the pygmentize CLI from http://pygments.org.

Currently only the HTML Formatter is supported with a limited subset of parameters.

Usage
-----

    $pygmentize = new Starmind\Pygmentize();  
    $formatter = new Starmind\Formatter\Html();  
    $pygments = new Starmind\Pygments();
    
    // highlight the specified string
    echo $pygments->highlight('<?php echo "test"; ?>', 'php', $formatter);
    
    // generate the css rules
    echo $formatter->generateStyles($pygmentize);
