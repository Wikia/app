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

use Mcustiel\SimpleRequest\Validator\Type;

class TypeValidatorTest extends \PHPUnit_Framework_TestCase
{
    private $validator;

    /**
     * @before
     */
    public function init()
    {
        $this->validator = new Type();
    }

    /**
     * @test
     * @expectedException \Mcustiel\SimpleRequest\Exception\UnspecifiedValidatorException
     * @expectedExceptionMessage The validator Type is being initialized without a valid type name
     */
    public function failIfNoTypeSpecified()
    {
        $this->validator->setSpecification();
    }

    /**
     * @test
     * @expectedException \Mcustiel\SimpleRequest\Exception\UnspecifiedValidatorException
     * @expectedExceptionMessage The validator Type is being initialized without a valid type name
     */
    public function failIfInvalidTypeSpecified()
    {
        $this->validator->setSpecification('potato');
    }

    /**
     * @test
     */
    public function integerIsNumber()
    {
        $this->validator->setSpecification('number');
        $this->assertTrue($this->validator->validate(-1));
    }

    /**
     * @test
     */
    public function integerAsStringIsNotNumber()
    {
        $this->validator->setSpecification('number');
        $this->assertFalse($this->validator->validate('-1'));
    }

    /**
     * @test
     */
    public function floatIsNumber()
    {
        $this->validator->setSpecification('number');
        $this->assertTrue($this->validator->validate(-1.3));
    }

    /**
     * @test
     */
    public function floatAsStringIsNotNumber()
    {
        $this->validator->setSpecification('number');
        $this->assertFalse($this->validator->validate('-1.3'));
    }

    /**
     * @test
     */
    public function numericStringIsString()
    {
        $this->validator->setSpecification('string');
        $this->assertTrue($this->validator->validate('-1.3'));
    }
}
