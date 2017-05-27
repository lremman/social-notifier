<?php

/**
 * User: jairo.rodriguez <jairo@bfunky.net>
 * Date: 16/04/2016
 * Time: 13:23
 */

namespace BFunky\Test\HttpParser\Exception;

use BFunky\HttpParser\Exception\HttpParserBadFormatException;

class HttpParserBadFormatExceptionTest extends \PHPUnit_Framework_TestCase
{
    public function testMessage()
    {
        $exception = new HttpParserBadFormatException();
        $this->assertEquals($exception->getMessage(), 'Bad format on raw data');
    }
}