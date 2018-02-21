<?php

namespace Mcustiel\PowerRoute\Tests\Unit\InputSources;

use Psr\Http\Message\ServerRequestInterface;

abstract class AbstractInputSourceTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \Psr\Http\Message\ServerRequestInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $request;

    protected $evaluator;

    public function setUp()
    {
        $this->request = $this->getMockBuilder(ServerRequestInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
    }
}
