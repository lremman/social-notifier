<?php

/**
 * User: jairo.rodriguez <jairo@bfunky.net>
 * Date: 16/04/2016
 * Time: 11:23
 */

namespace BFunky\HttpParser\Exception;

abstract class AbstractHttpParserException extends \Exception
{
    /**
     * AbstractHttpParserException constructor.
     * @param string $message
     * @param int $code
     * @param \Exception|null $previous
     */
    public function __construct($message = "", $code = 0, \Exception $previous = null) {
        parent::__construct($message, $code, $previous);
    }
}