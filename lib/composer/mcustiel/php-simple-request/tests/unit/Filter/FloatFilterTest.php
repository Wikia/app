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
namespace Unit\Filter;

use Mcustiel\SimpleRequest\Filter\ToFloat;

class FloatFilterTest extends BaseTestForNumericFilters
{
    private $filter;

    public function setUp()
    {
        $this->filter = new ToFloat();
        $this->filter->setSpecification();
    }

    public function testFloatWithAStringRepresentingAFloat()
    {
        $this->assertEquals(
            4.3,
            $this->filter->filter('4.3')
        );
    }

    public function testFloatWithAStringRepresentingAnIntegerAsAFloat()
    {
        $this->assertEquals(
            $this->getVariableInfo(4.0),
            $this->getVariableInfo($this->filter->filter('4.0'))
        );

        $this->assertNotEquals(
            $this->getVariableInfo(4),
            $this->getVariableInfo($this->filter->filter('4.0'))
        );
    }

    public function testFloatWithAStringRepresentingAnInteger()
    {
        $this->assertEquals(
            43,
            $this->filter->filter('43')
        );
        $this->assertEquals(
            $this->getVariableInfo(43.0),
            $this->getVariableInfo($this->filter->filter('43'))
        );
    }

    public function testFloatWithANotNumericString()
    {
        $this->assertEquals(
            0,
            $this->filter->filter('potato')
        );
    }
}
