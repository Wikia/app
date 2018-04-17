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
 * Request parser object that returns the parsing errors for all the
 * invalid properties.
 *
 * @author mcustiel
 */
class AllErrorsRequestParser extends RequestParser
{
    /**
     * Parses a request and returns a response object containing the converted object
     * and the list of errors.
     *
     * @param array|\stdClass $request
     *
     * @return ParserResponse
     */
    public function parse($request)
    {
        $object = clone $this->requestObject;
        $invalidValues = [];

        foreach ($this->propertyParsers as $propertyParser) {
            try {
                $this->setProperty($request, $object, $propertyParser);
            } catch (InvalidValueException $e) {
                $invalidValues[$propertyParser->getName()] = $e->getMessage();
            }
        }
        $this->checkIfRequestIsValidOrThrowException($invalidValues);

        return $object;
    }

    /**
     * Checks if there are invalid values in the request, in that case it throws
     * an exception.
     *
     * @param array $invalidValues
     *
     * @throws \Mcustiel\SimpleRequest\Exception\InvalidRequestException
     */
    private function checkIfRequestIsValidOrThrowException($invalidValues)
    {
        if (!empty($invalidValues)) {
            $exception = new InvalidRequestException('Errors occurred while parsing the request');
            $exception->setErrors($invalidValues);
            throw $exception;
        }
    }
}
