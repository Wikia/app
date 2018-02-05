<?php
namespace Mcustiel\SimpleRequest\Strategies\Properties;

use Mcustiel\SimpleRequest\Exception\InvalidAnnotationException;
use Mcustiel\SimpleRequest\RequestBuilder;

class PropertyParserToObject extends SimplePropertyParser
{
    /**
     * @var \Mcustiel\SimpleRequest\RequestBuilder
     */
    private $requestBuilder;
    /**
     * @var string
     */
    private $type;

    public function __construct($name, $type, RequestBuilder $requestBuilder)
    {
        parent::__construct($name);
        $this->type = $type;
        $this->requestBuilder = $requestBuilder;
    }

    /**
     * {@inheritdoc}
     *
     * @see \Mcustiel\SimpleRequest\Strategies\Properties\SimplePropertyParser::parse()
     */
    public function parse($propertyValue)
    {
        $return = $this->cloneValue($propertyValue);
        $return = $this->createInstanceOfTypeFromValue($return);
        $return = $this->runFilters($return);
        $this->validate($return);

        return $return;
    }

    /**
     * Parses the value as it is an instance of the class specified in type property.
     *
     * @param array|\stdClass $value The value to parse and convert to an object
     *
     * @throws \Mcustiel\SimpleRequest\Exception\InvalidAnnotationException
     *
     * @return object Parsed value as instance of class specified in type property
     */
    private function createInstanceOfTypeFromValue($value)
    {
        if (!isset($value)) {
            return null;
        }
        if (class_exists($this->type)) {
            return $this->requestBuilder->parseRequest($value, $this->type);
        }
        throw new InvalidAnnotationException(
            "Class {$this->type} does not exist. Annotated in property {$this->name}."
        );
    }
}
