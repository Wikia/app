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

use Mcustiel\SimpleRequest\Validator\TypeFloat;

class FloatValidatorTest extends \PHPUnit_Framework_TestCase
{
    private $validator;

    public function setUp()
    {
        $this->validator = new TypeFloat();
        $this->validator->setSpecification();
    }

    public function testValidationDefaultSpecification()
    {
        $this->assertTrue($this->validator->validate('1.1'));
        $this->assertTrue($this->validator->validate(1.1));
        $this->assertTrue($this->validator->validate(1));
        $this->assertTrue($this->validator->validate(0));
        $this->assertTrue($this->validator->validate(0.0));
        $this->assertTrue($this->validator->validate('0.0'));
        $this->assertFalse($this->validator->validate(''));
        $this->assertFalse($this->validator->validate('a'));
        $this->assertFalse($this->validator->validate([]));
        $this->assertFalse($this->validator->validate([1.1]));
    }

    public function testValidationStrict()
    {
        $this->validator->setSpecification(true);

        $this->assertTrue($this->validator->validate('1.1'));
        $this->assertTrue($this->validator->validate(1.1));
        $this->assertFalse($this->validator->validate(1));
        $this->assertFalse($this->validator->validate(0));
        $this->assertTrue($this->validator->validate(0.0));
        $this->assertTrue($this->validator->validate('0.0'));
        $this->assertFalse($this->validator->validate(''));
        $this->assertFalse($this->validator->validate('a'));
        $this->assertFalse($this->validator->validate([]));
        $this->assertFalse($this->validator->validate([1.1]));
    }
}
