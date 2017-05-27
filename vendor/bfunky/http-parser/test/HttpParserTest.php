<?php

/**
 * User: jairo.rodriguez <jairo@bfunky.net>
 * Date: 16/04/2016
 * Time: 13:23
 */

namespace BFunky\Test\HttpParser\Exception;

use BFunky\HttpParser\HttpParser;
use BFunky\HttpParser\Entity\HttpRequestHeader;
use BFunky\HttpParser\Entity\HttpResponseHeader;

class HttpParserTest extends \PHPUnit_Framework_TestCase
{
    public function testParseHttpRequestHeader()
    {
        $parser = new HttpParser();
        $raw = <<<RAW
POST /path HTTP/1.1
User-Agent: PHP-SOAP/\BeSimple\SoapClient
Host: url.com:80
Accept: */*
Accept-Encoding: deflate, gzip
Content-Type:text/xml; charset=utf-8
Content-Length: 1108
Expect: 100-continue

RAW;
        $parser->parseHttpRequestHeader($raw);
        $this->assertEquals($parser->get('User-Agent'), 'PHP-SOAP/\BeSimple\SoapClient');
        $this->assertEquals($parser->get('Host'), 'url.com:80');
        $this->assertEquals($parser->get('Accept'), '*/*');
        $this->assertEquals($parser->get('Accept-Encoding'), 'deflate, gzip');
        $this->assertEquals($parser->get('Content-Type'), 'text/xml; charset=utf-8');
        $this->assertEquals($parser->get('Content-Length'), '1108');
        $this->assertEquals($parser->get('Expect'), '100-continue');
        /**
         * @var HttpRequestHeader $entityHeader
         */
        $entityHeader = $parser->getHeader();
        $this->assertInstanceOf('\BFunky\HttpParser\Entity\HttpRequestHeader', $entityHeader);
        $this->assertEquals($entityHeader->getMethod(), 'POST');
        $this->assertEquals($entityHeader->getPath(), '/path');
        $this->assertEquals($entityHeader->getProtocol(), 'HTTP/1.1');
    }

    public function testParseHttpResponseHeader()
    {
        $parser = new HttpParser();
        $raw = <<<RAW
HTTP/1.1 100 Continue

HTTP/1.1 200 OK
Date: Tue, 12 Apr 2016 13:58:01 GMT
Server: Apache/2.2.14 (Ubuntu)
X-Powered-By: PHP/5.3.14 ZendServer/5.0
Set-Cookie: ZDEDebuggerPresent=php,phtml,php3; path=/
Set-Cookie: PHPSESSID=6sf8fa8rlm8c44avk33hhcegt0; path=/; HttpOnly
Expires: Thu, 19 Nov 1981 08:52:00 GMT
Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0
Pragma: no-cache
Vary: Accept-Encoding
Content-Encoding: gzip
Content-Length: 192
Content-Type: text/xml
RAW;
        $parser->parseHttpResponseHeader($raw);
        $this->assertEquals($parser->get('Date'), 'Tue, 12 Apr 2016 13:58:01 GMT');
        $this->assertEquals($parser->get('Server'), 'Apache/2.2.14 (Ubuntu)');
        $this->assertEquals($parser->get('X-Powered-By'), 'PHP/5.3.14 ZendServer/5.0');
        $this->assertEquals($parser->get('Set-Cookie'), 'PHPSESSID=6sf8fa8rlm8c44avk33hhcegt0; path=/; HttpOnly');
        $this->assertEquals($parser->get('Expires'), 'Thu, 19 Nov 1981 08:52:00 GMT');
        $this->assertEquals($parser->get('Cache-Control'), 'no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
        $this->assertEquals($parser->get('Pragma'), 'no-cache');
        $this->assertEquals($parser->get('Vary'), 'Accept-Encoding');
        $this->assertEquals($parser->get('Content-Encoding'), 'gzip');
        $this->assertEquals($parser->get('Content-Length'), '192');
        $this->assertEquals($parser->get('Content-Type'), 'text/xml');
        /**
         * @var HttpResponseHeader $entityHeader
         */
        $entityHeader = $parser->getHeader();
        $this->assertInstanceOf('\BFunky\HttpParser\Entity\HttpResponseHeader', $entityHeader);
        $this->assertEquals($entityHeader->getProtocol(), 'HTTP/1.1');
        $this->assertEquals($entityHeader->getCode(), '200');
        $this->assertEquals($entityHeader->getMessage(), 'OK');

    }

    /**
     * @expectedException \BFunky\HttpParser\Exception\HttpParserBadFormatException
     */
    public function testThrownExceptionIfWrongRawData()
    {
        $parser = new HttpParser();
        $raw = <<<RAW
POST /path
User-Agent: PHP-SOAP/\BeSimple\SoapClient

RAW;
        $parser->parseHttpRequestHeader($raw);
    }
}