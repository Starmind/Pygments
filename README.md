Pygments PHP Library
====================

The Pygments PHP library provides a way to work with the pygmentize CLI.

Currently only the HTML Formatter is supported with a limited subset of parameters.

Usage
-----

$pygmentize = new Starmind\Pygmentize();

$formatter = new Starmind\Formatter\Html();
$pygments = new Starmind\Pygments($formatter);

echo $pygments->pygmentize('<?php echo "test"; ?>', 'php');

echo $formatter->generateStyles($pygmentize);