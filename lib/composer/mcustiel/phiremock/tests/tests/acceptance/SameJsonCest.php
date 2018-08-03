<?php

use Mcustiel\Phiremock\Client\Phiremock as PhiremockClient;
use Mcustiel\Phiremock\Client\Utils\A;
use Mcustiel\Phiremock\Client\Utils\Is;
use Mcustiel\Phiremock\Client\Utils\Respond;
use Mcustiel\Phiremock\Domain\Condition;
use Mcustiel\Phiremock\Domain\Expectation;
use Mcustiel\Phiremock\Domain\Request;
use Mcustiel\Phiremock\Domain\Response;

class SameJsonCest
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

    // tests
    public function shouldCompareJsonEvenIfStringsDiffer(AcceptanceTester $I)
    {
        $expectation = new Expectation();

        $request = new Request();
        $request->setMethod('post');
        $request->setUrl(new Condition('isEqualTo', '/test-json'));
        $request->setBody(
            new Condition(
                'isSameJsonObject',
                '{"tomato": "potato", "a": 1, "b": null, "recursive": {"a": "b", "array": [{"c": "d"}, "e"]}}'
            )
        );

        $response = new Response();
        $response->setStatusCode(200);
        $response->setBody('It is the same');

        $expectation->setRequest($request)->setResponse($response);
        $this->phiremock->createExpectation($expectation);

        $I->sendPOST('/test-json', '{"tomato" : "potato",   "a":1,    "b": null, "recursive": {   "a": "b", "array" : [ {"c":"d" }, "e" ] } }');
        $I->seeResponseCodeIs(200);
        $responseBody = $I->grabResponse();
        $I->assertEquals('It is the same', $responseBody);
    }

    public function shouldCompareJsonAndDetectTheyAreTheSameWhenFieldsOrderedDifferent(AcceptanceTester $I)
    {
        $expectation = new Expectation();

        $request = new Request();
        $request->setMethod('post');
        $request->setUrl(new Condition('isEqualTo', '/test-json'));
        $request->setBody(
            new Condition(
                'isSameJsonObject',
                '{"tomato": "potato", "a": 1, "b": null, "recursive": {"a": "b", "array": [{"c": "d"}, "e"]}}'
            )
        );

        $response = new Response();
        $response->setStatusCode(200);
        $response->setBody('It is the same');

        $expectation->setRequest($request)->setResponse($response);
        $this->phiremock->createExpectation($expectation);

        $I->sendPOST('/test-json', '{"b": null, "a":1,    "recursive": {   "array" : [ {"c":"d" }, "e" ], "a": "b" }, "tomato" : "potato" }');
        $I->seeResponseCodeIs(200);
        $responseBody = $I->grabResponse();
        $I->assertEquals('It is the same', $responseBody);
    }

    public function shouldCompareJsonAndDetectTheyAreNotTheSame(AcceptanceTester $I)
    {
        $expectation = new Expectation();

        $request = new Request();
        $request->setMethod('post');
        $request->setUrl(new Condition('isEqualTo', '/test-json'));
        $request->setBody(
            new Condition(
                'isSameJsonObject',
                '{"tomato": "potato", "a": 1, "b": null, "recursive": {"a": "b", "array": [{"c": "d"}, "e"]}}'
                )
            );

        $response = new Response();
        $response->setStatusCode(200);
        $response->setBody('It is the same');

        $expectation->setRequest($request)->setResponse($response);
        $this->phiremock->createExpectation($expectation);

        $I->sendPOST('/test-json', '{"tomato": "potato", "a": 1, "b": 0, "recursive": {"a": "b", "array": [{"c": "d"}, "e"]}}');
        $I->seeResponseCodeIs(404);
    }

    // From issue #38
    public function shouldDetectTheyAreNotTheSame(AcceptanceTester $I)
    {
        $expectation = new Expectation();

        $request = new Request();
        $request->setMethod('post');
        $request->setUrl(new Condition('isEqualTo', '/test-json'));
        $request->setBody(
            new Condition(
                'isSameJsonObject',
                '{ "foo": "1", "bar": "2"}'
            )
        );

        $response = new Response();
        $response->setStatusCode(200);
        $response->setBody('It is the same');

        $expectation->setRequest($request)->setResponse($response);
        $this->phiremock->createExpectation($expectation);

        $I->sendPOST('/test-json', '{ "foo": "1"}');
        $I->seeResponseCodeIs(404);
    }

    public function shouldWorkCorrectlyUsingTheFluentInterfaceAndAString(AcceptanceTester $I)
    {
        $expectation = PhiremockClient::on(
            A::postRequest()->andUrl(Is::equalTo('/test-json-object'))
                ->andBody(
                    Is::sameJsonObjectAs(
                        '{"tomato": "potato", "a": 1, "b": null, "recursive": {"a": "b", "array": [{"c": "d"}, "e"]}}'
                    )
                )
            )->then(Respond::withStatusCode(200)->andBody('It is the same'));

        $this->phiremock->createExpectation($expectation);

        $I->sendPOST('/test-json-object', '{"tomato" : "potato",   "a":1,    "b": null, "recursive": {   "a": "b", "array" : [ {"c":"d" }, "e" ] } }');
        $I->seeResponseCodeIs(200);
        $responseBody = $I->grabResponse();
        $I->assertEquals('It is the same', $responseBody);
    }

    public function shouldWorkCorrectlyUsingTheFluentInterfaceAndAJsonSerializable(AcceptanceTester $I)
    {
        $expectation = PhiremockClient::on(
            A::postRequest()->andUrl(Is::equalTo('/test-json-object'))
                ->andBody(
                    Is::sameJsonObjectAs(
                        [
                            'tomato'    => 'potato',
                            'a'         => 1,
                            'b'         => null,
                            'recursive' => [
                                'a'     => 'b',
                                'array' => [
                                    ['c' => 'd'],
                                    'e',
                                ],
                            ],
                        ]
                    )
                )
            )->then(Respond::withStatusCode(200)->andBody('It is the same'));

        $this->phiremock->createExpectation($expectation);

        $I->sendPOST(
            '/test-json-object',
            '{"tomato":"potato","a":1,"b":null,"recursive":{"a":"b", "array": [ {"c":"d"}, "e" ]}}'
        );

        $I->seeResponseCodeIs(200);
        $responseBody = $I->grabResponse();
        $I->assertEquals('It is the same', $responseBody);
    }

    public function shouldFailIfConfiguredWithInvalidJson(AcceptanceTester $I)
    {
        $expectation = PhiremockClient::on(
            A::postRequest()->andUrl(Is::equalTo('/test-json-object'))
                ->andBody(
                    Is::sameJsonObjectAs(
                        'I, am an invalid - json. string.'
                    )
                )
        )->then(Respond::withStatusCode(200)->andBody('It is the same'));

        $this->phiremock->createExpectation($expectation);

        $I->sendPOST(
            '/test-json-object',
            '{"tomato":"potato","a":1,"b":null,"recursive":{"a":"b", "array": [ {"c":"d"}, "e" ]}}'
        );

        $I->seeResponseCodeIs(500);
        $responseBody = $I->grabResponse();
        $I->assertStringStartsWith('JSON parsing error: ', $responseBody);
    }

    public function shouldNotFailIfReceivesInvalidJsonInRequest(AcceptanceTester $I)
    {
        $expectation = PhiremockClient::on(
            A::postRequest()->andUrl(Is::equalTo('/test-json-object'))
                ->andBody(
                    Is::sameJsonObjectAs(
                        [
                            'tomato'    => 'potato',
                            'a'         => 1,
                            'b'         => null,
                            'recursive' => [
                                'a'     => 'b',
                                'array' => [
                                    ['c' => 'd'],
                                    'e',
                                ],
                            ],
                        ]
                    )
                )
        )->then(Respond::withStatusCode(200)->andBody('It is the same'));

        $this->phiremock->createExpectation($expectation);

        $I->sendPOST(
            '/test-json-object',
            'I, am an invalid - json. string.'
        );

        $I->seeResponseCodeIs(404);
    }
}
