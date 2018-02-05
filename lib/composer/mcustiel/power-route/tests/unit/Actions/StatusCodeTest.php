<?php

namespace Mcustiel\PowerRoute\Tests\Unit\Actions;

use Mcustiel\PowerRoute\Actions\StatusCode;
use Mcustiel\PowerRoute\Common\TransactionData;
use Zend\Diactoros\Response;
use Zend\Diactoros\ServerRequest;

class StatusCodeTest extends \PHPUnit_Framework_TestCase
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
        $this->action = new StatusCode();
    }

    /**
     * @test
     */
    public function shouldSetAResponseWithDefaultStatusCode()
    {
        $transaction = new TransactionData(new ServerRequest(), new Response());
        $this->action->execute($transaction);
        $this->assertSame(200, $transaction->getResponse()->getStatusCode());
    }

    /**
     * @test
     */
    public function shouldSetAResponseWithGivenCode()
    {
        $transaction = new TransactionData(new ServerRequest(), new Response());
        $this->action->execute($transaction, 505);
        $this->assertSame(505, $transaction->getResponse()->getStatusCode());
    }

    /**
     * @test
     */
    public function shouldSetAResponseStatusCodeAndKeepOldDataFromResponse()
    {
        $transaction = new TransactionData(
            new ServerRequest(),
            new Response('data://text/plain,This is the previous text')
        );
        $this->action->execute($transaction, 204);
        $this->assertSame(204, $transaction->getResponse()->getStatusCode());
        $this->assertSame(
            'This is the previous text',
            $transaction->getResponse()->getBody()->__toString()
        );
    }

    /**
     * @test
     */
    public function shouldFailDefaultOnInvalidStatusCode()
    {
        $transaction = new TransactionData(new ServerRequest(), new Response());
        $this->setExpectedException(\RuntimeException::class, 'Invalid status code: 605');
        $this->action->execute($transaction, 605);
    }
}
