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
namespace Unit\Validator;

use Mcustiel\SimpleRequest\Validator\RegExp;

class RegExpValidatorTest extends \PHPUnit_Framework_TestCase
{
    const VALID_REGEXP = '/[A-Z][0-9]{2}/i';
    const VALID_VALUE = 'b12';
    const INVALID_VALUE = 'A';

    /**
     * @expectedException        \Mcustiel\SimpleRequest\Exception\UnspecifiedValidatorException
     * @expectedExceptionMessage The validator RegExp is being initialized without a specified regular expression
     */
    public function testSpecificationWithoutValue()
    {
        $validator = new RegExp();
        $validator->setSpecification();
    }

    public function testValidationWithValidValue()
    {
        $validator = new RegExp();
        $validator->setSpecification(self::VALID_REGEXP);
        $this->assertTrue($validator->validate(self::VALID_VALUE));
    }

    public function testValidationWithInvalidValue()
    {
        $validator = new RegExp();
        $validator->setSpecification(self::VALID_REGEXP);
        $this->assertFalse($validator->validate(self::INVALID_VALUE));
    }
}
