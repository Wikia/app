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

use Fixtures\AllFiltersRequest;
use Mcustiel\SimpleRequest\RequestBuilder;

class FiltersTest extends TestRequestBuilder
{
    const TEST_VALUE = 'test ONE Two';
    const TRIM_TEST_VALUE = '  Trim me  ';

    /**
     * @test
     */
    public function shouldFilterARequest()
    {
        $requestParams = [
            'custom'        => self::TEST_VALUE,
            'capitalize'    => self::TEST_VALUE,
            'upperCase'     => self::TEST_VALUE,
            'lowerCase'     => self::TEST_VALUE,
            'stringReplace' => self::TEST_VALUE,
            'regexReplace'  => self::TEST_VALUE,
            'trim'          => self::TRIM_TEST_VALUE,
            'toInteger'     => '214.72',
            'toFloat'       => '35',
        ];
        /**
         * @var AllFiltersRequest $request
         */
        $request = $this->builderWithoutCache->parseRequest(
            $requestParams,
            AllFiltersRequest::class,
            RequestBuilder::RETURN_ALL_ERRORS_IN_EXCEPTION
        );

        $this->assertInstanceOf(AllFiltersRequest::class, $request);
        $this->assertEquals('Test One Two', $request->getCustom());
        $this->assertEquals('Test one two', $request->getCapitalize());
        $this->assertEquals('TEST ONE TWO', $request->getUpperCase());
        $this->assertEquals('test one two', $request->getLowerCase());
        $this->assertEquals('Trim me', $request->getTrim());
        $this->assertEquals('test Four Two', $request->getStringReplace());
        $this->assertEquals('test 12ONE34 12Two34', $request->getRegexReplace());
        $this->assertEquals('potato', $request->getDefaultValue());
        $this->assertSame(214, $request->getToInteger());
        $this->assertSame(35.0, $request->getToFloat());
    }

    /**
     * @test
     */
    public function filterAnEmptyRequest()
    {
        $requestParams = [
        ];
        /**
         * @var AllFiltersRequest $request
         */
        $request = $this->builderWithoutCache->parseRequest(
            $requestParams,
            AllFiltersRequest::class,
            RequestBuilder::RETURN_ALL_ERRORS_IN_EXCEPTION
            );

        $this->assertInstanceOf(AllFiltersRequest::class, $request);
        $this->assertEmpty($request->getCustom());
        $this->assertEmpty($request->getCapitalize());
        $this->assertEmpty($request->getUpperCase());
        $this->assertEmpty($request->getLowerCase());
        $this->assertEmpty($request->getTrim());
        $this->assertEmpty($request->getStringReplace());
        $this->assertEmpty($request->getRegexReplace());
        $this->assertEquals('potato', $request->getDefaultValue());
        $this->assertEmpty($request->getToInteger());
        $this->assertEmpty($request->getToFloat());
    }
}
