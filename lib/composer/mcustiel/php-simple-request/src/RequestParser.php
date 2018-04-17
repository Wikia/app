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

use Mcustiel\SimpleRequest\Strategies\Properties\PropertyParser;

/**
 * Abstract class with the common methods used by the current two RequestParser implementations.
 * This class contains the abstract method parse, which should be implemented in specific parser classes.
 * Basically it's a collection of PropertyParser objects that will be run for each property of the request.
 *
 * @author mcustiel
 */
abstract class RequestParser
{
    /**
     * @var \Mcustiel\SimpleRequest\Strategies\Properties\PropertyParser[]
     */
    protected $propertyParsers;
    /**
     * @var object
     */
    protected $requestObject;

    /**
     * Class constructor.
     */
    public function __construct()
    {
        $this->propertyParsers = [];
    }

    /**
     * Adds a property parser to the request parser.
     *
     * @param \Mcustiel\SimpleRequest\Strategies\Properties\PropertyParser $parser
     */
    public function addPropertyParser(PropertyParser $parser)
    {
        $this->propertyParsers[$parser->getName()] = $parser;
    }

    /**
     * Sets the class in which the request must be converted.
     *
     * @param object $requestObject
     */
    public function setRequestObject($requestObject)
    {
        $this->requestObject = $requestObject;
    }

    /**
     * Returns the value of a property in the request.
     *
     * @param array  $request
     * @param string $propertyName
     */
    protected function getFromRequest(array $request, $propertyName)
    {
        return isset($request[$propertyName]) ? $request[$propertyName] : null;
    }

    /**
     * @param array                                                        $request
     * @param object                                                       $object
     * @param \Mcustiel\SimpleRequest\Strategies\Properties\PropertyParser $propertyParser
     */
    protected function setProperty($request, $object, PropertyParser $propertyParser)
    {
        $propertyName = $propertyParser->getName();
        $value = $propertyParser->parse(
            $this->getFromRequest($request, $propertyName)
        );
        $method = 'set' . ucfirst($propertyName);
        $object->$method($value);
    }

    abstract public function parse($request);
}
