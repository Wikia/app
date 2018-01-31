<?php

use Mcustiel\Phiremock\Domain\Condition;
use Mcustiel\Phiremock\Domain\Expectation;
use Mcustiel\Phiremock\Domain\Request;
use Mcustiel\Phiremock\Domain\Response;

class HeadersConditionsCest
{
    public function _before(AcceptanceTester $I)
    {
        $I->sendDELETE('/__phiremock/expectations');
    }

    public function _after(AcceptanceTester $I)
    {
    }

    public function creationWithOneHeaderUsingEqualToTest(AcceptanceTester $I)
    {
        $I->wantTo('create an expectation that checks one header using isEqualTo');
        $request = new Request();
        $request->setHeaders([
            'Content-Type' => new Condition('isEqualTo', 'application/x-www-form-urlencoded'),
        ]);
        $response = new Response();
        $response->setStatusCode(201);
        $expectation = new Expectation();
        $expectation->setRequest($request)->setResponse($response);
        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->sendPOST('/__phiremock/expectations', $expectation);

        $I->sendGET('/__phiremock/expectations');
        $I->seeResponseCodeIs('200');
        $I->seeResponseIsJson();
        $I->seeResponseEquals(
            '[{"scenarioName":null,"scenarioStateIs":null,"newScenarioState":null,'
            . '"request":{"method":null,"url":null,"body":null,"headers":{"Content-Type":{"isEqualTo":"application\/x-www-form-urlencoded"}}},'
            . '"response":{"statusCode":201,"body":null,"headers":null,"delayMillis":null},'
            . '"proxyTo":null,"priority":0}]'
        );
    }

    public function creationWithOneHeaderUsingMatchesTest(AcceptanceTester $I)
    {
        $I->wantTo('create an expectation that checks one header using matches');
        $request = new Request();
        $request->setHeaders([
            'Content-Type' => new Condition('matches', '/application/'),
        ]);
        $response = new Response();
        $response->setStatusCode(201);
        $expectation = new Expectation();
        $expectation->setRequest($request)->setResponse($response);
        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->sendPOST('/__phiremock/expectations', $expectation);

        $I->sendGET('/__phiremock/expectations');
        $I->seeResponseCodeIs('200');
        $I->seeResponseIsJson();
        $I->seeResponseEquals(
            '[{"scenarioName":null,"scenarioStateIs":null,"newScenarioState":null,'
            . '"request":{"method":null,"url":null,"body":null,"headers":{"Content-Type":{"matches":"\/application\/"}}},'
            . '"response":{"statusCode":201,"body":null,"headers":null,"delayMillis":null},'
            . '"proxyTo":null,"priority":0}]'
        );
    }

    public function failWhenUsingInvalidMatcherTest(AcceptanceTester $I)
    {
        $I->wantTo('fail when the matcher is invalid');
        $request = new Request();
        $request->setHeaders([
            'Content-Type' => new Condition('potato', '/application/'),
        ]);
        $response = new Response();
        $response->setStatusCode(201);
        $expectation = new Expectation();
        $expectation->setRequest($request)->setResponse($response);
        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->sendPOST('/__phiremock/expectations', $expectation);

        $I->seeResponseCodeIs(500);
        $I->seeResponseIsJson();
        $I->seeResponseEquals('{"result" : "ERROR", "details" : ["Invalid condition matcher specified: potato"]}');
    }

    public function failWhenUsingNullValueTest(AcceptanceTester $I)
    {
        $I->wantTo('fail when the value is null');
        $request = new Request();
        $request->setHeaders([
            'Content-Type' => new Condition('matches', null),
        ]);
        $response = new Response();
        $response->setStatusCode(201);
        $expectation = new Expectation();
        $expectation->setRequest($request)->setResponse($response);
        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->sendPOST('/__phiremock/expectations', $expectation);

        $I->seeResponseCodeIs(500);
        $I->seeResponseIsJson();
        $I->seeResponseEquals('{"result" : "ERROR", "details" : ["Condition value can not be null"]}');
    }

    public function creationWithMoreThanOneHeaderConditionTest(AcceptanceTester $I)
    {
        $I->wantTo('create an expectation that checks more than one header');
        $request = new Request();
        $request->setHeaders([
            'Content-Type'     => new Condition('matches', '/application/'),
            'Content-Length'   => new Condition('isEqualTo', '25611'),
            'Content-Encoding' => new Condition('isEqualTo', 'gzip'),
        ]);
        $response = new Response();
        $response->setStatusCode(201);
        $expectation = new Expectation();
        $expectation->setRequest($request)->setResponse($response);
        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->sendPOST('/__phiremock/expectations', $expectation);

        $I->sendGET('/__phiremock/expectations');
        $I->seeResponseCodeIs('200');
        $I->seeResponseIsJson();
        $I->seeResponseEquals(
            '[{"scenarioName":null,"scenarioStateIs":null,"newScenarioState":null,'
            . '"request":{"method":null,"url":null,"body":null,"headers":{'
            . '"Content-Type":{"matches":"\/application\/"},'
            . '"Content-Length":{"isEqualTo":"25611"},'
            . '"Content-Encoding":{"isEqualTo":"gzip"}}},'
            . '"response":{"statusCode":201,"body":null,"headers":null,"delayMillis":null},'
            . '"proxyTo":null,"priority":0}]'
        );
    }

    public function responseExpectedWhenRequestOneHeaderMatchesTest(AcceptanceTester $I)
    {
        $I->wantTo('see if mocking based in one request header works');
        $request = new Request();
        $request->setHeaders([
            'Content-type' => new Condition('isEqualTo', 'application/x-www-form-urlencoded'),
        ]);
        $response = new Response();
        $response->setBody('Found');
        $expectation = new Expectation();
        $expectation->setRequest($request)->setResponse($response);

        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->sendPOST('/__phiremock/expectations', $expectation);

        $I->seeResponseCodeIs(201);
        $I->haveHttpHeader('Content-Type', 'application/x-www-form-urlencoded');
        $I->sendGET('/dontcare');

        $I->seeResponseCodeIs(200);
        $I->seeResponseEquals('Found');
    }

    public function responseExpectedWhenSeveralHeadersMatchesTest(AcceptanceTester $I)
    {
        $I->wantTo('see if mocking based in several request headers works');
        $request = new Request();
        $request->setHeaders([
            'Content-type' => new Condition('isEqualTo', 'application/x-www-form-urlencoded'),
            'X-Potato'     => new Condition('matches', '/.*tomato.*/'),
            'X-Tomato'     => new Condition('isSameString', 'PoTaTo'),
        ]);
        $response = new Response();
        $response->setBody('Found');
        $expectation = new Expectation();
        $expectation->setRequest($request)->setResponse($response);

        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->sendPOST('/__phiremock/expectations', $expectation);

        $I->seeResponseCodeIs(201);

        $I->haveHttpHeader('Content-Type', 'application/x-www-form-urlencoded');
        $I->sendGET('/dontcare');

        $I->seeResponseCodeIs(404);

        $I->haveHttpHeader('Content-Type', 'application/x-www-form-urlencoded');
        $I->haveHttpHeader('X-potato', 'a-tomato-0');
        $I->haveHttpHeader('X-tomato', 'potato');
        $I->sendGET('/dontcare');

        $I->seeResponseEquals('Found');
    }
}
