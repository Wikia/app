<?php

use Mcustiel\Phiremock\Domain\Condition;
use Mcustiel\Phiremock\Domain\Expectation;
use Mcustiel\Phiremock\Domain\Request;
use Mcustiel\Phiremock\Domain\Response;

class BodyJsonCest
{
    public function _before(AcceptanceTester $I)
    {
        $I->sendDELETE('/__phiremock/expectations');
    }

    public function createExpectationWithBodyJsonArrayTest(AcceptanceTester $I)
    {
        $I->wantTo('create an expectation with a JSON body defined as array');
        $request = new Request();
        $request->setUrl(new Condition('isEqualTo', '/the/request/url'));
        $response = new Response();
        $response->setBody(['foo' => 'bar']);
        $expectation = new Expectation();
        $expectation->setRequest($request)->setResponse($response);
        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->sendPOST('/__phiremock/expectations', $expectation);
        $I->seeResponseCodeIs('201');

        $I->sendGET('/__phiremock/expectations');
        $I->seeResponseCodeIs('200');
        $I->seeResponseIsJson();
        $I->seeResponseEquals(
            '[{"scenarioName":null,"scenarioStateIs":null,"newScenarioState":null,'
            . '"request":{"method":null,"url":{"isEqualTo":"\/the\/request\/url"},"body":null,"headers":null},'
            . '"response":{"statusCode":200,"body":"{\"foo\":\"bar\"}","headers":null,"delayMillis":null},'
            . '"proxyTo":null,"priority":0}]'
        );
    }

    public function createExpectationWithBodyJsonObjectTest(AcceptanceTester $I)
    {
        $I->wantTo('create an expectation with a JSON body defined as object');
        $request = new Request();
        $request->setUrl(new Condition('isEqualTo', '/the/request/url'));
        $response = new Response();
        $response->setBody((object) ['foo' => 'bar']);
        $expectation = new Expectation();
        $expectation->setRequest($request)->setResponse($response);
        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->sendPOST('/__phiremock/expectations', $expectation);
        $I->seeResponseCodeIs('201');

        $I->sendGET('/__phiremock/expectations');
        $I->seeResponseCodeIs('200');
        $I->seeResponseIsJson();
        $I->seeResponseEquals(
            '[{"scenarioName":null,"scenarioStateIs":null,"newScenarioState":null,'
            . '"request":{"method":null,"url":{"isEqualTo":"\/the\/request\/url"},"body":null,"headers":null},'
            . '"response":{"statusCode":200,"body":"{\"foo\":\"bar\"}","headers":null,"delayMillis":null},'
            . '"proxyTo":null,"priority":0}]'
        );
    }
}
