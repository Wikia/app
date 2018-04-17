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
 * Validates that the given value is a number multiple of the specified number.
 *
 * @author mcustiel
 */
class MultipleOf implements ValidatorInterface
{
    /**
     *
     * @var float|int
     */
    private $number;

    /**
     * {@inheritdoc}
     *
     * @see \Mcustiel\SimpleRequest\Interfaces\Specificable::setSpecification()
     */
    public function setSpecification($specification = null)
    {
        if (empty($specification) || !is_numeric($specification) || $specification <= 0) {
            throw new UnspecifiedValidatorException(
                'The validator MultipleOf is being initialized without a valid number'
            );
        }
        $this->number = $specification;
    }

    /**
     * {@inheritdoc}
     *
     * @see \Mcustiel\SimpleRequest\Interfaces\ValidatorInterface::validate()
     */
    public function validate($value)
    {
        if (!is_numeric($value)) {
            return false;
        }

        return $value / $this->number == round($value / $this->number);
    }
}
