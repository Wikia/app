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

use Mcustiel\SimpleRequest\Validator\MultipleOf;

class MultipleOfTest extends \PHPUnit_Framework_TestCase
{
    private $validator;

    public function setUp()
    {
        $this->validator = new MultipleOf();
    }

    public function testValidationWithIntegerValueAndIntegerSpecification()
    {
        $this->validator->setSpecification(5);
        $this->assertTrue($this->validator->validate(25));
        $this->assertFalse($this->validator->validate(23));
    }

    public function testValidationWithFloatValueAndIntegerSpecification()
    {
        $this->validator->setSpecification(5);
        $this->assertTrue($this->validator->validate(25.0));
        $this->assertFalse($this->validator->validate(25.2));
    }

    public function testValidationWithIntegerValueAndFloatSpecification()
    {
        $this->validator->setSpecification(2.5);
        $this->assertTrue($this->validator->validate(5));
        $this->assertFalse($this->validator->validate(13));
    }

    public function testValidationWithFloatValueAndFloatSpecification()
    {
        $this->validator->setSpecification(2.5);
        $this->assertTrue($this->validator->validate(5.0));
        $this->assertFalse($this->validator->validate(5.5));
    }

    /**
     * @test
     * @expectedException \Mcustiel\SimpleRequest\Exception\UnspecifiedValidatorException
     * @expectedExceptionMessage The validator MultipleOf is being initialized without a valid number
     */
    public function failWithEmptySpecification()
    {
        $this->validator->setSpecification();
    }

    /**
     * @test
     * @expectedException \Mcustiel\SimpleRequest\Exception\UnspecifiedValidatorException
     * @expectedExceptionMessage The validator MultipleOf is being initialized without a valid number
     */
    public function failWithNoNumericSpecification()
    {
        $this->validator->setSpecification('abc');
    }

    /**
     * @test
     * @expectedException \Mcustiel\SimpleRequest\Exception\UnspecifiedValidatorException
     * @expectedExceptionMessage The validator MultipleOf is being initialized without a valid number
     */
    public function failWithSpecificationZero()
    {
        $this->validator->setSpecification(0);
    }

    /**
     * @test
     * @expectedException \Mcustiel\SimpleRequest\Exception\UnspecifiedValidatorException
     * @expectedExceptionMessage The validator MultipleOf is being initialized without a valid number
     */
    public function failWithNegativeSpecification()
    {
        $this->validator->setSpecification(-1);
    }
}
