<?php

use Mcustiel\Phiremock\Client\Phiremock as PhiremockClient;
use Mcustiel\Phiremock\Client\Utils\A;
use Mcustiel\Phiremock\Client\Utils\Is;
use Mcustiel\Phiremock\Client\Utils\Respond;
use Mcustiel\Phiremock\Domain\ScenarioState;

class SetScenarioStateCest
{
    /**
     * @var \Mcustiel\Phiremock\Client\Phiremock
     */
    private $phiremock;

    public function _before(AcceptanceTester $I)
    {
        $I->sendDELETE('/__phiremock/expectations');
        $this->phiremock = new PhiremockClient('127.0.0.1', '8086');
    }

    public function setScenarioState(AcceptanceTester $I)
    {
        $expectation = PhiremockClient::on(
            A::getRequest()->andUrl(Is::equalTo('/test'))
        )->then(
            Respond::withStatusCode(200)
            ->andBody('start')
        )->setScenarioName(
            'test-scenario'
        )->setScenarioStateIs(
            'Scenario.START'
        );
        $this->phiremock->createExpectation($expectation);

        $expectation = PhiremockClient::on(
            A::getRequest()->andUrl(Is::equalTo('/test'))
        )->then(
            Respond::withStatusCode(200)
            ->andBody('potato')
        )->setScenarioName(
            'test-scenario'
        )->setScenarioStateIs(
            'Scenario.POTATO'
        );
        $this->phiremock->createExpectation($expectation);

        $scenarioState = new ScenarioState('test-scenario', 'Scenario.POTATO');
        $this->phiremock->setScenarioState($scenarioState);
        $I->sendGET('/test');
        $I->seeResponseCodeIs('200');
        $I->seeResponseEquals('potato');

        $scenarioState = new ScenarioState('test-scenario', 'Scenario.START');

        $this->phiremock->setScenarioState($scenarioState);
        $I->sendGET('/test');
        $I->seeResponseCodeIs('200');
        $I->seeResponseEquals('start');
    }

    public function checkScenarioStateValidation(AcceptanceTester $I)
    {
        $scenarioState = new ScenarioState();

        try {
            $this->phiremock->setScenarioState($scenarioState);
        } catch (\RuntimeException $e) {
            $I->assertNotEmpty($e);
            $I->assertContains('Field scenarioName, was set with invalid value', $e->getMessage());
            $I->assertContains('Field scenarioState, was set with invalid value', $e->getMessage());
        }
    }
}
