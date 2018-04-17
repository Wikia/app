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

use Mcustiel\SimpleRequest\Validator\Hexa;

class HexaValidatorTest extends \PHPUnit_Framework_TestCase
{
    public function testValidationDefaultSpecification()
    {
        $validator = new Hexa();
        $validator->setSpecification();

        $this->assertTrue($validator->validate('0'));
        $this->assertTrue($validator->validate('9'));
        $this->assertTrue($validator->validate('f'));
        $this->assertTrue($validator->validate('F'));
        $this->assertFalse($validator->validate('g'));
        $this->assertTrue($validator->validate('0F'));
        $this->assertTrue($validator->validate('F0'));
        $this->assertFalse($validator->validate('G0'));
        $this->assertTrue($validator->validate('0123456789abcdef'));
        $this->assertTrue($validator->validate('FEDCBA9876543210'));
        $this->assertFalse($validator->validate('0123456789abcdefg'));
        $this->assertFalse($validator->validate('0123456789abcdef-'));
        $this->assertFalse($validator->validate('0123456789abcdef_'));
        $this->assertFalse($validator->validate('0123456789abcdef '));
    }
}
