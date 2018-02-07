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

use Mcustiel\SimpleRequest\Validator\Maximum;

class MaximumValidatorTest extends \PHPUnit_Framework_TestCase
{
    private $validator;

    public function setUp()
    {
        $this->validator = new Maximum();
    }

    /**
     * @test
     * @expectedException \Mcustiel\SimpleRequest\Exception\UnspecifiedValidatorException
     * @expectedExceptionMessage The validator Maximum is being initialized without a valid number
     */
    public function failIfInvalidSpecification()
    {
        $this->validator->setSpecification('potato');
    }

    /**
     * @test
     */
    public function invalidIfNotNumberSpecified()
    {
        $this->assertFalse($this->validator->validate('potato'));
    }

    /**
     * @test
     */
    public function testValidationWithIntegers()
    {
        $this->validator->setSpecification(5);

        $this->assertTrue($this->validator->validate(4));
        $this->assertTrue($this->validator->validate(5));
        $this->assertFalse($this->validator->validate(6));
        $this->assertTrue($this->validator->validate(-1));
        $this->assertTrue($this->validator->validate(0));
    }

    /**
     * @test
     */
    public function testValidationWithFloats()
    {
        $this->validator->setSpecification(5.1);

        $this->assertTrue($this->validator->validate(5.09999));
        $this->assertTrue($this->validator->validate(5.1));
        $this->assertFalse($this->validator->validate(5.1001));
        $this->assertTrue($this->validator->validate(-1.3));
        $this->assertTrue($this->validator->validate(0.1));
    }

    /**
     * @test
     */
    public function testValidationWithStrings()
    {
        $this->validator->setSpecification('5.1');

        $this->assertTrue($this->validator->validate('5.09999'));
        $this->assertTrue($this->validator->validate('5.1'));
        $this->assertFalse($this->validator->validate('5.1001'));
        $this->assertTrue($this->validator->validate('5'));
        $this->assertTrue($this->validator->validate('-1.3'));
        $this->assertTrue($this->validator->validate('0.1'));
    }
}
