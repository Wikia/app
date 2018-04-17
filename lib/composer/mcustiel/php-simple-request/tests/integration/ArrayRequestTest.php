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
use Mcustiel\SimpleRequest\RequestBuilder;

class ArrayRequestTest extends TestRequestBuilder
{
    /**
     * @test
     * @expectedException \Mcustiel\SimpleRequest\Exception\InvalidRequestException
     * @expectedExceptionMessage Request builder is intended to be used with arrays or instances of \stdClass
     */
    public function failWhenAnInvalidRequestIsPassed()
    {
        $request = 'potato';

        $this->builderWithoutCache->parseRequest(
            $request,
            PersonRequest::class,
            RequestBuilder::RETURN_ALL_ERRORS_IN_EXCEPTION
        );
    }

    /**
     * @test
     */
    public function whenObjectIsArrayShouldParseAsArray()
    {
        $request = [
            [
                'firstName' => '  John  ',
                'lastName'  => 'DOe',
                'age'       => 30,
            ],
            [
                'firstName' => '  Jane  ',
                'lastName'  => 'DoE',
                'age'       => 25,
            ],
        ];
        $parserResponse = $this->builderWithoutCache->parseRequest(
            $request,
            [PersonRequest::class],
            RequestBuilder::RETURN_ALL_ERRORS_IN_EXCEPTION
        );
        $this->assertInternalType('array', $parserResponse);
        $this->assertCount(2, $parserResponse);
        $this->assertPersonIsOk($parserResponse[0]);
        $this->assertInstanceOf(PersonRequest::class, $parserResponse[1]);
        $this->assertEquals('Jane', $parserResponse[1]->getFirstName());
        $this->assertEquals('DOE', $parserResponse[1]->getLastName());
        $this->assertEquals(25, $parserResponse[1]->getAge());
    }
}
