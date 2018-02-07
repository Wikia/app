<?php
namespace Mcustiel\SimpleRequest\Strategies;

use Mcustiel\SimpleRequest\Annotation\RequestAnnotation;
use Mcustiel\SimpleRequest\Annotation\ValidatorAnnotation;
use Mcustiel\SimpleRequest\Annotation\FilterAnnotation;
use Mcustiel\SimpleRequest\Annotation\ParseAs;
use Mcustiel\SimpleRequest\Strategies\Annotations\ValidatorAnnotationParser;
use Mcustiel\SimpleRequest\Strategies\Annotations\FilterAnnotationParser;
use Mcustiel\SimpleRequest\Strategies\Annotations\ParseAsAnnotationParser;

class AnnotationParserFactory
{
    private $map = [
        ValidatorAnnotation::class => ValidatorAnnotationParser::class,
        FilterAnnotation::class    => FilterAnnotationParser::class,
        ParseAs::class             => ParseAsAnnotationParser::class,
    ];

    /**
     * @param RequestAnnotation $annotation
     *
     * @throws \Exception
     *
     * @return \Mcustiel\SimpleRequest\Strategies\Annotations\AnnotationParser
     */
    public function getAnnotationParserFor(RequestAnnotation $annotation)
    {
        foreach ($this->map as $key => $val) {
            if ($annotation instanceof  $key) {
                return new $val;
            }
        }
        throw new \Exception('Unsupported annotation: ' . get_class($annotation));
    }
}
