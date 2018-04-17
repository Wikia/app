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

use Mcustiel\SimpleRequest\Strategies\AnnotationParserFactory;
use Mcustiel\SimpleRequest\Strategies\PropertyParserBuilder;
use Mcustiel\SimpleRequest\Interfaces\ReflectionService;
use Mcustiel\SimpleRequest\Interfaces\AnnotationService;

class ParserGenerator
{
    /**
     * @var \Mcustiel\SimpleRequest\Interfaces\AnnotationService
     */
    private $annotationReader;
    /**
     * @var \Mcustiel\SimpleRequest\Strategies\AnnotationParserFactory
     */
    private $annotationParserFactory;

    /**
     * @var \Mcustiel\SimpleRequest\Interfaces\ReflectionService
     */
    private $reflectionService;

    /**
     * @param \Mcustiel\SimpleRequest\Interfaces\AnnotationService       $annotationReader
     * @param \Mcustiel\SimpleRequest\Strategies\AnnotationParserFactory $annotationParserFactory
     * @param \Mcustiel\SimpleRequest\Interfaces\ReflectionService       $reflectionService
     */
    public function __construct(
        AnnotationService $annotationReader,
        AnnotationParserFactory $annotationParserFactory,
        ReflectionService $reflectionService
    ) {
        $this->annotationReader = $annotationReader;
        $this->annotationParserFactory = $annotationParserFactory;
        $this->reflectionService = $reflectionService;
    }

    /**
     * Populates the parser object with the properties parser and the class object.
     *
     * @param string         $className
     * @param RequestParser  $parserObject
     * @param RequestBuilder $requestBuilder
     *
     * @return RequestParser
     */
    public function populateRequestParser(
        $className,
        RequestParser $parserObject,
        RequestBuilder $requestBuilder
    ) {
        $parserObject->setRequestObject(new $className);
        foreach ($this->reflectionService->getClassProperties($className) as $property) {
            $parserObject->addPropertyParser(
                $this->getPropertyParserBuilder($property)->build($requestBuilder)
            );
        }
        return $parserObject;
    }

    private function getPropertyParserBuilder(\ReflectionProperty $property)
    {
        $propertyParserBuilder = new PropertyParserBuilder($property->getName());
        foreach ($this->annotationReader->getAnnotationsFromProperty($property) as $propertyAnnotation) {
            $this->annotationParserFactory
                ->getAnnotationParserFor($propertyAnnotation)
                ->execute($propertyAnnotation, $propertyParserBuilder);
        }
        return $propertyParserBuilder;
    }
}
