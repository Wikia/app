<?php

use Mcustiel\Phiremock\Domain\Condition;
use Mcustiel\Phiremock\Domain\Expectation;
use Mcustiel\Phiremock\Domain\Request;
use Mcustiel\Phiremock\Domain\Response;

class ExpectationCreationCest
{
    public function _before(AcceptanceTester $I)
    {
        $I->sendDELETE('/__phiremock/expectations');
    }

    public function _after(AcceptanceTester $I)
    {
    }

    public function creationWithOnlyValidUrlConditionTest(AcceptanceTester $I)
    {
        $I->wantTo('create an expectation that only checks url');
        $request = new Request();
        $request->setUrl(new Condition('isEqualTo', '/the/request/url'));
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
            . '"request":{"method":null,"url":{"isEqualTo":"\/the\/request\/url"},"body":null,"headers":null},'
            . '"response":{"statusCode":201,"body":null,"headers":null,"delayMillis":null},'
            . '"proxyTo":null,"priority":0}]'
        );
    }

    public function creationWithOnlyValidMethodConditionTest(AcceptanceTester $I)
    {
        $I->wantTo('create an expectation that only checks method');
        $request = new Request();
        $request->setMethod('post');
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
            . '"request":{"method":"post","url":null,"body":null,"headers":null},'
            . '"response":{"statusCode":201,"body":null,"headers":null,"delayMillis":null},'
            . '"proxyTo":null,"priority":0}]'
        );
    }

    public function creationWithOnlyValidBodyConditionTest(AcceptanceTester $I)
    {
        $I->wantTo('create an expectation that only checks body');
        $request = new Request();
        $request->setBody(new Condition('matches', 'potato'));
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
            . '"request":{"method":null,"url":null,"body":{"matches":"potato"},"headers":null},'
            . '"response":{"statusCode":201,"body":null,"headers":null,"delayMillis":null},'
            . '"proxyTo":null,"priority":0}]'
        );
    }

    public function creationWithOnlyValidHeadersConditionTest(AcceptanceTester $I)
    {
        $I->wantTo('create an expectation that only checks headers');
        $request = new Request();
        $request->setHeaders(['Accept' => new Condition('matches', 'potato')]);
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
            . '"request":{"method":null,"url":null,"body":null,"headers":{"Accept":{"matches":"potato"}}},'
            . '"response":{"statusCode":201,"body":null,"headers":null,"delayMillis":null},'
            . '"proxyTo":null,"priority":0}]'
        );
    }

    public function creationFailWhenEmptyRequestTest(AcceptanceTester $I)
    {
        $I->wantTo('See if creation fails when request is empty');
        $response = new Response();
        $response->setStatusCode(201);
        $expectation = new Expectation();
        $expectation->setResponse($response);
        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->sendPOST('/__phiremock/expectations', $expectation);

        $I->seeResponseCodeIs('500');
        $I->seeResponseIsJson();
        $I->seeResponseEquals(
            '{"result" : "ERROR", "details" : {"request":"Field request, was set with invalid value: NULL"}}'
        );
    }

    public function useDefaultWhenEmptyResponseTest(AcceptanceTester $I)
    {
        $I->wantTo('When response is empty in request, default should be used');
        $request = new Request();
        $request->setMethod('get');

        $expectation = new Expectation();
        $expectation->setRequest($request);
        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->sendPOST('/__phiremock/expectations', $expectation);
        $I->seeResponseCodeIs('201');

        $I->sendGET('/__phiremock/expectations');
        $I->seeResponseCodeIs('200');
        $I->seeResponseIsJson();
        $I->seeResponseEquals(
            '[{"scenarioName":null,"scenarioStateIs":null,"newScenarioState":null,'
            . '"request":{"method":"get","url":null,"body":null,"headers":null},'
            . '"response":{"statusCode":200,"body":null,"headers":null,"delayMillis":null},'
            . '"proxyTo":null,"priority":0}]'
            );
    }

    public function creationFailWhenAnythingSentAsRequestTest(AcceptanceTester $I)
    {
        $I->wantTo('See if creation fails when anything sent as request');

        $expectation = [
            'response' => ['statusCode' => 200],
            'request'  => ['potato' => 'tomato'],
        ];

        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->sendPOST('/__phiremock/expectations', $expectation);

        $I->seeResponseCodeIs('500');
        $I->seeResponseIsJson();
        $I->seeResponseEquals('{"result" : "ERROR", "details" : ["Invalid request specified in expectation"]}');
    }

    public function creationFailWhenAnythingSentAsResponseTest(AcceptanceTester $I)
    {
        $I->wantTo('See if creation fails when anything sent as response');

        $expectation = [
            'response' => 'response',
            'request'  => ['url' => ['isEqualTo' => '/tomato']],
        ];

        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->sendPOST('/__phiremock/expectations', $expectation);

        $I->seeResponseCodeIs('500');
        $I->seeResponseIsJson();
        $I->seeResponseEquals(
            '{"result" : "ERROR", "details" : {"response":"Request builder is intended to be used with arrays or instances of \\\\stdClass"}}'
        );
    }

    public function creationWithAllOptionsFilledTest(AcceptanceTester $I)
    {
        $I->wantTo('create an expectation with all possible option filled');
        $request = (new Request())
            ->setUrl(new Condition('isEqualTo', '/the/request/url'))
            ->setBody(new Condition('isEqualTo', 'the body'))
            ->setMethod('get')
            ->setHeaders([
                'Content-Type'         => new Condition('matches', '/json/'),
                'Accepts'              => new Condition('isEqualTo', 'application/json'),
                'X-Some-Random-Header' => new Condition('isEqualTo', 'random value'),
            ]);

        $response = (new Response())
            ->setStatusCode(201)
            ->setBody('Response body')
            ->setDelayMillis(5000)
            ->setHeaders([
                'X-Special-Header' => 'potato',
                'Location'         => 'href://potato.tmt',
            ]);

        $expectation = (new Expectation())
            ->setRequest($request)
            ->setResponse($response)
            ->setScenarioName('potato')
            ->setScenarioStateIs('tomato')
            ->setNewScenarioState('banana')
            ->setPriority(3);

        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->sendPOST('/__phiremock/expectations', $expectation);

        $I->sendGET('/__phiremock/expectations');
        $I->seeResponseCodeIs('200');
        $I->seeResponseIsJson();
        $I->seeResponseEquals(
            '[{"scenarioName":"potato","scenarioStateIs":"tomato","newScenarioState":"banana",'
            . '"request":{'
            . '"method":"get","url":{"isEqualTo":"\/the\/request\/url"},'
            . '"body":{"isEqualTo":"the body"},'
            . '"headers":{'
            . '"Content-Type":{"matches":"\/json\/"},'
            . '"Accepts":{"isEqualTo":"application\/json"},'
            . '"X-Some-Random-Header":{"isEqualTo":"random value"}}},'
            . '"response":{'
            . '"statusCode":201,"body":"Response body","headers":{'
            . '"X-Special-Header":"potato",'
            . '"Location":"href:\/\/potato.tmt"},'
            . '"delayMillis":5000},'
            . '"proxyTo":null,"priority":3}]'
        );
    }
}
