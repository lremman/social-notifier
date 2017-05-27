<?php

/**
 * User: jairo.rodriguez <jairo@bfunky.net>
 * Date: 16/04/2016
 * Time: 13:23
 */

namespace BFunky\HttpParser\Exception;

class HttpParserBadFormatException extends AbstractHttpParserException
{
    /**
     * @var string
     */
    const MESSAGE = 'Bad format on raw data';

    /**
     * HttpParserBadFormatException constructor.
     */
    public function __construct()
    {
        $this->message = self::MESSAGE;
        parent::__construct($this->message);
    }
}