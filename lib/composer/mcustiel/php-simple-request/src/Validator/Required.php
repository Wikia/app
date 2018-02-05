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
use Mcustiel\SimpleRequest\Exception\UnspecifiedValidatorException;

/**
 * Checks if the specified list of properties names are keys in a given array
 * or properties in a given object.
 *
 * @author mcustiel
 */
class Required implements ValidatorInterface
{
    /**
     *
     * @var number[]|string[]
     */
    protected $items = [];

    public function setSpecification($specification = null)
    {
        $this->specificationIsArrayOrThrowException($specification);
        foreach ($specification as $item) {
            $this->specificationItemisValidOrThrowException($item);
        }

        $this->items = array_unique($specification);
    }

    private function specificationItemisValidOrThrowException($item)
    {
        if (!is_string($item) || is_numeric($item)) {
            throw new UnspecifiedValidatorException(
                'The validator Required is being initialized without a valid array'
            );
        }
    }

    private function specificationIsArrayOrThrowException($specification)
    {
        if (!is_array($specification) || empty($specification)) {
            throw new UnspecifiedValidatorException(
                'The validator Required is being initialized without an array'
            );
        }
    }

    public function validate($value)
    {
        if (is_array($value)) {
            return $this->validateArray($value);
        }
        if ($value instanceof \stdClass) {
            return $this->validateObject($value);
        }

        return false;
    }

    private function validateObject(\stdClass $object)
    {
        foreach ($this->items as $item) {
            if (!property_exists($object, $item)) {
                return false;
            }
        }

        return true;
    }

    private function validateArray(array $array)
    {
        foreach ($this->items as $item) {
            if (!array_key_exists($item, $array)) {
                return false;
            }
        }

        return true;
    }
}
