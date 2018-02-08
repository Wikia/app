<?php
namespace Mcustiel\SimpleRequest\Strategies\Annotations;

use Mcustiel\SimpleRequest\Util\ValidatorBuilder;
use Mcustiel\SimpleRequest\Annotation\RequestAnnotation;
use Mcustiel\SimpleRequest\Strategies\PropertyParserBuilder;

class ValidatorAnnotationParser implements AnnotationParser
{
    /**
     * {@inheritdoc}
     * In this method, annotation param is treated as instance of AnnotationWithAssociatedClass.
     *
     * @see \Mcustiel\SimpleRequest\Strategies\Annotations\AnnotationParser::execute()
     */
    public function execute(RequestAnnotation $annotation, PropertyParserBuilder $propertyParser)
    {
        $propertyParser->addValidator(
            ValidatorBuilder::builder()
            ->withClass($annotation->getAssociatedClass())
            ->withSpecification($annotation->getValue())
            ->build()
        );
    }
}
