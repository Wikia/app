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
namespace Integration\Validators;

class FloatTest extends AbstractValidatorTest
{
    const TEST_FIELD = 'float';

    public function testBuildARequestWithInvalidValueBecauseOfStrict()
    {
        $this->request[self::TEST_FIELD] = '5';
        $this->buildRequestAndTestErrorFieldPresent(self::TEST_FIELD);
    }

    public function testBuildARequestWithInvalidValueBecauseOfNotNumeric()
    {
        $this->request[self::TEST_FIELD] = 'nope';
        $this->buildRequestAndTestErrorFieldPresent(self::TEST_FIELD);
    }
}
