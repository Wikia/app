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

use Mcustiel\SimpleRequest\Validator\TwitterAccount;

class TwitterValidatorTest extends \PHPUnit_Framework_TestCase
{
    const VALID_VALUE = '@twitterAcc_12';
    const INVALID_VALUE_TOO_LONG = '@AReallyLongAccnt';
    const VALID_VALUE_LONG_LIMIT_UP = '@AReallyLongAcnt';
    const VALID_VALUE_LONG_LIMIT_DOWN = '@a';
    const INVALID_VALUE_ONLY_AT = '@';
    const INVALID_VALUE_ONLY_WORD_CHARS = 'B12';

    public function testValidationWithValidValues()
    {
        $validator = new TwitterAccount();
        $validator->setSpecification();
        $this->assertTrue($validator->validate(self::VALID_VALUE));
        $this->assertTrue($validator->validate(self::VALID_VALUE_LONG_LIMIT_DOWN));
        $this->assertTrue($validator->validate(self::VALID_VALUE_LONG_LIMIT_UP));
    }

    public function testValidationWithInvalidValues()
    {
        $validator = new TwitterAccount();
        $validator->setSpecification();
        $this->assertFalse($validator->validate(self::INVALID_VALUE_ONLY_AT));
        $this->assertFalse($validator->validate(self::INVALID_VALUE_ONLY_WORD_CHARS));
        $this->assertFalse($validator->validate(self::INVALID_VALUE_TOO_LONG));
    }
}
