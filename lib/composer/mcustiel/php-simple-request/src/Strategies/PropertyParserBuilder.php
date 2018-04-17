<?php
namespace Mcustiel\SimpleRequest\Strategies;

use Mcustiel\SimpleRequest\Interfaces\ValidatorInterface;
use Mcustiel\SimpleRequest\Interfaces\FilterInterface;
use Mcustiel\SimpleRequest\RequestBuilder;
use Mcustiel\SimpleRequest\Strategies\Properties\SimplePropertyParser;
use Mcustiel\SimpleRequest\Strategies\Properties\PropertyParserToObject;

class PropertyParserBuilder
{
    /**
     * @var \Mcustiel\SimpleRequest\Interfaces\ValidatorInterface[]
     */
    private $validators = [];
    /**
     * @var \Mcustiel\SimpleRequest\Interfaces\FilterInterface[]
     */
    private $filters = [];
    /**
     * @var string
     */
    private $name;
    /**
     * @var string
     */
    private $type;

    public function __construct($name)
    {
        $this->name = $name;
    }

    /**
     * Adds a validator to the parser.
     *
     * @param \Mcustiel\SimpleRequest\Interfaces\ValidatorInterface $validator
     */
    public function addValidator(ValidatorInterface $validator)
    {
        $this->validators[] = $validator;
        return $this;
    }

    /**
     * Adds a filter to the parser.
     *
     * @param \Mcustiel\SimpleRequest\Interfaces\FilterInterface $filter
     */
    public function addFilter(FilterInterface $filter)
    {
        $this->filters[] = $filter;
        return $this;
    }

    /**
     * Sets the type to parse the object to.
     *
     * @param string $type
     */
    public function parseAs($type)
    {
        $this->type = $type;
        return $this;
    }

    /**
     * @param \Mcustiel\SimpleRequest\RequestBuilder $requestBuilder
     */
    public function build(RequestBuilder $requestBuilder)
    {
        return $this->createPropertyParser($requestBuilder)
            ->setFilters($this->filters)
            ->setValidators($this->validators);
    }

    private function createPropertyParser(RequestBuilder $requestBuilder)
    {
        if ($this->type) {
            return new PropertyParserToObject($this->name, $this->type, $requestBuilder);
        }
        return new SimplePropertyParser($this->name);
    }
}
