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

use Mcustiel\SimpleRequest\Validator\Url;

class UrlValidatorTest extends \PHPUnit_Framework_TestCase
{
    const VALID_VALUE_1 = 'http://some.host.com';
    const VALID_VALUE_2 = 'https://some.host.com';
    const VALID_VALUE_3 = 'http://some.host.com/subdir/';
    const VALID_VALUE_4 = 'http://some.host.com/subdir/file.php';
    const VALID_VALUE_5 = 'http://some.host.com/subdir/file.php#';
    const VALID_VALUE_6 = 'http://some.host.com/subdir/file.php#anchor';
    const VALID_VALUE_7 = 'http://some.host.com/subdir/file.php?';
    const VALID_VALUE_8 = 'http://some.host.com/subdir/file.php?query=string';
    const INVALID_VALUE = '-:ht:/s//1234.p,s';

    public function testValidation()
    {
        $validator = new Url();

        $this->assertTrue($validator->validate(self::VALID_VALUE_1));
        $this->assertTrue($validator->validate(self::VALID_VALUE_2));
        $this->assertTrue($validator->validate(self::VALID_VALUE_3));
        $this->assertTrue($validator->validate(self::VALID_VALUE_4));
        $this->assertTrue($validator->validate(self::VALID_VALUE_5));
        $this->assertTrue($validator->validate(self::VALID_VALUE_6));
        $this->assertTrue($validator->validate(self::VALID_VALUE_7));
        $this->assertTrue($validator->validate(self::VALID_VALUE_8));
        $this->assertFalse($validator->validate(self::INVALID_VALUE));
    }
}
