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
namespace Mcustiel\SimpleRequest;

use Mcustiel\SimpleRequest\Exception\InvalidValueException;
use Mcustiel\SimpleRequest\Exception\InvalidRequestException;

/**
 * Parser object that stops on first invalid property and returns only that error.
 *
 * @author mcustiel
 */
class FirstErrorRequestParser extends RequestParser
{
    /**
     * Parses a request and returns the object obtained.
     *
     * @param array|\stdClass $request
     *
     * @return object
     */
    public function parse($request)
    {
        $object = clone $this->requestObject;
        foreach ($this->propertyParsers as $propertyParser) {
            try {
                $this->setProperty($request, $object, $propertyParser);
            } catch (InvalidValueException $e) {
                $propertyName = $propertyParser->getName();
                $exception = new InvalidRequestException($propertyName . ': ' . $e->getMessage());
                $exception->setErrors([$propertyName => $e->getMessage()]);
                throw $exception;
            }
        }

        return clone $object;
    }
}
