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

use Mcustiel\SimpleRequest\Validator\MaxLength;

class MaxLengthValidatorTest extends \PHPUnit_Framework_TestCase
{
    const STRING_WITH_LENGTH_255 = '123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345';
    const STRING_WITH_LENGTH_50 = '12345678901234567890123456789012345678901234567890';

    public function testValidationDefaultSpecification()
    {
        $validator = new MaxLength();
        $this->assertTrue($validator->validate(self::STRING_WITH_LENGTH_50));
        $this->assertTrue($validator->validate(''));
        $this->assertTrue($validator->validate(self::STRING_WITH_LENGTH_255));
        $this->assertFalse($validator->validate(self::STRING_WITH_LENGTH_255 . 'A'));
    }

    public function testValidationSpecifiedValue()
    {
        $validator = new MaxLength();
        $validator->setSpecification(50);
        $this->assertTrue($validator->validate('12345678901234567890123456789012345678901234567890'));
        $this->assertTrue($validator->validate(''));
        $this->assertTrue($validator->validate(self::STRING_WITH_LENGTH_50));
        $this->assertFalse($validator->validate(self::STRING_WITH_LENGTH_50 . 'A'));
    }

    /**
     * @test
     * @expectedException \Mcustiel\SimpleRequest\Exception\UnspecifiedValidatorException
     * @expectedExceptionMessage Size validator is being initialized without a valid number
     */
    public function specificationShouldFailWithNotIntegerValue()
    {
        $validator = new MaxLength();
        $validator->setSpecification('A');
    }

    /**
     * @test
     * @expectedException \Mcustiel\SimpleRequest\Exception\UnspecifiedValidatorException
     * @expectedExceptionMessage Size validator is being initialized without a valid number
     */
    public function specificationShouldFailWithNegativeValue()
    {
        $validator = new MaxLength();
        $validator->setSpecification(-1);
    }
}
