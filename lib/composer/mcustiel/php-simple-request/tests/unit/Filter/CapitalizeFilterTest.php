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

use Mcustiel\SimpleRequest\Filter\Capitalize;

class CapitalizeFilterTest extends \PHPUnit_Framework_TestCase
{
    const EXPECTED_FIRST_WORD = 'Test';
    const EXPECTED_ALL_WORDS = 'Test Text';

    private $filter;

    public function setUp()
    {
        $this->filter = new Capitalize();
    }

    public function testCapitalizeFirstWord()
    {
        $this->assertEquals(
            self::EXPECTED_FIRST_WORD,
            $this->filter->filter(self::EXPECTED_FIRST_WORD)
        );
        $this->assertEquals(self::EXPECTED_FIRST_WORD, $this->filter->filter('TEST'));
        $this->assertEquals(self::EXPECTED_FIRST_WORD, $this->filter->filter('test'));
    }

    public function testCapitalizeAllWords()
    {
        $this->filter->setSpecification(true);
        $this->assertEquals(
            self::EXPECTED_ALL_WORDS,
            $this->filter->filter(self::EXPECTED_ALL_WORDS)
        );
        $this->assertEquals(self::EXPECTED_ALL_WORDS, $this->filter->filter('TEST TEXT'));
        $this->assertEquals(self::EXPECTED_ALL_WORDS, $this->filter->filter('test text'));
    }
}
