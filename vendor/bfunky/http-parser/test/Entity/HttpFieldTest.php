<?php

/**
 * User: jairo.rodriguez <jairo@bfunky.net>
 * Date: 16/04/2016
 * Time: 13:23
 */

namespace BFunky\Test\HttpParser\Entity;

use BFunky\HttpParser\Entity\HttpField;

class HttpFieldTest extends \PHPUnit_Framework_TestCase
{

    public function testGetters()
    {
        $field = new HttpField('a name' ,'a value');
        $this->assertEquals($field->getName(), 'a name');
        $this->assertEquals($field->getValue(), 'a value');
    }

    public function testSetters()
    {
        $field = new HttpField('a name' ,'a value');
        $field->setName('a different name');
        $field->setValue('a different value');
        $this->assertEquals($field->getName(), 'a different name');
        $this->assertEquals($field->getValue(), 'a different value');
    }
}