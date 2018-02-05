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

use Mcustiel\SimpleRequest\Validator\UniqueItems;

class UniqueItemsValidatorTest extends \PHPUnit_Framework_TestCase
{
    private $validator;

    public function setUp()
    {
        $this->validator = new UniqueItems();
        $this->validator->setSpecification();
    }

    public function testSuccessfultValidation()
    {
        $this->assertTrue($this->validator->validate([]));
        $this->assertTrue($this->validator->validate([1, 2, 3]));
        $this->assertTrue($this->validator->validate(['a', 'b', 'c']));
        $this->assertTrue($this->validator->validate([1, 'b', 3]));
    }

    public function testUnsuccessfulValidation()
    {
        $this->assertFalse($this->validator->validate([1, 2, 3, 3]));
        $this->assertFalse($this->validator->validate([1, 2, 2.0, 3]));
    }
}
