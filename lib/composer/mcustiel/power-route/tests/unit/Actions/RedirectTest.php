<?php

namespace Mcustiel\PowerRoute\Tests\Unit\Actions;

use Mcustiel\PowerRoute\Actions\Redirect;
use Mcustiel\PowerRoute\Common\TransactionData;
use Zend\Diactoros\Response;
use Zend\Diactoros\ServerRequest;

class RedirectTest extends \PHPUnit_Framework_TestCase
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
        $this->action = new Redirect();
    }

    /**
     * @test
     */
    public function shouldSetARedirectResponse()
    {
        $transaction = new TransactionData(new ServerRequest(), new Response());
        $this->action->execute($transaction, 'http://github.com');
        $this->assertSame(302, $transaction->getResponse()->getStatusCode());
        $this->assertArrayHasKey('Location', $transaction->getResponse()->getHeaders());
        $this->assertSame(
            'http://github.com',
            $transaction->getResponse()->getHeaderLine('Location')
        );
    }

    /**
     * @test
     */
    public function shouldSetARedirecResponseAndKeepOldDataFromResponse()
    {
        $transaction = new TransactionData(
            new ServerRequest(),
            new Response('data://text/plain,This is the previous text')
        );
        $this->action->execute($transaction, 'http://github.com');
        $this->assertSame(302, $transaction->getResponse()->getStatusCode());
        $this->assertArrayHasKey('Location', $transaction->getResponse()->getHeaders());
        $this->assertSame(
            'http://github.com',
            $transaction->getResponse()->getHeaderLine('Location')
        );
        $this->assertSame(
            'This is the previous text',
            $transaction->getResponse()->getBody()->__toString()
        );
    }
}
