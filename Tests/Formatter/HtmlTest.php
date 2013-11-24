<?php

namespace Starmind\Pygments\Formatter\Test;

use Starmind\Pygments\Exception\CommandException;
use Starmind\Pygments\Formatter\Html;

class HtmlTest extends \PHPUnit_Framework_TestCase
{
    public function testGetDefaultCliParameters()
    {
        $formatter = new Html();
        
        $this->assertEquals(
            '-f html -P style=default -P cssclass=highlight -P linenos=1',
            $formatter->getCliParameters()
        );
    }
    
    public function testGetFormat()
    {
        $formatter = new Html();

        $this->assertEquals(
            'html',
            $formatter->getFormat()
        );
    }
    
    public function testGenerateStyles()
    {
        $pygmentizeMock = $this->getMockBuilder('Starmind\Pygments\Pygmentize')
            ->disableOriginalConstructor()
            ->getMock();
        
        $pygmentizeMock->expects($this->any())
            ->method('executeCommand')
            ->will($this->returnValue('body { display: none; }'));
        
        $formatter = new Html();
        
        $this->assertEquals(
            'body { display: none; }',
            $formatter->generateStyles($pygmentizeMock)
        );
    }

    public function testGenerateStylesIncludeStyleTag()
    {
        $pygmentizeMock = $this->getMockBuilder('Starmind\Pygments\Pygmentize')
            ->disableOriginalConstructor()
            ->getMock();

        $pygmentizeMock->expects($this->any())
            ->method('executeCommand')
            ->will($this->returnValue('body { display: none; }'));

        $formatter = new Html();

        $this->assertEquals(
            "<style>\nbody { display: none; }\n</style>",
            $formatter->generateStyles($pygmentizeMock, true)
        );
    }

    public function testGenerateStylesError()
    {
        $pygmentizeMock = $this->getMockBuilder('Starmind\Pygments\Pygmentize')
            ->disableOriginalConstructor()
            ->getMock();

        $pygmentizeMock->expects($this->any())
            ->method('executeCommand')
            ->will($this->throwException(new CommandException()));

        $formatter = new Html();

        $this->assertEquals(
            '/* Could not generate Styles */',
            $formatter->generateStyles($pygmentizeMock, true)
        );
    }
}