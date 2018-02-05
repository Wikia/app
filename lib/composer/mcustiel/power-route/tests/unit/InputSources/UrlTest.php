<?php

namespace Mcustiel\PowerRoute\Tests\Unit\InputSources;

use Mcustiel\PowerRoute\InputSources\Url;
use Psr\Http\Message\UriInterface;

class UrlTest extends AbstractInputSourceTest
{
    /**
     * @var \Psr\Http\Message\UriInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    private $uri;

    public function setUp()
    {
        parent::setUp();
        $this->uri = $this->getMockBuilder(UriInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $this->evaluator = new Url();
    }

    /**
     * @test
     */
    public function shouldReturnTheFullUri()
    {
        $this->prepareUri('__toString', 'http://www.example.com/?potato=banana#coconut');
        $this->assertSame(
            'http://www.example.com/?potato=banana#coconut',
            $this->evaluator->getValue($this->request, 'full')
        );
    }

    /**
     * @test
     */
    public function shouldReturnTheFullUriWithNullArgument()
    {
        $this->prepareUri('__toString', 'http://www.example.com/?potato=banana#coconut');
        $this->assertSame(
            'http://www.example.com/?potato=banana#coconut',
            $this->evaluator->getValue($this->request)
        );
    }

    /**
     * @test
     */
    public function shouldGetTheHostPart()
    {
        $this->prepareUri('getHost', 'www.example.com');
        $this->assertSame('www.example.com', $this->evaluator->getValue($this->request, 'host'));
    }

    /**
     * @test
     */
    public function shouldGetTheSchemePart()
    {
        $this->prepareUri('getScheme', 'http');
        $this->assertSame('http', $this->evaluator->getValue($this->request, 'scheme'));
    }

    /**
     * @test
     */
    public function shouldGetTheAuthorityPart()
    {
        $this->prepareUri('getAuthority', 'potato@www.example.com:8080');
        $this->assertSame('potato@www.example.com:8080', $this->evaluator->getValue($this->request, 'authority'));
    }

    /**
     * @test
     */
    public function shouldGetTheFragmentPart()
    {
        $this->prepareUri('getFragment', 'fragment');
        $this->assertSame('fragment', $this->evaluator->getValue($this->request, 'fragment'));
    }

    /**
     * @test
     */
    public function shouldGetThePathPart()
    {
        $this->prepareUri('getPath', '/potato');
        $this->assertSame('/potato', $this->evaluator->getValue($this->request, 'path'));
    }

    /**
     * @test
     */
    public function shouldGetThePortPart()
    {
        $this->prepareUri('getPort', '8080');
        $this->assertSame('8080', $this->evaluator->getValue($this->request, 'port'));
    }

    /**
     * @test
     */
    public function shouldGetTheQueryPart()
    {
        $this->prepareUri('getQuery', 'potato=banana');
        $this->assertSame('potato=banana', $this->evaluator->getValue($this->request, 'query'));
    }

    /**
     * @test
     */
    public function shouldGetTheUserInfoPart()
    {
        $this->prepareUri('getUserInfo', 'user:pass');
        $this->assertSame('user:pass', $this->evaluator->getValue($this->request, 'user-info'));
    }

    /**
     * @test
     */
    public function shouldFailIfUrlPartIsNotSet()
    {
        $this->request
            ->expects($this->once())
            ->method('getUri')
            ->willReturn($this->uri);
        $this->setExpectedException(\Exception::class, 'Invalid config');
        $this->evaluator->getValue($this->request, 'potato');
    }

    private function prepareUri($method, $returnValue)
    {
        $this->request
            ->expects($this->once())
            ->method('getUri')
            ->willReturn($this->uri);
        $this->uri
            ->expects($this->once())
            ->method($method)
            ->willReturn($returnValue);
    }
}
