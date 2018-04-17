<?php

namespace Mcustiel\PowerRoute\Tests\Unit\Actions;

use Mcustiel\PowerRoute\Actions\Psr7MiddlewareAction;
use Mcustiel\PowerRoute\Common\Conditions\ClassArgumentObject;
use Mcustiel\PowerRoute\Common\TransactionData;
use Mcustiel\PowerRoute\Tests\Fixtures\Actions\Middleware;
use Zend\Diactoros\Response;
use Zend\Diactoros\ServerRequest;

class Psr7MiddlewareActionTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \Mcustiel\PowerRoute\Actions\ActionInterface
     */
    private $action;

    /**
     * @before
     */
    public function initAction()
    {
        $this->action = new Psr7MiddlewareAction();
    }

    /**
     * @test
     */
    public function shouldCallTheMiddlewareAction()
    {
        $middlewareAction = $this->getMockBuilder(Middleware::class)
            ->disableOriginalConstructor()
            ->getMock();

        $request = new ServerRequest();
        $response = new Response();
        $middlewareAction->expects($this->once())
            ->method('__invoke')
            ->with($this->equalTo($request), $this->equalTo($response), $this->equalTo(null));

        $actionConfig = new ClassArgumentObject($middlewareAction, null);

        $this->action->execute(new TransactionData($request, $response), $actionConfig);
    }

    /**
     * @test
     */
    public function shouldCallTheMiddlewareActionAndPassArgument()
    {
        $middlewareAction = $this->getMockBuilder(Middleware::class)
            ->disableOriginalConstructor()
            ->getMock();

        $arg = $this->getMockBuilder(Middleware::class)
            ->disableOriginalConstructor()
            ->getMock();

        $request = new ServerRequest();
        $response = new Response();
        $middlewareAction->expects($this->once())
            ->method('__invoke')
            ->with($this->equalTo($request), $this->equalTo($response), $this->equalTo($arg));

        $actionConfig = new ClassArgumentObject($middlewareAction, $arg);

        $this->action->execute(new TransactionData($request, $response), $actionConfig);
    }
}
