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

use Mcustiel\SimpleRequest\Validator\Properties;
use Mcustiel\SimpleRequest\Validator\NotEmpty;
use Mcustiel\SimpleRequest\Annotation\Validator\Type;

class PropertiesTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \Mcustiel\SimpleRequest\Interfaces\ValidatorInterface
     */
    private $validator;

    /**
     * @before
     */
    public function init()
    {
        $this->validator = new Properties();
    }


    /**
     * @test
     * @expectedException \Mcustiel\SimpleRequest\Exception\UnspecifiedValidatorException
     * @expectedExceptionMessage The validator is being initialized without an array
     */
    public function failIfSpecificationIsNotAnArray()
    {
        $this->validator->setSpecification('potato');
    }

    /**
     * @test
     * @expectedException \Mcustiel\SimpleRequest\Exception\UnspecifiedValidatorException
     * @expectedExceptionMessage The validator Properties is being initialized with an invalid properties parameter
     */
    public function failIfSpecificationPropertiesIsInvalid()
    {
        $this->validator->setSpecification(['properties' => 'potato']);
    }

    /**
     * @test
     * @expectedException \Mcustiel\SimpleRequest\Exception\UnspecifiedValidatorException
     * @expectedExceptionMessage The validator is being initialized without a valid validator Annotation
     */
    public function failIfSpecificationPropertiesIsAnArrayWithoutAnnotation()
    {
        $this->validator->setSpecification(['properties' => [new NotEmpty()]]);
    }

    /**
     * @test
     * @expectedException \Mcustiel\SimpleRequest\Exception\UnspecifiedValidatorException
     * @expectedExceptionMessage The validator is being initialized without a valid validator Annotation
     */
    public function failIfSpecificationAdditionalPropertiesIsInvalid()
    {
        $this->validator->setSpecification(['additionalProperties' => 'potato']);
    }

    /**
     * @test
     */
    public function isNotValidIfNotArrayOrObject()
    {
        $this->assertFalse($this->validator->validate('potato'));
    }

    /**
     * @test
     */
    public function isValidIfUsingDefaultValuesAsSpecification()
    {
        $this->validator->setSpecification([]);
        $matter = 'matter';
        $this->assertTrue($this->validator->validate(['it', ['does' => 'not'], $matter, 1]));
    }

    /**
     * @test
     */
    public function isValidIfUsingDefaultValuesAsSpecificationWithObject()
    {
        $matter = 'matter';
        $object = new \stdClass();
        $object->it = 'does';
        $object->not = ['matter' => $matter];

        $this->validator->setSpecification([]);
        $this->assertTrue($this->validator->validate($object));
    }

    /**
     * @test
     */
    public function useValidatorsWithValidValues()
    {
        $validator = new Type();
        $validator->value = 'number';
        $this->validator->setSpecification(
            [
                'properties'           => ['a' => $validator, 'b' => $validator, 'c' => $validator],
                'additionalProperties' => false,
            ]
        );
        $this->assertTrue($this->validator->validate(['a' => 1, 'b' => 2, 'c' => 3.4]));
    }

    /**
     * @test
     */
    public function useValidatorsWithValidValueswithObject()
    {
        $validator = new Type();
        $validator->value = 'number';
        $this->validator->setSpecification(
            [
                'properties'           => ['a' => $validator, 'b' => $validator, 'c' => $validator],
                'additionalProperties' => false,
            ]
        );
        $object = new \stdClass();
        $object->a = 1;
        $object->b = 2;
        $object->c = 3.4;
        $this->assertTrue($this->validator->validate($object));
    }

    /**
     * @test
     */
    public function usePropertiesAsValidatorWithAnInvalidValue()
    {
        $validator = new Type();
        $validator->value = 'number';
        $this->validator->setSpecification(
            [
                'properties'           => ['a' => $validator, 'b' => $validator, 'c' => $validator],
                'additionalProperties' => false,
            ]
        );
        $this->assertFalse($this->validator->validate(['a' => 1, 'b' => 2, 'c' => 'nope']));
    }

    /**
     * @test
     */
    public function usePropertiesAsValidatorWithAnInvalidValueWithObject()
    {
        $validator = new Type();
        $validator->value = 'number';
        $this->validator->setSpecification(
            [
                'properties'           => ['a' => $validator, 'b' => $validator, 'c' => $validator],
                'additionalProperties' => false,
            ]
        );
        $object = new \stdClass();
        $object->a = 1;
        $object->b = 2;
        $object->c = 'nope';
        $this->assertFalse($this->validator->validate($object));
    }

    /**
     * @test
     */
    public function notValidIfAdditionalPropertiesAreNotAllowed()
    {
        $validator = new Type();
        $validator->value = 'number';
        $this->validator->setSpecification(
            [
                'properties'           => ['potato' => $validator],
                'additionalProperties' => false,
            ]
        );
        $this->assertFalse($this->validator->validate(['potato' => 21, 'extra' => 'nope']));
    }

    /**
     * @test
     */
    public function notValidIfAdditionalPropertiesAreNotAllowedWithObject()
    {
        $validator = new Type();
        $validator->value = 'number';
        $this->validator->setSpecification(
            [
                'properties'           => ['potato' => $validator],
                'additionalProperties' => false,
            ]
        );
        $object = new \stdClass();
        $object->potato = 21;
        $object->extra = 'nope';
        $this->assertFalse($this->validator->validate($object));
    }

    /**
     * @test
     */
    public function validIfAdditionalPropertiesAreNotAllowed()
    {
        $validator = new Type();
        $validator->value = 'number';
        $this->validator->setSpecification(
            [
                'properties'           => ['potato' => $validator],
                'additionalProperties' => true,
            ]
            );
        $this->assertTrue($this->validator->validate(['potato' => 21, 'extra' => 'nope']));
    }

    /**
     * @test
     */
    public function validIfAdditionalPropertiesAreNotAllowedWithObject()
    {
        $validator = new Type();
        $validator->value = 'number';
        $this->validator->setSpecification(
            [
                'properties'           => ['potato' => $validator],
                'additionalProperties' => true,
            ]
            );
        $object = new \stdClass();
        $object->potato = 21;
        $object->extra = 'nope';
        $this->assertTrue($this->validator->validate($object));
    }

    /**
     * @test
     */
    public function useValidatorsInPatternPropertiesWithValidValues()
    {
        $validator = new Type();
        $validator->value = 'number';
        $this->validator->setSpecification(
            ['patternProperties' => ['/a/' => $validator], 'additionalProperties' => false]
        );

        $this->assertTrue($this->validator->validate([
            'hasAnA'     => 1,
            'hasAnAToo'  => 2,
            'AlsoHasAnA' => 3.45,
        ]));
    }

    /**
     * @test
     */
    public function useValidatorsInPatternPropertiesWithValidValueswithObject()
    {
        $validator = new Type();
        $validator->value = 'number';
        $this->validator->setSpecification(
            ['patternProperties' => ['/a/' => $validator], 'additionalProperties' => false]
        );
        $object = new \stdClass;
        $object->hasAnA = 1;
        $object->hasAnAToo = 2;
        $object->AlsoHasAnA = 3.45;
        $this->assertTrue($this->validator->validate($object));
    }

    /**
     * @test
     */
    public function usePatternPropertiesAsValidatorWithAnInvalidValue()
    {
        $validator = new Type();
        $validator->value = 'number';
        $this->validator->setSpecification(
            ['patternProperties' => ['/a/' => $validator], 'additionalProperties' => false]
        );
        $this->assertFalse($this->validator->validate(['a' => 1, 'hasAnA' => 2, 'fail' => 'nope']));
    }

    /**
     * @test
     */
    public function usePatternPropertiesAsValidatorWithAnInvalidValueWithObject()
    {
        $validator = new Type();
        $validator->value = 'number';
        $this->validator->setSpecification(
            ['patternProperties' => ['/a/' => $validator], 'additionalProperties' => false]
        );
        $object = new \stdClass();
        $object->a = 1;
        $object->hasAnA = 2;
        $object->fail = 'nope';
        $this->assertFalse($this->validator->validate($object));
    }

    /**
     * @test
     */
    public function usePatternPropertiesAndPropertiesWithValidValues()
    {
        $validator = new Type();
        $validator->value = 'number';
        $this->validator->setSpecification(
            [
                'patternProperties'    => ['/a/' => $validator],
                'properties'           => ['otherLetters' => $validator],
                'additionalProperties' => false,
            ]
        );
        $this->assertTrue($this->validator->validate(
            ['a' => 1, 'hasAnA' => 2, 'otherLetters' => 3.4]
        ));
    }

    /**
     * @test
     */
    public function usePatternPropertiesAndPropertiesWithValidValuesWithObject()
    {
        $validator = new Type();
        $validator->value = 'number';
        $this->validator->setSpecification(
            [
                'patternProperties'    => ['/a/' => $validator],
                'properties'           => ['otherLetters' => $validator],
                'additionalProperties' => false,
            ]
        );
        $object = new \stdClass();
        $object->a = 1;
        $object->hasAnA = 2;
        $object->otherLetters = 3.4;
        $this->assertTrue($this->validator->validate($object));
    }

    /**
     * @test
     */
    public function usePatternPropertiesAndPropertiesWithInvalidValues()
    {
        $validator = new Type();
        $validator->value = 'number';
        $this->validator->setSpecification(
            [
                'patternProperties'    => ['/a/' => $validator],
                'properties'           => ['otherLetters' => $validator],
                'additionalProperties' => false,
            ]
        );
        $this->assertFalse($this->validator->validate(
            ['a' => 1, 'hasAnA' => 2, 'otherLetters' => 'potato']
        ));
    }

    /**
     * @test
     */
    public function usePatternPropertiesAndPropertiesWithInvalidValuesWithObject()
    {
        $validator = new Type();
        $validator->value = 'number';
        $this->validator->setSpecification(
            [
                'patternProperties'    => ['/a/' => $validator],
                'properties'           => ['otherLetters' => $validator],
                'additionalProperties' => false,
            ]
            );
        $object = new \stdClass();
        $object->a = 1;
        $object->hasAnA = 2;
        $object->otherLetters = 'potato';
        $this->assertFalse($this->validator->validate($object));
    }

    /**
     * @test
     */
    public function usePatternPropertiesAndPropertiesWithValidValuesAndExtraParams()
    {
        $validator = new Type();
        $validator->value = 'number';
        $this->validator->setSpecification(
            [
                'patternProperties'    => ['/a/' => $validator],
                'properties'           => ['otherLetters' => $validator],
                'additionalProperties' => true,
            ]
            );
        $this->assertTrue($this->validator->validate(
            ['a' => 1, 'hasAnA' => 2, 'otherLetters' => 3.4, 'plus' => 'tomato']
        ));
    }

    /**
     * @test
     */
    public function usePatternPropertiesAndPropertiesWithValidValuesAndExtraParamsWithObject()
    {
        $validator = new Type();
        $validator->value = 'number';
        $this->validator->setSpecification(
            [
                'patternProperties'    => ['/a/' => $validator],
                'properties'           => ['otherLetters' => $validator],
                'additionalProperties' => true,
            ]
            );
        $object = new \stdClass();
        $object->a = 1;
        $object->hasAnA = 2;
        $object->otherLetters = 3.4;
        $object->plus = 'tomato';
        $this->assertTrue($this->validator->validate($object));
    }

    /**
     * @test
     */
    public function usePatternPropertiesAndPropertiesWithValidValuesAndExtraParamsValidated()
    {
        $validator = new Type();
        $validator->value = 'number';
        $this->validator->setSpecification(
            [
                'patternProperties'    => ['/a/' => $validator],
                'properties'           => ['otherLetters' => $validator],
                'additionalProperties' => $validator,
            ]
        );
        $this->assertTrue($this->validator->validate(
            ['a' => 1, 'hasAnA' => 2, 'otherLetters' => 3.4, 'plus' => 5.6]
        ));
    }

    /**
     * @test
     */
    public function usePatternPropertiesAndPropertiesWithValidValuesAndExtraParamsValidatedWithObject()
    {
        $validator = new Type();
        $validator->value = 'number';
        $this->validator->setSpecification(
            [
                'patternProperties'    => ['/a/' => $validator],
                'properties'           => ['otherLetters' => $validator],
                'additionalProperties' => $validator,
            ]
        );
        $object = new \stdClass();
        $object->a = 1;
        $object->hasAnA = 2;
        $object->otherLetters = 3.4;
        $object->plus = 5.6;
        $this->assertTrue($this->validator->validate($object));
    }

    /**
     * @test
     */
    public function failWithPatternPropertiesAndPropertiesWithInvalidValuesAndExtraParamsValidatedWithObject()
    {
        $validator = new Type();
        $validator->value = 'number';
        $this->validator->setSpecification(
            [
                'patternProperties'    => ['/a/' => $validator],
                'properties'           => ['otherLetters' => $validator],
                'additionalProperties' => $validator,
            ]
        );
        $object = new \stdClass();
        $object->a = 1;
        $object->hasAnA = 2;
        $object->otherLetters = 3.4;
        $object->plus = 'fail';
        $this->assertFalse($this->validator->validate($object));
    }

    /**
     * @test
     */
    public function failWithPatternPropertiesAndPropertiesWithInvalidValuesAndExtraParamsValidated()
    {
        $validator = new Type();
        $validator->value = 'number';
        $this->validator->setSpecification(
            [
                'patternProperties'    => ['/a/' => $validator],
                'properties'           => ['otherLetters' => $validator],
                'additionalProperties' => $validator,
            ]
        );
        $this->assertFalse($this->validator->validate(
            ['a' => 1, 'hasAnA' => 2, 'otherLetters' => 3.4, 'plus' => 'fail']
        ));
    }
}
