<?php
/**
 * This file is part of php-simple-request.
 *
 * php-simple-request is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Lesser General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * php-simple-request is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with php-simple-request.  If not, see <http://www.gnu.org/licenses/>.
 */
namespace Integration;

use Fixtures\PersonRequest;
use Fixtures\AllValidatorsRequest;
use Mcustiel\SimpleRequest\Exception\InvalidRequestException;
use Fixtures\CoupleRequest;
use Mcustiel\SimpleRequest\FirstErrorRequestParser;
use Mcustiel\SimpleRequest\RequestBuilder;

class RequestBuilderWithStdClassTest extends TestRequestBuilder
{
    public function testBuildARequestAndFilter()
    {
        $request = $this->getValidPersonRequest();

        $parserResponse = $this->builderWithoutCache->parseRequest(
            $request,
            PersonRequest::class,
            RequestBuilder::RETURN_ALL_ERRORS_IN_EXCEPTION
        );
        $this->assertPersonIsOk($parserResponse);
    }

    public function testBuildARequestAndFilterWithCacheEnabled()
    {
        $request = $this->getValidPersonRequest();

        $parserResponse = $this->builderWithCache->parseRequest(
            $request,
            PersonRequest::class,
            RequestBuilder::RETURN_ALL_ERRORS_IN_EXCEPTION
        );
        $this->assertPersonIsOk($parserResponse);

        $builderCached = $this->createCachedRequestBuilder();
        $parserResponse = $builderCached->parseRequest(
            $request,
            PersonRequest::class,
            RequestBuilder::RETURN_ALL_ERRORS_IN_EXCEPTION
        );
        $this->assertPersonIsOk($parserResponse);
    }

    public function testBuildARequestFromCacheWithPathSpecified()
    {
        $cacheConfig = new \stdClass();
        $cacheConfig->path = sys_get_temp_dir() . DIRECTORY_SEPARATOR . 'php-simple-request-alt/';
        $class = new \stdClass();
        $class->key1 = 'val1';
        $class->key2 = 'val2';
        $class->key3 = 'val3';
        $request = new \stdClass();

        $request->anyOf = 5;
        $request->custom = '5';
        $request->date = '17/10/1981 01:30:00';
        $request->email = 'pipicui@hotmail.com';
        $request->enum = 'val1';
        $request->exclusiveMaximum = 3;
        $request->exclusiveMinimum = 8;
        $request->float = '5.1';
        $request->hostName = 'es.wikipedia.org';
        $request->integer = '20';
        $request->ipv4 = '192.168.0.1';
        $request->ipv6 = '2001:0db8:85a3:08d3:1319:8a2e:0370:7334';
        $request->items = [1, '12345'];
        $request->maximum = 3;
        $request->maxItems = [ 'a', 'b' ];
        $request->maxLength = '12345';
        $request->maxProperties = [ 'a', 'b' ];
        $request->minimum = 8;
        $request->minItems = [ 'a', 'b', 'c', 'd' ];
        $request->minLength = '123';
        $request->minProperties = ['a', 'b', 'c', 'd'];
        $request->multipleOf = 5;
        $request->notEmpty = '-';
        $request->notNull = '';
        $request->not = null;
        $request->oneOf = 5;
        $request->properties = ['key1' => 1, 'key2' => '12345'];
        $request->regExp = 'abc123';
        $request->required = $class;
        $request->type = [ 'a' ];
        $request->twitterAccount = '@pepe_123';
        $request->uniqueItems = [ '1', 2, 'potato' ];
        $request->url = 'https://this.isaurl.com/test.php?id=1#test';
        $request->allOf = '1981-10-17T01:30:00-0300';
        $request->pattern = 'abc123';
        $request->dateTime = '1981-10-17T01:30:00-0300';
        $request->hexa = 'fdecba0987654321';
        $request->macAddress = '01-23-45-67-89-ab';

        $builder = $this->createCachedRequestBuilder('PhpSimpleRequestTestAlt');
        $builder->parseRequest($request, AllValidatorsRequest::class, new FirstErrorRequestParser());
        $builder = $this->createCachedRequestBuilder('PhpSimpleRequestTestAlt');
        $builder->parseRequest($request, AllValidatorsRequest::class, new FirstErrorRequestParser());
    }

    public function testBuildARequestAndValidatorNotEmpty()
    {
        $request = new \stdClass();
        $request->firstName = '';
        $request->lastName = 'DOE';
        $request->age = 30;
        try {
            $this->builderWithoutCache->parseRequest(
                $request,
                PersonRequest::class,
                RequestBuilder::RETURN_ALL_ERRORS_IN_EXCEPTION
            );
            $this->fail('Exception expected to be thrown');
        } catch (InvalidRequestException $e) {
            $this->assertTrue(isset($e->getErrors()['firstName']));
        }
    }

    public function testBuildARequestAndValidatorNotNullBecauseFieldIsNull()
    {
        $request = new \stdClass();
        $request->firstName = null;
        $request->lastName = 'DOE';
        $request->age = 30;

        try {
            $this->builderWithoutCache->parseRequest(
                $request,
                PersonRequest::class,
                RequestBuilder::RETURN_ALL_ERRORS_IN_EXCEPTION
            );
            $this->fail('Exception expected to be thrown');
        } catch (InvalidRequestException $e) {
            $this->assertTrue(isset($e->getErrors()['firstName']));
        }
    }

    public function testBuildARequestAndValidatorNotNullBecauseFieldDoesNotExist()
    {
        $request = new \stdClass();
        $request->lastName = 'DOE';
        $request->age = 30;

        try {
            $this->builderWithoutCache->parseRequest(
                $request,
                PersonRequest::class,
                RequestBuilder::RETURN_ALL_ERRORS_IN_EXCEPTION
            );
            $this->fail('Exception expected to be thrown');
        } catch (InvalidRequestException $e) {
            $this->assertTrue(isset($e->getErrors()['firstName']));
        }
    }

    public function testBuildARequestWithInstanceOfClassAnnotations()
    {
        $request = new \stdClass();
        $request->togetherSince = '2001-09-13';

        $person1 = $this->getValidPersonRequest();

        $person2 = new \stdClass();
        $person2->firstName = 'Jane';
        $person2->lastName = 'DoE';
        $person2->age = 41;

        $request->person1 = $person1;
        $request->person2 = $person2;

        /**
         * @var \Fixtures\CoupleRequest $parserResponse
         */
        $parserResponse = $this->builderWithoutCache->parseRequest(
            $request,
            CoupleRequest::class,
            RequestBuilder::RETURN_ALL_ERRORS_IN_EXCEPTION
        );
        $this->assertPersonIsOk($parserResponse->getPerson1());
        $personRequest = $parserResponse->getPerson2();
        $this->assertInstanceOf(PersonRequest::class, $personRequest);
        $this->assertEquals('Jane', $personRequest->getFirstName());
        $this->assertEquals('DOE', $personRequest->getLastName());
        $this->assertEquals(41, $personRequest->getAge());
    }

    private function getValidPersonRequest()
    {
        $request = new \stdClass();
        $request->firstName = '  John  ';
        $request->lastName = 'DOE';
        $request->age = 30;

        return $request;
    }
}
