<?php

use Mcustiel\Phiremock\Client\Phiremock as PhiremockClient;
use Mcustiel\Phiremock\Client\Utils\A;
use Mcustiel\Phiremock\Client\Utils\Is;
use Mcustiel\Phiremock\Client\Utils\Respond;

class ReplacementCest
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

    public function createAnExpectationWithRegexReplacementFromUrl(AcceptanceTester $I)
    {
        $expectation = PhiremockClient::on(
            A::getRequest()->andUrl(Is::matching('/&test=(\d+)/'))
        )->then(
            Respond::withStatusCode(200)
            ->andBody('the number is ${url.1}')
        );
        $this->phiremock->createExpectation($expectation);

        $I->sendGET('/potato', ['param1' => 123, 'test' => 456]);
        $I->seeResponseCodeIs('200');
        $I->seeResponseEquals('the number is 456');
    }

    public function createAnExpectationWithRegexFromUrlAsGroupExpression(AcceptanceTester $I)
    {
        $expectation = PhiremockClient::on(
            A::getRequest()->andUrl(Is::matching('/&test=(\d+)/'))
        )->then(
            Respond::withStatusCode(200)
            ->andBody('the number is ${url.1.1}')
        );
        $this->phiremock->createExpectation($expectation);

        $I->sendGET('/potato', ['param1' => 123, 'test' => 456]);
        $I->seeResponseCodeIs('200');
        $I->seeResponseEquals('the number is 456');
    }

    public function createAnExpectationWithRegexReplacementFromBody(AcceptanceTester $I)
    {
        $expectation = PhiremockClient::on(
            A::postRequest()->andUrl(Is::equalTo('/potato'))
            ->andBody(Is::matching('/a tomato (\d+)/'))
        )->then(
            Respond::withStatusCode(200)
            ->andBody('the number is ${body.1}')
        );
        $this->phiremock->createExpectation($expectation);

        $I->sendPOST('/potato', 'this is a tomato 3kg it weights');
        $I->seeResponseCodeIs('200');
        $I->seeResponseEquals('the number is 3');
    }

    public function createAnExpectationWithRegexFromBodyAsGroupExpression(AcceptanceTester $I)
    {
        $expectation = PhiremockClient::on(
            A::postRequest()->andUrl(Is::equalTo('/potato'))
                ->andBody(Is::matching('/a tomato (\d+)/'))
        )->then(
            Respond::withStatusCode(200)
                ->andBody('the number is ${body.1.1}')
        );
        $this->phiremock->createExpectation($expectation);

        $I->sendPOST('/potato', 'this is a tomato 3kg it weights');
        $I->seeResponseCodeIs('200');
        $I->seeResponseEquals('the number is 3');
    }

    public function createAnExpectationWithRegexReplacementFromBodyAndUrl(AcceptanceTester $I)
    {
        $expectation = PhiremockClient::on(
            A::postRequest()->andUrl(Is::matching('/&test=(\d+)/'))
            ->andBody(Is::matching('/a tomato (\d+)/'))
        )->then(
            Respond::withStatusCode(200)
            ->andBody('the numbers are ${url.1} and ${body.1}')
        );
        $this->phiremock->createExpectation($expectation);

        $I->sendPOST('/potato?param1=123&test=456', 'this is a tomato 3kg it weights');
        $I->seeResponseCodeIs('200');
        $I->seeResponseEquals('the numbers are 456 and 3');
    }

    public function createAnExpectationWithRegexFromBodyAndUrlAsGroupExpression(AcceptanceTester $I)
    {
        $expectation = PhiremockClient::on(
            A::postRequest()->andUrl(Is::matching('/&test=(\d+)/'))
            ->andBody(Is::matching('/a tomato (\d+)/'))
        )->then(
            Respond::withStatusCode(200)
            ->andBody('the numbers are ${url.1.1} and ${body.1.1}')
        );
        $this->phiremock->createExpectation($expectation);

        $I->sendPOST('/potato?param1=123&test=456', 'this is a tomato 3kg it weights');
        $I->seeResponseCodeIs('200');
        $I->seeResponseEquals('the numbers are 456 and 3');
    }

    public function createAnExpectationWithStrictRegexReplacementFromBodyAndUrl(AcceptanceTester $I)
    {
        $expectation = PhiremockClient::on(
            A::postRequest()->andUrl(Is::matching('~^/potato/(\d+)$~'))
            ->andBody(Is::matching('/^this is a tomato (\d+)kg it weights$/'))
        )->then(
            Respond::withStatusCode(200)
            ->andBody('the numbers are ${url.1} and ${body.1}')
        );
        $this->phiremock->createExpectation($expectation);

        $I->sendPOST('/potato/456', 'this is a tomato 3kg it weights');
        $I->seeResponseCodeIs('200');
        $I->seeResponseEquals('the numbers are 456 and 3');
    }

    public function createAnExpectationWithStrictRegexFromBodyAndUrlAsGroupExpression(AcceptanceTester $I)
    {
        $expectation = PhiremockClient::on(
            A::postRequest()->andUrl(Is::matching('~^/potato/(\d+)$~'))
            ->andBody(Is::matching('/^this is a tomato (\d+)kg it weights$/'))
        )->then(
            Respond::withStatusCode(200)
            ->andBody('the numbers are ${url.1.1} and ${body.1.1}')
        );
        $this->phiremock->createExpectation($expectation);

        $I->sendPOST('/potato/456', 'this is a tomato 3kg it weights');
        $I->seeResponseCodeIs('200');
        $I->seeResponseEquals('the numbers are 456 and 3');
    }

    public function createAnExpectationWithoutRegexReplacement(AcceptanceTester $I)
    {
        $expectation = PhiremockClient::on(
            A::postRequest()->andUrl(Is::matching('/potato/'))
            ->andBody(Is::matching('/a tomato 3kg/'))
        )->then(
            Respond::withStatusCode(200)
            ->andBody('the numbers are ${url.1} and ${body.1.1}')
        );
        $this->phiremock->createExpectation($expectation);

        $I->sendPOST('/potato', 'this is a tomato 3kg it weights');
        $I->seeResponseCodeIs('200');
        $I->seeResponseEquals('the numbers are ${url.1} and ${body.1.1}');
    }

    public function createAnExpectationWithRegexMatchGroupsFromUrl(AcceptanceTester $I)
    {
        $expectation = PhiremockClient::on(
            A::getRequest()->andUrl(Is::matching('/[?&]\w*=(\d+)/'))
        )->then(
            Respond::withStatusCode(200)
                ->andBody('you birthday is at ${url.1.1}.${url.1.2}.${url.1.3}')
        );
        $this->phiremock->createExpectation($expectation);

        $I->sendGET('/birthday', ['day' => 28, 'month' => 10, 'year' => 1991]);
        $I->seeResponseCodeIs('200');
        $I->seeResponseEquals('you birthday is at 28.10.1991');
    }

    public function createAnExpectationWithRegexMatchGroupsFromBody(AcceptanceTester $I)
    {
        $request = '[{ "name": "Sarah", "alive": null }, { "name": "Ruth", "alive": true }]';

        $expectation = PhiremockClient::on(
            A::postRequest()->andUrl(Is::equalTo('/humans'))
                ->andBody(Is::matching('/"name":\s*"([^"]*)"/'))
        )->then(
            Respond::withStatusCode(200)
                ->andBody('first name is ${body.1.1}, second: ${body.1.2}')
        );
        $this->phiremock->createExpectation($expectation);

        $I->sendPOST('/humans', $request);
        $I->seeResponseCodeIs('200');
        $I->seeResponseEquals('first name is Sarah, second: Ruth');
    }

    public function createAnExpectationWithRegexMatchGroupsFromBodyAndUrl(AcceptanceTester $I)
    {
        $request = '[{ "name": "Sarah", "alive": null }, { "name": "Ruth", "alive": true }]';

        $responseBody = 'You created two ${url.1.2}s with a min age of ${url.1.1}.' .
         'The first name is ${body.1.2}, second: ${body.1.1}';
        $expectation = PhiremockClient::on(
            A::postRequest()->andUrl(Is::matching('%[?&]\w*=(\w+)%'))
                ->andBody(Is::matching('/"name":\s*"([^"]*)"/'))
        )->then(
            Respond::withStatusCode(200)
                ->andBody($responseBody)
        );
        $this->phiremock->createExpectation($expectation);

        $I->sendPOST('/humans?minage=22&gender=female', $request);
        $I->seeResponseCodeIs('200');
        $I->seeResponseEquals('You created two females with a min age of 22.' .
            'The first name is Ruth, second: Sarah');
    }

    public function createAnExpectationWithRegexMultipleMatchGroupsFromBody(AcceptanceTester $I)
    {
        $request = '[ { "name": "Sarah", "brothers": 0 },'
            . ' { "name": "Ruth", "brothers": 2 },'
            . ' { "name": "Lexi", "brothers": 23 } ]';
        $matcher = '%"name"\s*:\s*"([^"]*)",\s*"brothers"\s*:\s*(\d+)%';

        $response = '${body.1} has ${body.2} brothers, ${body.1.2} has ${body.2.2} brothers,'
            . ' ${body.1.3} has ${body.2.3} brothers';
        $expectation = PhiremockClient::on(
            A::postRequest()->andUrl(Is::equalTo('/humans'))
                ->andBody(Is::matching($matcher))
        )->then(
            Respond::withStatusCode(200)
                ->andBody($response)
        );
        $this->phiremock->createExpectation($expectation);

        $I->sendPOST('/humans', $request);

        $expectedResponse = 'Sarah has 0 brothers, Ruth has 2 brothers, Lexi has 23 brothers';
        $I->seeResponseCodeIs('200');
        $I->seeResponseEquals($expectedResponse);
    }

    public function createAnExpectationWithoutRegexMatchGroups(AcceptanceTester $I)
    {
        $body = 'the numbers are ${url.1} or ${url.1.2} or ${url.1.1} and the ${body.1.1} or ${body.3.2}';
        $expectation = PhiremockClient::on(
            A::postRequest()->andUrl(Is::matching('/potato/'))
                ->andBody(Is::matching('/a tomato 3kg/'))
        )->then(
            Respond::withStatusCode(200)
                ->andBody($body)
        );
        $this->phiremock->createExpectation($expectation);

        $I->sendPOST('/potato', 'this is a tomato 3kg it weights');
        $I->seeResponseCodeIs('200');
        $I->seeResponseEquals($body);
    }
}
