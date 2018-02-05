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

use Mcustiel\SimpleRequest\Filter\RegexReplace;

class RegexReplaceFilterTest extends \PHPUnit_Framework_TestCase
{
    const EXPECTED = 'potatoTest';

    private $filter;

    public function setUp()
    {
        $this->filter = new RegexReplace();
        $this->filter->setSpecification(['pattern' => '/\d+/', 'replacement' => 'potato']);
    }

    /**
     * @test
     */
    public function replaceCorrectly()
    {
        $this->assertEquals(self::EXPECTED, $this->filter->filter('1234Test'));
        $this->assertEquals(self::EXPECTED, $this->filter->filter('1Test'));
        $this->assertEquals(self::EXPECTED, $this->filter->filter('0123Test'));
        $this->assertEquals(self::EXPECTED, $this->filter->filter('potatoTest'));
    }

    /**
     * @test
     */
    public function dontReplaceIfNotArrayOrString()
    {
        $this->assertEquals(54321, $this->filter->filter(54321));
    }

    /**
     * @test
     * @expectedException \Mcustiel\SimpleRequest\Exception\FilterErrorException
     * @expectedExceptionMessage An error occurred executing RegexReplace filter
     */
    public function failIfReplaceFails()
    {
        $this->filter->setSpecification(
            ['pattern' => '/invalidRegex', 'replacement' => 'potato']
        );
        $this->assertEquals(
            'doesNotMatter',
            $this->filter->filter('potatoTest')
        );
    }
}
