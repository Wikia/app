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
namespace Mcustiel\SimpleRequest\Util;

use Mcustiel\SimpleRequest\Exception\ValidatorDoesNotExistException;
use Mcustiel\SimpleRequest\Interfaces\ValidatorInterface;

/**
 * Builds Validator objects from the data taken from an annotation.
 *
 * @author mcustiel
 */
class ValidatorBuilder extends AnnotationToImplementationBuilder
{
    /**
     * This method is used from AnnotationToImplementationBuilder trait. It checks the existence
     * of the Validator class and then checks it's of type ValidatorInterface.
     *
     * @param string $type Name of the class to instantiate.
     *
     * @throws \Mcustiel\SimpleRequest\Exception\ValidatorDoesNotExistException
     *                                                                          If class does not exist or is not of type ValidatorInterface.
     *
     * @return \Mcustiel\SimpleRequest\Interfaces\ValidatorInterface The created object.
     */
    final protected function getClassForType($type)
    {
        if (!class_exists($type)) {
            throw new ValidatorDoesNotExistException("Validator class {$type} does not exist");
        }
        $validator = new $type;
        if (! ($validator instanceof ValidatorInterface)) {
            throw new ValidatorDoesNotExistException(
                "Validator class {$type} must implement " . ValidatorInterface::class
            );
        }

        return $validator;
    }
}
