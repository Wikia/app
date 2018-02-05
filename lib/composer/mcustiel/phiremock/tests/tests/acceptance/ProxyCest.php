<?php

use Mcustiel\Phiremock\Client\Phiremock as PhiremockClient;
use Mcustiel\Phiremock\Client\Utils\A;
use Mcustiel\Phiremock\Client\Utils\Is;

class ProxyCest
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

    public function _after(AcceptanceTester $I)
    {
    }

    public function createAnExpectationWithProxyToTest(AcceptanceTester $I)
    {
        $expectation = PhiremockClient::on(
                A::postRequest()->andUrl(Is::equalTo('/potato'))
                ->andHeader('X-Potato', Is::sameStringAs('bAnaNa'))
                ->andScenarioState('PotatoScenario', 'Scenario.START')
                ->andBody(Is::equalTo('{"key": "This is the body"}'))
            )->proxyTo('https://es.wikipedia.org/wiki/Proxy');
        $this->phiremock->createExpectation($expectation);

        $I->sendGET('/__phiremock/expectations');
        $I->seeResponseCodeIs('200');
        $I->seeResponseIsJson();
        $I->seeResponseEquals(
            '[{"scenarioName":"PotatoScenario","scenarioStateIs":"Scenario.START",'
            . '"newScenarioState":null,"request":{"method":"post","url":{"isEqualTo":"\/potato"},'
            . '"body":{"isEqualTo":"{\"key\": \"This is the body\"}"},"headers":{"X-Potato":'
            . '{"isSameString":"bAnaNa"}}},"response":{"statusCode":200,"body":null,"headers":'
            . 'null,"delayMillis":null},'
            . '"proxyTo":"https:\/\/es.wikipedia.org\/wiki\/Proxy","priority":0}]'
        );
    }

    public function proxyToGivenUriTest(AcceptanceTester $I)
    {
        $expectation = PhiremockClient::on(
            A::getRequest()->andUrl(Is::equalTo('/potato'))
                ->andHeader('X-Potato', Is::sameStringAs('bAnaNa'))
                ->andScenarioState('PotatoScenario', 'Scenario.START')
            )->proxyTo('https://es.wikipedia.org/wiki/Proxy');
        $this->phiremock->createExpectation($expectation);

        $guzzle = new GuzzleHttp\Client();
        $originalBody = $guzzle->get('https://es.wikipedia.org/wiki/Proxy')->getBody();

        $I->haveHttpHeader('X-Potato', 'banana');
        $I->sendGet('/potato');
        $I->seeResponseEquals($originalBody);
    }
}
