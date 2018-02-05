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

use Mcustiel\SimpleRequest\Validator\Items;
use Mcustiel\SimpleRequest\Annotation\Validator\NotEmpty;
use Mcustiel\SimpleRequest\Annotation\Validator\Type;

class ItemsalidatorTest extends \PHPUnit_Framework_TestCase
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
        $this->validator = new Items();
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
     * @expectedExceptionMessage The validator is being initialized without an array
     */
    public function failIfSpecificationItemsIsInvalid()
    {
        $this->validator->setSpecification(['items' => 'potato']);
    }

    /**
     * @test
     * @expectedException \Mcustiel\SimpleRequest\Exception\UnspecifiedValidatorException
     * @expectedExceptionMessage The validator is being initialized without a valid validator Annotation
     */
    public function failIfSpecificationItemsIsAnArrayWithoutAnnotation()
    {
        $this->validator->setSpecification(['items' => ['fail']]);
    }

    /**
     * @test
     * @expectedException \Mcustiel\SimpleRequest\Exception\UnspecifiedValidatorException
     * @expectedExceptionMessage The validator is being initialized without a valid validator Annotation
     */
    public function failIfSpecificationAdditionalItemsIsInvalid()
    {
        $this->validator->setSpecification(['additionalItems' => 'potato']);
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
    public function shouldValidateAllElementsAgainsTheCommonValidator()
    {
        $validator = new Type();
        $validator->value = 'number';
        $this->validator->setSpecification(['items' => $validator]);
        $this->assertTrue($this->validator->validate([0, 1, 2.3, -4]));
    }

    /**
     * @test
     */
    public function additionalDoesNotMatterWhenUsingCommonValidator()
    {
        $validator = new Type();
        $validator->value = 'number';
        $this->validator->setSpecification(['items' => $validator, 'additionalItems' => false]);
        $this->assertTrue($this->validator->validate([0, 1, 2.3, -4]));
    }

    /**
     * @test
     */
    public function isValidIfEachElementMatches()
    {
        $validator = new Type();
        $validator->value = 'number';
        $this->validator->setSpecification(
            [
                'items'           => [$validator, new NotEmpty()],
                'additionalItems' => false,
            ]
        );
        $this->assertTrue($this->validator->validate([2.3, 'potato']));
    }

    /**
     * @test
     */
    public function isNotValidIfOneElementDoesNotValidate()
    {
        $validator = new Type();
        $validator->value = 'number';
        $this->validator->setSpecification(
            [
                'items'           => [$validator, new NotEmpty()],
                'additionalItems' => false,
            ]
        );
        $this->assertFalse($this->validator->validate([2.3, '']));
    }

    /**
     * @test
     */
    public function isNotValidIfExtraItemsPresentButNotAllowed()
    {
        $validator = new Type();
        $validator->value = 'number';
        $this->validator->setSpecification(
            [
                'items'           => [$validator, new NotEmpty()],
                'additionalItems' => false,
            ]
        );
        $this->assertFalse($this->validator->validate([2.3, '', 'nope']));
    }

    /**
     * @test
     */
    public function isNotValidIfExtraItemsPresentButNotDoesNotValidate()
    {
        $validator = new Type();
        $validator->value = 'number';
        $this->validator->setSpecification(
            [
                'items'           => [$validator, new NotEmpty()],
                'additionalItems' => $validator,
            ]
        );
        $this->assertFalse($this->validator->validate([2.3, '', 'nope']));
    }

    /**
     * @test
     */
    public function isValidIfExtraItemsPresentAndValidate()
    {
        $validator = new Type();
        $validator->value = 'number';
        $this->validator->setSpecification(
            [
                'items'           => [$validator, new NotEmpty()],
                'additionalItems' => $validator,
            ]
        );
        $this->assertTrue($this->validator->validate([2.3, '', 0]));
    }
}
