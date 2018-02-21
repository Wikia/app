<?php
namespace Mcustiel\SimpleRequest\Annotation\Filter;

use Mcustiel\SimpleRequest\Annotation\FilterAnnotation;

abstract class ReplaceFilterAnnotation extends FilterAnnotation
{
    public $pattern;
    public $replacement;

    public function __construct($class)
    {
        parent::__construct($class);
    }

    public function getValue()
    {
        return ['pattern' => $this->pattern, 'replacement' => $this->replacement];
    }
}
