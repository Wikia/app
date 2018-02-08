<?php
namespace Mcustiel\SimpleRequest\Strategies\Annotations;

use Mcustiel\SimpleRequest\Annotation\RequestAnnotation;
use Mcustiel\SimpleRequest\Strategies\PropertyParserBuilder;

class ParseAsAnnotationParser implements AnnotationParser
{
    public function execute(RequestAnnotation $annotation, PropertyParserBuilder $propertyParser)
    {
        $propertyParser->parseAs($annotation->getValue());
    }
}
