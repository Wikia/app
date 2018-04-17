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

use Mcustiel\SimpleRequest\Validator\Email;

class EmailValidatorTest extends \PHPUnit_Framework_TestCase
{
    public function testValidationDefaultSpecification()
    {
        $validator = new Email();
        $validator->setSpecification();

        $this->assertTrue($validator->validate('pipicui@hotmail.com'));
        $this->assertFalse($validator->validate('mailto:pipicui@hotmail.com'));
        $this->assertFalse($validator->validate('1981-10-17T01:30:00+00:00'));
        $this->assertFalse($validator->validate('mail'));
        $this->assertFalse($validator->validate('@server'));
        $this->assertFalse($validator->validate('server.com'));
        $this->assertFalse($validator->validate('.com'));
        $this->assertFalse($validator->validate(''));
    }
}
