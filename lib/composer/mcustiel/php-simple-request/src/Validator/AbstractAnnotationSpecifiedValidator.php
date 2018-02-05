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
use Mcustiel\SimpleRequest\Annotation\ValidatorAnnotation;
use Mcustiel\SimpleRequest\Util\ValidatorBuilder;

/**
 * Base class for Validators that are specified with other validator annotations.
 *
 * @author mcustiel
 */
abstract class AbstractAnnotationSpecifiedValidator implements ValidatorInterface
{
    /**
     * This method checks if the given variable is a validator annotation.
     *
     * @param mixed $variable This is the variable to check. It should be of type ValidatorAnnotation.
     *
     * @throws \Mcustiel\SimpleRequest\Exception\UnspecifiedValidatorException
     *                                                                         If variable is not a ValidatorAnnotation.
     *
     * @return \Mcustiel\SimpleRequest\Interfaces\ValidatorInterface
     *                                                               Created validator object.
     */
    protected function checkIfAnnotationAndReturnObject($variable)
    {
        if (!($variable instanceof ValidatorAnnotation)) {
            throw new UnspecifiedValidatorException(
                'The validator is being initialized without a valid validator Annotation'
            );
        }

        return $this->createValidatorInstanceFromAnnotation($variable);
    }

    /**
     * Constructs a Validator object from a Validator annotation.
     *
     * @param \Mcustiel\SimpleRequest\Annotation\ValidatorAnnotation $validatorAnnotation
     *
     * @return \Mcustiel\SimpleRequest\Interfaces\ValidatorInterface Created validator object.
     */
    protected function createValidatorInstanceFromAnnotation($validatorAnnotation)
    {
        return ValidatorBuilder::builder()
            ->withSpecification($validatorAnnotation->getValue())
            ->withClass($validatorAnnotation->getAssociatedClass())
            ->build();
    }

    /**
     * {@inheritdoc}
     *
     * @see \Mcustiel\SimpleRequest\Interfaces\Specificable::setSpecification()
     */
    abstract public function setSpecification($specification = null);

    /**
     * {@inheritdoc}
     *
     * @see \Mcustiel\SimpleRequest\Interfaces\ValidatorInterface::validate()
     */
    abstract public function validate($value);
}
