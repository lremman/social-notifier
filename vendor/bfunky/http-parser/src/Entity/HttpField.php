<?php
/**
 * User: jairo.rodriguez <jairo@bfunky.net>
 * Date: 16/04/2016
 * Time: 11:27
 */

namespace BFunky\HttpParser\Entity;


class HttpField
{
    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $value;

    /**
     * HttpHeaderField constructor.
     * @param string $name
     * @param string $value
     */
    public function __construct($name, $value)
    {
        $this->name = $name;
        $this->value = $value;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return HttpField
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @param string $value
     * @return HttpField
     */
    public function setValue($value)
    {
        $this->value = $value;
        return $this;
    }
}