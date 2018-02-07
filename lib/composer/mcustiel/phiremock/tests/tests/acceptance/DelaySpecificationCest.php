<?php

use Mcustiel\Phiremock\Domain\Condition;
use Mcustiel\Phiremock\Domain\Expectation;
use Mcustiel\Phiremock\Domain\Request;
use Mcustiel\Phiremock\Domain\Response;

class DelaySpecificationCest
{
    public function _before(AcceptanceTester $I)
    {
        $I->sendDELETE('/__phiremock/expectations');
    }

    public function _after(AcceptanceTester $I)
    {
    }

    // tests
    public function createExpectationWhithValidDelayTest(AcceptanceTester $I)
    {
        $I->wantTo('create an expectation with a valid delay specification');
        $request = new Request();
        $request->setUrl(new Condition('isEqualTo', '/the/request/url'));
        $response = new Response();
        $response->setDelayMillis(5000);
        $expectation = new Expectation();
        $expectation->setRequest($request)->setResponse($response);
        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->sendPOST('/__phiremock/expectations', $expectation);

        $I->sendGET('/__phiremock/expectations');
        $I->seeResponseCodeIs('200');
        $I->seeResponseIsJson();
        $I->seeResponseEquals(
            '[{"scenarioName":null,"scenarioStateIs":null,"newScenarioState":null,'
            . '"request":{"method":null,"url":{"isEqualTo":"\/the\/request\/url"},"body":null,"headers":null},'
            . '"response":{"statusCode":200,"body":null,"headers":null,"delayMillis":5000},'
            . '"proxyTo":null,"priority":0}]'
        );
    }

    // tests
    public function failWhithNegativedDelayTest(AcceptanceTester $I)
    {
        $I->wantTo('create an expectation with a negative delay specification');
        $request = new Request();
        $request->setUrl(new Condition('isEqualTo', '/the/request/url'));
        $response = new Response();
        $response->setDelayMillis(-5000);
        $expectation = new Expectation();
        $expectation->setRequest($request)->setResponse($response);
        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->sendPOST('/__phiremock/expectations', $expectation);

        $I->seeResponseCodeIs('500');
        $I->seeResponseIsJson();
        $I->seeResponseEquals(
            '{"result" : "ERROR", "details" : '
            . '{"response":"delayMillis: Field delayMillis, '
            . 'was set with invalid value: -5000"}}'
        );
    }

    // tests
    public function failWhithInvalidDelayTest(AcceptanceTester $I)
    {
        $I->wantTo('create an expectation with an invalid delay specification');
        $request = new Request();
        $request->setUrl(new Condition('isEqualTo', '/the/request/url'));
        $response = new Response();
        $response->setDelayMillis('potato');
        $expectation = new Expectation();
        $expectation->setRequest($request)->setResponse($response);
        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->sendPOST('/__phiremock/expectations', $expectation);

        $I->seeResponseCodeIs('500');
        $I->seeResponseIsJson();
        $I->seeResponseEquals(
            '{"result" : "ERROR", "details" : '
            . '{"response":"delayMillis: Field delayMillis, '
            . 'was set with invalid value: \'potato\'"}}'
        );
    }

    // tests
    public function mockRequestWithDelayTest(AcceptanceTester $I)
    {
        $I->wantTo('mock a request with delay');
        $request = new Request();
        $request->setUrl(new Condition('isEqualTo', '/the/request/url'))
            ->setMethod('GET');
        $response = new Response();
        $response->setDelayMillis(2000);
        $expectation = new Expectation();
        $expectation->setRequest($request)->setResponse($response);
        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->sendPOST('/__phiremock/expectations', $expectation);

        $I->seeResponseCodeIs(201);

        $start = microtime(true);
        $I->sendGET('/the/request/url');
        $I->seeResponseCodeIs(200);
        $I->assertGreaterThan(2000, (microtime(true) - $start) * 1000);
    }
}
