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

use Mcustiel\SimpleRequest\Validator\HostName;

class HostnameValidatorTest extends \PHPUnit_Framework_TestCase
{
    private $validator;

    public function setUp()
    {
        $this->validator = new HostName();
        $this->validator->setSpecification();
    }

    public function testSuccessfulValidation()
    {
        $this->assertTrue($this->validator->validate('es.wikipedia.org'));
        $this->assertTrue($this->validator->validate('wikipedia.org'));
        $this->assertTrue($this->validator->validate('4chan.org'));
    }

    public function testUnsuccessfulValidation()
    {
        $this->assertFalse($this->validator->validate('wikipedia'));
        $this->assertFalse($this->validator->validate('es.wikipedia.org/'));
        $this->assertFalse($this->validator->validate('http://es.wikipedia.org'));
        $this->assertFalse($this->validator->validate('.wikipedia.org'));
        $this->assertFalse($this->validator->validate(''));
        $this->assertFalse($this->validator->validate(1234));
    }
}
