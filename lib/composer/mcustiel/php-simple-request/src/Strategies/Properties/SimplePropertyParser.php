<?php
namespace Mcustiel\SimpleRequest\Strategies\Properties;

use Mcustiel\SimpleRequest\Exception\InvalidValueException;

class SimplePropertyParser implements PropertyParser
{
    /**
     *
     * @var \Mcustiel\SimpleRequest\Interfaces\ValidatorInterface[]
     */
    protected $validators = [];
    /**
     *
     * @var \Mcustiel\SimpleRequest\Interfaces\FilterInterface[]
     */
    protected $filters = [];
    /**
     *
     * @var string
     */
    protected $name;

    public function __construct($name)
    {
        $this->name = $name;
    }

    public function setFilters(array $filters)
    {
        $this->filters = $filters;
        return $this;
    }

    public function setValidators(array $validators)
    {
        $this->validators = $validators;
        return $this;
    }

    public function getName()
    {
        return $this->name;
    }

    /**
     * Filters and validates a value. And return the filtered value.
     * It throws an exception if the value is not valid.
     *
     * @param mixed $value
     *
     * @return mixed
     *
     * @throws \Mcustiel\SimpleRequest\Exception\InvalidValueException
     */
    public function parse($propertyValue)
    {
        $return = $this->cloneValue($propertyValue);
        $return = $this->runFilters($return);
        $this->validate($return);

        return $return;
    }

    /**
     * Returns a copy of the received value.
     *
     * @param mixed $value
     *
     * @return mixed
     */
    protected function cloneValue($value)
    {
        if (is_object($value)) {
            return clone $value;
        }
        return $value;
    }

    /**
     * Checks the value against all validators.
     *
     * @param mixed $value
     *
     * @throws \Mcustiel\SimpleRequest\Exception\InvalidValueException
     */
    protected function validate($value)
    {
        foreach ($this->validators as $validator) {
            if (!$validator->validate($value)) {
                throw new InvalidValueException(
                    "Field {$this->name}, was set with invalid value: " . var_export($value, true)
                );
            }
        }
    }

    /**
     * Run all the filters on the value.
     *
     * @param mixed $value
     *
     * @return mixed
     */
    protected function runFilters($value)
    {
        $return = $value;
        foreach ($this->filters as $filter) {
            $return = $filter->filter($return);
        }

        return $return;
    }
}
