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

use Mcustiel\SimpleRequest\Validator\AlphaNumeric;

class AlphaValidatorTest extends \PHPUnit_Framework_TestCase
{
    public function testValidationSuccessful()
    {
        $validator = new AlphaNumeric();
        $validator->setSpecification();

        $this->assertTrue($validator->validate('AaBbCc'));
        $this->assertTrue($validator->validate('Aa1Bb2Cc'));
        $this->assertTrue($validator->validate('123'));
        $this->assertFalse($validator->validate('Aa Bb Cc'));
        $this->assertFalse($validator->validate(''));
        $this->assertFalse($validator->validate('---'));
        $this->assertFalse($validator->validate('   '));
    }
}
