<?php

use Mcustiel\Phiremock\Client\Phiremock as PhiremockClient;
use Mcustiel\Phiremock\Client\Utils\A;
use Mcustiel\Phiremock\Client\Utils\Is;
use Mcustiel\Phiremock\Client\Utils\Respond;

class ResetCest
{
    /**
     * @var \Mcustiel\Phiremock\Client\Phiremock
     */
    private $phiremock;

    public function _before(AcceptanceTester $I)
    {
        $this->phiremock = new PhiremockClient('127.0.0.1', '8086');
    }

    public function restoreExpectationAfterDelete(AcceptanceTester $I)
    {
        $I->sendDELETE('/__phiremock/expectations');
        $this->phiremock->reset();

        $I->sendGET('/hello');
        $I->seeResponseCodeIs('200');
        $I->seeResponseEquals('Hello!');
    }

    public function restoreExpectationAfterRewrite(AcceptanceTester $I)
    {
        $this->phiremock->reset();

        $expectation = PhiremockClient::on(
            A::getRequest()->andUrl(Is::equalTo('/hello'))
        )->then(
            Respond::withStatusCode(200)
            ->andBody('Bye!')
        )->setPriority(1);
        $this->phiremock->createExpectation($expectation);

        $I->sendGET('/hello');
        $I->seeResponseCodeIs('200');
        $I->seeResponseEquals('Bye!');

        $this->phiremock->reset();

        $I->sendGET('/hello');
        $I->seeResponseCodeIs('200');
        $I->seeResponseEquals('Hello!');
    }
}
