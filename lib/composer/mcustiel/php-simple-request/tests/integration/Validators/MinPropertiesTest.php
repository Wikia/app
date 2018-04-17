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

class MinPropertiesTest extends AbstractValidatorTest
{
    const TEST_FIELD = 'minProperties';

    public function testBuildARequestWithInvalidValueBecauseUnderMinPropertiesInArray()
    {
        $this->request[self::TEST_FIELD] = [ 'a', 'b' ];
        $this->buildRequestAndTestErrorFieldPresent(self::TEST_FIELD);
    }

    public function testBuildARequestWithInvalidValueBecauseUnderMinPropertiesInAssociativeArray()
    {
        $this->request[self::TEST_FIELD] = [ 'a' => 'a', 'b' => 'b' ];
        $this->buildRequestAndTestErrorFieldPresent(self::TEST_FIELD);
    }

    public function testBuildARequestWithValidValueInArray()
    {
        $this->request[self::TEST_FIELD] = [ 'a', 'b', 'c' ];
        $this->assertRequestParsesCorrectly();
    }

    public function testBuildARequestWithValidValueInAssociativeArray()
    {
        $this->request[self::TEST_FIELD] = [ 'a' => 'a', 'b' => 'b', 'c' => 'c' ];
        $this->assertRequestParsesCorrectly();
    }

    public function testBuildARequestWithInvalidValueBecauseUnderMinPropertiesInObject()
    {
        $class = $this->getStdClassWithTwoProperties();
        unset($class->c);

        $this->request[self::TEST_FIELD] = $class;
        $this->buildRequestAndTestErrorFieldPresent(self::TEST_FIELD);
    }

    public function testBuildARequestWithValidValueInObject()
    {
        $class = $this->getStdClassWithTwoProperties();

        $this->request[self::TEST_FIELD] = $class;
        $this->assertRequestParsesCorrectly();
    }

    private function getStdClassWithTwoProperties()
    {
        $object = new \stdClass();
        $object->a = 'a';
        $object->b = 'b';
        $object->c = 'c';

        return $object;
    }
}
