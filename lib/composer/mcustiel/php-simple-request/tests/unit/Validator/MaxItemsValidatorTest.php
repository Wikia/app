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

use Mcustiel\SimpleRequest\Validator\MaxItems;

class MaxItemsValidatorTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function validatesCorrectly()
    {
        $b = 2;
        $obj = new \stdClass();
        $obj->test = ['potato'];
        $validator = new MaxItems();
        $validator->setSpecification(5);
        $this->assertTrue($validator->validate(['a', $b, ['c'], ['d', 3], $obj]));
        $this->assertTrue($validator->validate(['a', $b, ['c'], ['d', 3]]));
        $this->assertTrue($validator->validate([]));
        $this->assertFalse($validator->validate(['a', $b, ['c'], ['d', 3], $obj, 8]));
    }

    /**
     * @test
     */
    public function notValidIfIsNotArray()
    {
        $validator = new MaxItems();
        $validator->setSpecification(5);
        $validator->validate('test');
        $this->assertFalse($validator->validate('tomato'));
    }

    /**
     * @test
     * @expectedException \Mcustiel\SimpleRequest\Exception\UnspecifiedValidatorException
     * @expectedExceptionMessage Size validator is being initialized without a valid number
     */
    public function specificationShouldFailWithNotIntegerValue()
    {
        $validator = new MaxItems();
        $validator->setSpecification('A');
    }

    /**
     * @test
     * @expectedException \Mcustiel\SimpleRequest\Exception\UnspecifiedValidatorException
     * @expectedExceptionMessage Size validator is being initialized without a valid number
     */
    public function specificationShouldFailWithNegativeValue()
    {
        $validator = new MaxItems();
        $validator->setSpecification(-1);
    }
}
