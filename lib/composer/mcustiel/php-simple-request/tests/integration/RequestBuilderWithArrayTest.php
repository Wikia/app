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

class RequestBuilderWithArrayTest extends TestRequestBuilder
{
    public function testBuildARequestAndFilter()
    {
        $request = [
            'firstName' => '  John  ',
            'lastName'  => 'DOE',
            'age'       => 30,
        ];
        $parserResponse = $this->builderWithoutCache->parseRequest(
            $request,
            PersonRequest::class,
            RequestBuilder::RETURN_ALL_ERRORS_IN_EXCEPTION
        );
        $this->assertPersonIsOk($parserResponse);
    }

    public function testBuildARequestAndFilterWithCacheEnabled()
    {
        $request = [
            'firstName' => '  John  ',
            'lastName'  => 'DOE',
            'age'       => 30,
        ];
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
        $request = [
            'anyOf'            => 5,
            'custom'           => '5',
            'date'             => '17/10/1981 01:30:00',
            'email'            => 'pipicui@hotmail.com',
            'enum'             => 'val1',
            'exclusiveMaximum' => 3,
            'exclusiveMinimum' => 8,
            'float'            => '5.1',
            'hostName'         => 'es.wikipedia.org',
            'integer'          => '20',
            'ipv4'             => '192.168.0.1',
            'ipv6'             => '2001:0db8:85a3:08d3:1319:8a2e:0370:7334',
            'items'            => [1, '12345'],
            'maximum'          => 3,
            'maxItems'         => [ 'a', 'b' ],
            'maxLength'        => '12345',
            'maxProperties'    => [ 'a', 'b' ],
            'minimum'          => 8,
            'minItems'         => [ 'a', 'b', 'c', 'd' ],
            'minLength'        => '123',
            'minProperties'    => ['a', 'b', 'c', 'd'],
            'multipleOf'       => 5,
            'notEmpty'         => '-',
            'notNull'          => '',
            'not'              => null,
            'oneOf'            => 5,
            'properties'       => ['key1' => 1, 'key2' => '12345'],
            'regExp'           => 'abc123',
            'required'         => $class,
            'type'             => [ 'a' ],
            'twitterAccount'   => '@pepe_123',
            'uniqueItems'      => [ '1', 2, 'potato' ],
            'url'              => 'https://this.isaurl.com/test.php?id=1#test',
            'allOf'            => '1981-10-17T01:30:00-0300',
            'pattern'          => 'abc123',
            'dateTime'         => '1981-10-17T01:30:00-0300',
            'hexa'             => 'fdecba0987654321',
            'macAddress'       => '01-23-45-67-89-ab',
        ];
        $builder = $this->createCachedRequestBuilder('PhpSimpleRequestTestAlt');
        $builder->parseRequest($request, AllValidatorsRequest::class, new FirstErrorRequestParser());
        $builder = $this->createCachedRequestBuilder('PhpSimpleRequestTestAlt');
        $builder->parseRequest($request, AllValidatorsRequest::class, new FirstErrorRequestParser());
    }

    public function testBuildARequestAndValidatorNotEmpty()
    {
        $request = [
            'firstName' => '',
            'lastName'  => 'DOE',
            'age'       => 30,
        ];
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
        $request = [
            'firstName' => null,
            'lastName'  => 'DOE',
            'age'       => 30,
        ];
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
        $request = [
            'lastName' => 'DOE',
            'age'      => 30,
        ];
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
        $request = [
            'togetherSince' => '2001-09-13',
            'person1'       => [
                'firstName' => '  John  ',
                'lastName'  => 'DOE',
                'age'       => 30,
            ],
            'person2' => [
                'firstName' => '  Jane  ',
                'lastName'  => 'DoE',
                'age'       => 41,
            ],
        ];
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
}
