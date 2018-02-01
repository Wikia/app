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

use Mcustiel\SimpleRequest\Validator\Enum;

class EnumValidatorTest extends \PHPUnit_Framework_TestCase
{
    private static $specification = [ 'potato', 3, 4.0, 5.2, '3.8', '6.0', '9', [ 'data1', 'data2' ] ];
    private $validator;

    public function setUp()
    {
        $this->validator = new Enum();
        $this->validator->setSpecification(self::$specification);
    }

    public function testValidationSuccessful()
    {
        $this->assertTrue($this->validator->validate('potato'));
        $this->assertTrue($this->validator->validate(3));
        $this->assertTrue($this->validator->validate(4.0));
        $this->assertTrue($this->validator->validate(5.2));
        $this->assertTrue($this->validator->validate('5.2'));
        $this->assertTrue($this->validator->validate('3.8'));
        $this->assertTrue($this->validator->validate(3.8));
        $this->assertTrue($this->validator->validate('6.0'));
        $this->assertTrue($this->validator->validate(6.0));
        $this->assertTrue($this->validator->validate(6));
        $this->assertTrue($this->validator->validate('9'));
        $this->assertTrue($this->validator->validate(9));
        $this->assertTrue($this->validator->validate(9.0));
        $this->assertTrue($this->validator->validate([ 'data1', 'data2' ]));
    }

    public function testValidationUnsuccessful()
    {
        $this->assertFalse($this->validator->validate('not exists'));
    }

    /**
     * @test
     * @expectedException        \Mcustiel\SimpleRequest\Exception\UnspecifiedValidatorException
     * @expectedExceptionMessage The validator Enum is being initialized without an array
     */
    public function shouldThrowExceptionIfSpecificationIsNotArray()
    {
        $this->validator->setSpecification('nope');
    }

    /**
     * @test
     * @expectedException        \Mcustiel\SimpleRequest\Exception\UnspecifiedValidatorException
     * @expectedExceptionMessage The validator Enum is being initialized without an array
     */
    public function shouldThrowExceptionIfSpecificationIsEmptyArray()
    {
        $this->validator->setSpecification([]);
    }
}
