<?php
namespace Mcustiel\SimpleRequest\Strategies\Properties;

interface PropertyParser
{
    /**
     * @param mixed $propertyValue Extra data to pass to the parser
     *
     * @return mixed
     */
    public function parse($propertyValue);

    /**
     * @param array $validators
     *
     * @return $this
     */
    public function setValidators(array $validators);

    /**
     * @param array $filters
     *
     * @return $this
     */
    public function setFilters(array $filters);

    /**
     * @return string
     */
    public function getName();
}
