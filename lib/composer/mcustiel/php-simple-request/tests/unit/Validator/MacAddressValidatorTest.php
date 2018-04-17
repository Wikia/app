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

use Mcustiel\SimpleRequest\Validator\MacAddress;

class MacAddressValidatorTest extends \PHPUnit_Framework_TestCase
{
    public function testValidationDefaultSpecification()
    {
        $validator = new MacAddress();
        $validator->setSpecification();

        $this->assertTrue($validator->validate('01-23-45-67-89-ab'));
        $this->assertTrue($validator->validate('01-23-45-67-89-AB'));
        $this->assertTrue($validator->validate('01:23:45:67:89:ab'));
        $this->assertTrue($validator->validate('01:23:45:67:89:AB'));
        $this->assertTrue($validator->validate('0123.4567.89ab'));
        $this->assertTrue($validator->validate('0123.4567.89AB'));
        $this->assertFalse($validator->validate('01-23-45-67-89-ab-cd'));
        $this->assertFalse($validator->validate('01-23-45-67-89'));
        $this->assertFalse($validator->validate('01-2345-67-89'));
        $this->assertFalse($validator->validate('1-2-4-6-8'));
        $this->assertFalse($validator->validate('potato'));
    }
}
