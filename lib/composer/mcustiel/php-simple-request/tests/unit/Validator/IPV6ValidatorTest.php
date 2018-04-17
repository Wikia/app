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

use Mcustiel\SimpleRequest\Validator\IPV6;

class IPV6ValidatorTest extends \PHPUnit_Framework_TestCase
{
    public function testValidationDefaultSpecification()
    {
        $validator = new IPV6();
        $validator->setSpecification(null);

        $this->assertFalse($validator->validate('1'));
        $this->assertFalse($validator->validate('1:1'));
        $this->assertFalse($validator->validate('1:1:1'));
        $this->assertFalse($validator->validate('1:1:1:1'));
        $this->assertFalse($validator->validate('1:1:1:1:1'));
        $this->assertFalse($validator->validate('1:1:1:1:1:1'));
        $this->assertFalse($validator->validate('1:1:1:1:1:1:1'));
        $this->assertTrue($validator->validate('1:1:1:1:1:1:1:1'));
        $this->assertTrue($validator->validate('01:01:01:01:01:01:01:01'));
        $this->assertTrue($validator->validate('001:001:001:001:001:001:001:001'));
        $this->assertTrue($validator->validate('0001:0001:0001:0001:0001:0001:0001:0001'));
        $this->assertTrue($validator->validate('A001:A001:A001:A001:A001:A001:A001:A001'));
        $this->assertTrue($validator->validate('a001:a001:a001:0001:a001:a001:a001:a001'));
        $this->assertTrue($validator->validate('A001:a001:A001:a001:A001:a001:A001:a001'));
        $this->assertTrue($validator->validate('::A000:A000'));
        $this->assertTrue($validator->validate('A000::A000'));
        $this->assertTrue($validator->validate('A000:A000:A000::A000:A000'));
        $this->assertTrue($validator->validate('A000:A000::A000:A000:A000'));
        $this->assertTrue($validator->validate('A000:A000::'));
        $this->assertFalse($validator->validate('A000:A000:A000:A000:A000:A000:A000:A000:A000'));
        $this->assertFalse($validator->validate('::A000:A000:A000:A000:A000:A000:A000:A000'));
        $this->assertFalse($validator->validate('A000:A000:A000:A000:A000:A000:A000:A000::'));
        $this->assertFalse($validator->validate('A000:A000:A000:A000::A000:A000:A000:A000'));
        $this->assertFalse($validator->validate('A000:A000:A000:A000:A000:A000:A000:G000'));
        $this->assertFalse($validator->validate('10.10.10.10'));
        $this->assertFalse($validator->validate(''));
        $this->assertFalse($validator->validate('a'));
        $this->assertFalse($validator->validate([]));
        $this->assertFalse($validator->validate(['1.1.1.1']));
    }
}
