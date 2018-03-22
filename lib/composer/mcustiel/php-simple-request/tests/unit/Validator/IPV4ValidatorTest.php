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

use Mcustiel\SimpleRequest\Validator\IPV4;

class IPV4ValidatorTest extends \PHPUnit_Framework_TestCase
{
    public function testValidationDefaultSpecification()
    {
        $validator = new IPV4();
        $validator->setSpecification(null);

        $this->assertFalse($validator->validate('1'));
        $this->assertFalse($validator->validate('1.1'));
        $this->assertFalse($validator->validate('1.1.1'));
        $this->assertTrue($validator->validate('1.1.1.1'));
        $this->assertTrue($validator->validate('10.10.10.10'));
        $this->assertTrue($validator->validate('100.100.100.100'));
        $this->assertFalse($validator->validate('1.1.1.1.1'));
        $this->assertFalse($validator->validate('1.1.1.256'));
        $this->assertTrue($validator->validate('1.1.1.255'));
        $this->assertFalse($validator->validate(''));
        $this->assertFalse($validator->validate('a'));
        $this->assertFalse($validator->validate([]));
        $this->assertFalse($validator->validate(['1.1.1.1']));
    }
}
