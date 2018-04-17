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
namespace Mcustiel\SimpleRequest\Validator;

use Mcustiel\SimpleRequest\Interfaces\ValidatorInterface;
use Mcustiel\SimpleRequest\Annotation\ValidatorAnnotation;
use Mcustiel\SimpleRequest\Exception\UnspecifiedValidatorException;

/**
 * Checks that each element of an array validates against its corresponding
 * validator in a collection.
 * <a href="http://spacetelescope.github.io/understanding-json-schema/UnderstandingJSONSchema.pdf">Here</a>
 * you can see examples of use for this validator.
 *
 * @author mcustiel
 */
class Items extends AbstractIterableValidator
{
    const ITEMS_INDEX = 'items';
    const ADDITIONAL_ITEMS_INDEX = 'additionalItems';

    /**
     * @var bool|\Mcustiel\SimpleRequest\Interfaces\ValidatorInterface
     */
    private $additionalItems = true;

    /**
     * {@inheritdoc}
     *
     * @see \Mcustiel\SimpleRequest\Validator\AbstractIterableValidator::setSpecification()
     */
    public function setSpecification($specification = null)
    {
        $this->checkSpecificationIsArray($specification);

        $this->initItems($specification);
        $this->initAdditionalItems($specification);
    }

    private function initAdditionalItems($specification)
    {
        if (isset($specification[self::ADDITIONAL_ITEMS_INDEX])) {
            $this->setAdditionalItems($specification[self::ADDITIONAL_ITEMS_INDEX]);
        }
    }

    private function initItems($specification)
    {
        if (isset($specification[self::ITEMS_INDEX])) {
            $this->setItems($specification[self::ITEMS_INDEX]);
        }
    }

    /**
     * {@inheritdoc}
     *
     * @see \Mcustiel\SimpleRequest\Validator\AbstractAnnotationSpecifiedValidator::validate()
     */
    public function validate($value)
    {
        if (!is_array($value)) {
            return false;
        }

        // From json-schema definition: if "items" is not present, or its value is an object,
        // validation of the instance always succeeds, regardless of the value of "additionalItems";
        if (empty($this->items)) {
            return true;
        }

        return $this->executeItemsValidation($value);
    }

    private function executeItemsValidation($value)
    {
        if ($this->items instanceof ValidatorInterface) {
            return $this->validateArray($value, $this->items);
        }
        $valid = $this->validateTuple($value);
        // From json-schema definition: if the value of "additionalItems" is boolean value false and
        // the value of "items" is an array, the instance is valid if its size is less than, or
        // equal to, the size of "items".
        if ($this->additionalItems === false) {
            return $valid && (count($value) <= count($this->items));
        }

        // From json-schema definition: if the value of "additionalItems" is
        // boolean value true or an object, validation of the instance always succeeds;
        return $this->validateRest($value);
    }

    /**
     * Validates each element against its corresponding validator. Then,
     * if additionalItems is a validator, checks the rest again those
     * validators.
     *
     * @param array $list
     *
     * @return bool
     */
    private function validateRest(array $list)
    {
        $count = count($this->items);
        return $this->additionalItems === true ||
            $this->validateArray(
                array_slice($list, $count, count($list) - $count),
                $this->additionalItems
            );
    }

    /**
     * Validates each one of the elements of the array against
     * its corresponding specified validator.
     *
     * @param array $tuple
     *
     * @return bool
     */
    private function validateTuple(array $tuple)
    {
        $keys = array_keys($tuple);
        $count = count($this->items);
        for ($index = 0; $index < $count; $index++) {
            // In the specification is not clear what to do when instance size
            // is less than items size. I chose to pass null and if null passes
            // the validation, it returns true.
            $value = isset($keys[$index]) ? $tuple[$keys[$index]] : null;
            if (!$this->items[$index]->validate($value)) {
                return false;
            }
        }

        return true;
    }

    /**
     * Checks and sets the specified items values.
     *
     * @param array|\Mcustiel\SimpleRequest\Interfaces\ValidatorInterface $specification
     */
    private function setItems($specification)
    {
        if ($specification instanceof ValidatorAnnotation) {
            $this->items = $this->createValidatorInstanceFromAnnotation(
                $specification
            );
        } else {
            $this->checkSpecificationIsArray($specification);
            $this->items = $this->convertAnnotationsToValidators($specification);
        }
    }

    private function convertAnnotationsToValidators(array $specification)
    {
        $items = [];
        foreach ($specification as $index => $validator) {
            $items[$index] = $this->checkIfAnnotationAndReturnObject($validator);
        }
        return $items;
    }

    /**
     * Checks and sets the specified additionalItems.
     *
     * @param bool|\Mcustiel\SimpleRequest\Interfaces\ValidatorInterface $specification
     */
    private function setAdditionalItems($specification)
    {
        if (is_bool($specification)) {
            $this->additionalItems = $specification;
        } elseif ($specification instanceof ValidatorAnnotation) {
            $this->additionalItems = $this->createValidatorInstanceFromAnnotation(
                $specification
            );
        } else {
            throw new UnspecifiedValidatorException(
                'The validator is being initialized without a valid validator Annotation'
            );
        }
    }

    /**
     * Validates an array against a specific validator.
     *
     * @param array                                                 $array
     * @param \Mcustiel\SimpleRequest\Interfaces\ValidatorInterface $validator
     */
    private function validateArray(array $array, ValidatorInterface $validator)
    {
        foreach ($array as $item) {
            if (!$validator->validate($item)) {
                return false;
            }
        }

        return true;
    }
}
