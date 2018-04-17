<?php
namespace Mcustiel\SimpleRequest\Strategies\Annotations;

use Mcustiel\SimpleRequest\Annotation\RequestAnnotation;
use Mcustiel\SimpleRequest\Strategies\PropertyParserBuilder;

interface AnnotationParser
{
    /**
     * @param \Mcustiel\SimpleRequest\Annotation\RequestAnnotation $annotation
     *
     * @return
     */
    public function execute(RequestAnnotation $annotation, PropertyParserBuilder $propertyParser);
}
