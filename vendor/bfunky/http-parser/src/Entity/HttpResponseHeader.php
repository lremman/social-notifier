<?php

/**
 * User: jairo.rodriguez <jairo@bfunky.net>
 * Date: 16/04/2016
 * Time: 11:17
 */

namespace BFunky\HttpParser\Entity;


class HttpResponseHeader implements HttpHeaderInterface
{
    /**
     * @var string
     */
    protected $protocol;

    /**
     * @var string
     */
    protected $code;

    /**
     * @var string
     */
    protected $message;

    /**
     * HttpResponseHeader constructor.
     * @param string $protocol
     * @param string $code
     * @param string $message
     */
    public function __construct($protocol, $code, $message)
    {
        $this->protocol = $protocol;
        $this->code = $code;
        $this->message = $message;
    }

    /**
     * @return string
     */
    public function getProtocol()
    {
        return $this->protocol;
    }

    /**
     * @param string $protocol
     * @return HttpResponseHeader
     */
    public function setProtocol($protocol)
    {
        $this->protocol = $protocol;
        return $this;
    }

    /**
     * @return string
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * @param string $code
     * @return HttpResponseHeader
     */
    public function setCode($code)
    {
        $this->code = $code;
        return $this;
    }

    /**
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @param string $message
     * @return HttpResponseHeader
     */
    public function setMessage($message)
    {
        $this->message = $message;
        return $this;
    }
}