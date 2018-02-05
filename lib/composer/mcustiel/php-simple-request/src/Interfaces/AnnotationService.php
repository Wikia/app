<?php
namespace Mcustiel\SimpleRequest\Interfaces;

interface AnnotationService
{
    /**
     * @param \ReflectionProperty $property
     *
     * @return \Doctrine\Common\Annotations\Annotation[]
     */
    public function getAnnotationsFromProperty(\ReflectionProperty $property);
}
