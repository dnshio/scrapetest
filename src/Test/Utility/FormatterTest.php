<?php
namespace Sainsburys\Test\Service;

use Sainsburys\Utility\Formatter;

class FormatterTest extends \PHPUnit_Framework_TestCase
{

    public function testKiloBytes()
    {
        $bytes = 1024;
        $formattedString = Formatter::formatBytes($bytes);
        $this->assertEquals('1 Kb', $formattedString);
    }

    public function testMegaBytes()
    {
        $bytes = 1024 * 1024;
        $formattedString = Formatter::formatBytes($bytes);
        $this->assertEquals('1 MB', $formattedString);
    }

    public function testGigaBytes()
    {
        $bytes = 1024 * 1024 * 1024;
        $formattedString = Formatter::formatBytes($bytes);
        $this->assertEquals('1 GB', $formattedString);
    }

}