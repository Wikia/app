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

use Mcustiel\SimpleRequest\Validator\MinLength;

class MinLengthValidatorTest extends \PHPUnit_Framework_TestCase
{
    public function testValidationDefaultSpecification()
    {
        $validator = new MinLength();
        $this->assertTrue($validator->validate(''));
        $this->assertTrue($validator->validate(''));
        $this->assertTrue($validator->validate('AAAAAAAA'));
    }

    public function testValidationSpecifiedValue()
    {
        $validator = new MinLength();
        $validator->setSpecification(5);
        $this->assertTrue($validator->validate('12345678901234567890123456789012345678901234567890'));
        $this->assertFalse($validator->validate(''));
        $this->assertFalse($validator->validate('a'));
        $this->assertFalse($validator->validate('aa'));
        $this->assertFalse($validator->validate('aaa'));
        $this->assertFalse($validator->validate('aaaa'));
        $this->assertTrue($validator->validate('aaaaa'));
    }

    /**
     * @test
     * @expectedException \Mcustiel\SimpleRequest\Exception\UnspecifiedValidatorException
     * @expectedExceptionMessage Size validator is being initialized without a valid number
     */
    public function specificationShouldFailWithNotIntegerValue()
    {
        $validator = new MinLength();
        $validator->setSpecification('A');
    }

    /**
     * @test
     * @expectedException \Mcustiel\SimpleRequest\Exception\UnspecifiedValidatorException
     * @expectedExceptionMessage Size validator is being initialized without a valid number
     */
    public function specificationShouldFailWithNegativeValue()
    {
        $validator = new MinLength();
        $validator->setSpecification(-1);
    }
}
