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
namespace Integration\Validators;

use Fixtures\AllValidatorsRequest;
use Mcustiel\SimpleRequest\Exception\InvalidRequestException;
use Integration\TestRequestBuilder;
use Mcustiel\SimpleRequest\RequestBuilder;

abstract class AbstractValidatorTest extends TestRequestBuilder
{
    protected $request;

    /**
     * @before
     */
    public function prepare()
    {
        $class = new \stdClass();
        $class->key1 = 'val1';
        $class->key2 = 'val2';
        $class->key3 = 'val3';

        $this->request = [
            'anyOf'            => 5,
            'custom'           => '5',
            'date'             => '17/10/1981 01:30:00',
            'email'            => 'pipicui@hotmail.com',
            'enum'             => 'val1',
            'exclusiveMaximum' => 3,
            'exclusiveMinimum' => 8,
            'float'            => '5.1',
            'hostName'         => 'es.wikipedia.com',
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
    }

    protected function buildRequestAndTestErrorFieldPresent($fieldName)
    {
        try {
            $this->builderWithoutCache->parseRequest(
                $this->request,
                AllValidatorsRequest::class,
                RequestBuilder::RETURN_ALL_ERRORS_IN_EXCEPTION
            );
        } catch (InvalidRequestException $e) {
            $this->assertTrue(isset($e->getErrors()[$fieldName]));
        }
    }

    protected function assertRequestParsesCorrectly()
    {
        $response = $this->builderWithoutCache->parseRequest(
            $this->request,
            AllValidatorsRequest::class,
            RequestBuilder::RETURN_ALL_ERRORS_IN_EXCEPTION
        );
        $this->assertInstanceOf(AllValidatorsRequest::class, $response);
    }

    protected function failWhenFieldIsNull($fieldName)
    {
        $this->request[$fieldName] = null;
        $this->buildRequestAndTestErrorFieldPresent($fieldName);
    }
}
