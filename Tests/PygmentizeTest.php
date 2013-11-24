<?php

namespace Starmind\Pygments\Tests;

use Starmind\Pygments;
use org\bovigo\vfs\vfsStream;

class PygmentizeTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $root = vfsStream::setup('tmp');
        // create file with executable flag
        vfsStream::newFile('pygmentize')->at($root)->chmod(001);
    }
    
    public function testConstruct()
    {
        $pygmentize = new Pygments\Pygmentize(vfsStream::url('tmp/pygmentize'));

        $this->assertInstanceOf('Starmind\Pygments\Pygmentize', $pygmentize);
    }
    
    public function testConstructInvalid()
    {
        $this->setExpectedException('InvalidArgumentException');

        new Pygments\Pygmentize('/invalid/path');
    }
}
