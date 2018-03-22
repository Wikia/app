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
use Mcustiel\SimpleRequest\FirstErrorRequestParser;
use Mcustiel\SimpleRequest\RequestBuilder;

class PerformanceTest extends TestRequestBuilder
{
    public function testRequestBuilderWithoutCacheUsingFirstErrorParser()
    {
        $request = [
            'firstName' => '  John  ',
            'lastName'  => 'DOE',
            'age'       => 30,
        ];
        $cyclesList = [
            5000,
        ];

        foreach ($cyclesList as $cycles) {
            $start = microtime(true);
            for ($i = $cycles; $i > 0; $i --) {
                $this->builderWithoutCache->parseRequest($request, PersonRequest::class, new FirstErrorRequestParser());
            }
            echo "\n{$cycles} cycles executed in "
                . (microtime(true) - $start)
                . " seconds without cache and FIRST_ERROR_PARSER \n";
        }
    }

    public function testRequestBuilderWithCacheUsingFirstErrorParser()
    {
        $request = [
            'firstName' => '  John  ',
            'lastName'  => 'DOE',
            'age'       => 30,
        ];
        $cyclesList = [
            25000,
        ];

        foreach ($cyclesList as $cycles) {
            $start = microtime(true);
            for ($i = $cycles; $i > 0; $i --) {
                $this->builderWithCache->parseRequest($request, PersonRequest::class, new FirstErrorRequestParser());
            }
            echo "\n{$cycles} cycles executed in "
                . (microtime(true) - $start)
                . " seconds with cache and FIRST_ERROR_PARSER \n";
        }
    }

    public function testRequestBuilderWithoutCacheUsingAllErrorsParser()
    {
        $request = [
            'firstName' => '  John  ',
            'lastName'  => 'DOE',
            'age'       => 30,
        ];
        $cyclesList = [
            5000,
        ];

        foreach ($cyclesList as $cycles) {
            $start = microtime(true);
            for ($i = $cycles; $i > 0; $i --) {
                $this->builderWithoutCache->parseRequest(
                    $request,
                    PersonRequest::class,
                    RequestBuilder::RETURN_ALL_ERRORS_IN_EXCEPTION
                );
            }
            echo "\n{$cycles} cycles executed in "
                . (microtime(true) - $start)
                . " seconds without cache and RETURN_ALL_ERRORS_IN_EXCEPTION \n";
        }
    }

    public function testRequestBuilderWithCacheUsingAllErrorsParser()
    {
        $request = [
            'firstName' => '  John  ',
            'lastName'  => 'DOE',
            'age'       => 30,
        ];
        $cyclesList = [
            25000,
        ];

        foreach ($cyclesList as $cycles) {
            $start = microtime(true);
            for ($i = $cycles; $i > 0; $i --) {
                $this->builderWithCache->parseRequest(
                    $request,
                    PersonRequest::class,
                    RequestBuilder::RETURN_ALL_ERRORS_IN_EXCEPTION
                );
            }
            echo "\n{$cycles} cycles executed in "
                . (microtime(true) - $start)
                . " seconds with cache and RETURN_ALL_ERRORS_IN_EXCEPTION \n";
        }
    }
}
