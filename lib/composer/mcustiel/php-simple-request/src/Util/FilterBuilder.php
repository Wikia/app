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

use Mcustiel\SimpleRequest\Exception\FilterDoesNotExistException;
use Mcustiel\SimpleRequest\Interfaces\FilterInterface;

/**
 * Builds Filter objects from the data taken from an annotation.
 *
 * @author mcustiel
 */
class FilterBuilder extends AnnotationToImplementationBuilder
{
    /**
     * This method is used from AnnotationToImplementationBuilder trait. It checks the existence
     * of the Filter class and then checks it's of type FilterInterface.
     *
     * @param string $type The type to instantiate.
     *
     * @return \Mcustiel\SimpleRequest\Interfaces\FilterInterface The instance created
     *
     * @throws \Mcustiel\SimpleRequest\Exception\FilterDoesNotExistException
     *                                                                       If class does not exist or does not implement FilterInterface
     */
    final protected function getClassForType($type)
    {
        if (!class_exists($type)) {
            throw new FilterDoesNotExistException("Filter class {$type} does not exist");
        }
        $filter = new $type;
        if (! ($filter instanceof FilterInterface)) {
            throw new FilterDoesNotExistException(
                "Filter class {$type} must implement " . FilterInterface::class
            );
        }

        return $filter;
    }
}
