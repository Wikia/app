<?php
namespace Mcustiel\SimpleRequest\Services;

use Mcustiel\SimpleRequest\Interfaces\AnnotationService;
use Doctrine\Common\Annotations\AnnotationReader;

class DoctrineAnnotationService implements AnnotationService
{
    /**
     * @var \Doctrine\Common\Annotations\AnnotationReader
     */
    private $annotationReader;

    public function __construct()
    {
        $this->annotationReader = new AnnotationReader();
    }

    /**
     * {@inheritDoc}
     *
     * @see \Mcustiel\SimpleRequest\Interfaces\AnnotationService::getAnnotationsFromProperty()
     */
    public function getAnnotationsFromProperty(\ReflectionProperty $property)
    {
        return $this->annotationReader->getPropertyAnnotations($property);
    }
}
