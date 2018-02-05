<?php
namespace Mcustiel\SimpleRequest\Interfaces;

interface ReflectionService
{
    /**
     * Returns all the reflection properties from a class.
     *
     * @param string $className
     *
     * @return \ReflectionProperty[]
     */
    public function getClassProperties($className);
}
