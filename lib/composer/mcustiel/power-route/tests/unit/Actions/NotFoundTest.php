<?php

namespace Mcustiel\PowerRoute\Tests\Unit\Actions;

use Mcustiel\PowerRoute\Actions\NotFound;
use Mcustiel\PowerRoute\Common\TransactionData;
use Zend\Diactoros\Response;
use Zend\Diactoros\ServerRequest;

class NotFoundTest extends \PHPUnit_Framework_TestCase
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
        $this->action = new NotFound();
    }

    /**
     * @test
     */
    public function shouldSetANotFoundResponse()
    {
        $transaction = new TransactionData(new ServerRequest(), new Response());
        $this->action->execute($transaction);
        $this->assertSame(404, $transaction->getResponse()->getStatusCode());
    }

    /**
     * @test
     */
    public function shouldSetANotFoundResponseAndKeepOldDataFromResponse()
    {
        $transaction = new TransactionData(
            new ServerRequest(),
            new Response('data://text/plain,This is the previous text')
        );
        $this->action->execute($transaction);
        $this->assertSame(404, $transaction->getResponse()->getStatusCode());
        $this->assertSame(
            'This is the previous text',
            $transaction->getResponse()->getBody()->__toString()
        );
    }
}
