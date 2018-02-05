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

/**
 * Trait with the needed methods to build an object from an annotation. The class
 * that use this trait shouls implement the method getClassForType. It's used by
 * the classes that builds validators or filters.
 *
 * @author mcustiel
 */
abstract class AnnotationToImplementationBuilder
{
    /**
     * @var string
     */
    protected $type;
    /**
     * @var mixed
     */
    protected $specification;

    /**
     * Creator method. Creates an instance of this object.
     * return $this
     */
    public static function builder()
    {
        return new static;
    }

    /**
     * Sets the class name.
     *
     * @param string $type Name of the class given by the annotation.
     *
     * @return $this For fluent interface
     */
    public function withClass($type)
    {
        $this->type = $type;
        return $this;
    }

    /**
     * Sets the specification of the validation or filter.
     *
     * @param mixed $specification Specification set in the annotation.
     *
     * @return $this For fluent interface
     */
    public function withSpecification($specification)
    {
        $this->specification = $specification;
        return $this;
    }

    /**
     * Builds the object from the given specification.
     *
     * @return \Mcustiel\SimpleRequest\Interfaces\FilterInterface|\Mcustiel\SimpleRequest\Interfaces\ValidatorInterface
     */
    public function build()
    {
        $class = $this->getClassForType($this->type);
        $validator = new $class;
        $validator->setSpecification($this->specification);

        return $validator;
    }

    /**
     * @param string $type The type to instantiate.
     *
     * @return \Mcustiel\SimpleRequest\Interfaces\FilterInterface|\Mcustiel\SimpleRequest\Interfaces\ValidatorInterface
     *
     * @throws \Mcustiel\SimpleRequest\Exception\FilterDoesNotExistException
     * @throws \Mcustiel\SimpleRequest\Exception\ValidatorDoesNotExistException
     */
    abstract protected function getClassForType($type);
}
