<?php
/**
 * This file is part of php-simple-request.
 *
 * php-simple-request is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Lesser General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * php-simple-request is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with php-simple-request.  If not, see <http://www.gnu.org/licenses/>.
 */
namespace Mcustiel\SimpleRequest\Validator;

use Mcustiel\SimpleRequest\Interfaces\ValidatorInterface;
use Mcustiel\SimpleRequest\Exception\UnspecifiedValidatorException;

/**
 * Checks that each element of an object or array validates against its corresponding
 * validator in a collection, using the name of the property or key.
 * <a href="http://spacetelescope.github.io/understanding-json-schema/UnderstandingJSONSchema.pdf">Here</a>
 * you can see examples of use for this validator.
 *
 * @author mcustiel
 */
class Properties extends AbstractIterableValidator
{
    const PROPERTIES_INDEX = 'properties';
    const PATTERN_PROPERTIES_INDEX = 'patternProperties';
    const ADDITIONAL_PROPERTIES_INDEX = 'additionalProperties';

    /**
     * @var \Mcustiel\SimpleRequest\Interfaces\ValidatorInterface[]
     */
    private $properties = [];

    /**
     * @var bool|\Mcustiel\SimpleRequest\Interfaces\ValidatorInterface
     */
    private $additionalProperties = true;

    /**
     * @var \Mcustiel\SimpleRequest\Interfaces\ValidatorInterface[]
     */
    private $patternProperties = [];

    /**
     * {@inheritdoc}
     *
     * @see \Mcustiel\SimpleRequest\Validator\AbstractIterableValidator::setSpecification()
     */
    public function setSpecification($specification = null)
    {
        $this->checkSpecificationIsArray($specification);

        $this->initProperties($specification);
        $this->initPatternProperties($specification);
        $this->initAdditionalProperties($specification);
    }

    /**
     * @param array $specification
     *
     * @throws \Mcustiel\SimpleRequest\Exception\UnspecifiedValidatorException
     */
    private function initAdditionalProperties(array $specification)
    {
        if (isset($specification[self::ADDITIONAL_PROPERTIES_INDEX])) {
            $this->setAdditionalProperties($specification[self::ADDITIONAL_PROPERTIES_INDEX]);
        }
    }

    /**
     * @param array $specification
     *
     * @throws \Mcustiel\SimpleRequest\Exception\UnspecifiedValidatorException
     */
    private function initPatternProperties(array $specification)
    {
        if (isset($specification[self::PATTERN_PROPERTIES_INDEX])) {
            $this->setPatternProperties($specification[self::PATTERN_PROPERTIES_INDEX]);
        }
    }

    /**
     * @param array $specification
     *
     * @throws \Mcustiel\SimpleRequest\Exception\UnspecifiedValidatorException
     */
    private function initProperties(array $specification)
    {
        if (isset($specification[self::PROPERTIES_INDEX])) {
            $this->setProperties($specification[self::PROPERTIES_INDEX]);
        }
    }

    /**
     * {@inheritdoc}
     *
     * @see \Mcustiel\SimpleRequest\Validator\AbstractAnnotationSpecifiedValidator::validate()
     */
    public function validate($value)
    {
        if (!(is_array($value) || $value instanceof \stdClass)) {
            return false;
        }

        return $this->executePropertiesValidation($this->convertToArray($value));
    }

    /**
     * @param array $value
     *
     * @return bool
     */
    private function executePropertiesValidation(array $value)
    {
        $rest = $value;
        return $this->validateByProperty($value, $rest)
            && $this->validateByPattern($value, $rest)
            && $this->validateAdditionalProperties($rest);
    }

    /**
     * @param array $rest
     *
     * @return bool|\Mcustiel\SimpleRequest\Interfaces\ValidatorInterface|bool
     */
    private function validateAdditionalProperties(array $rest)
    {
        if ($this->additionalProperties === true) {
            return true;
        }
        if ($this->additionalProperties === false && !empty($rest)) {
            return false;
        }
        return $this->validateAgainstAdditionalPropertiesValidator($rest);
    }

    /**
     * @param array $rest
     *
     * @return bool
     */
    private function validateAgainstAdditionalPropertiesValidator(array $rest)
    {
        foreach ($rest as $propertyValue) {
            if (!$this->additionalProperties->validate($propertyValue)) {
                return false;
            }
        }
        return true;
    }

    /**
     * @param array $value
     * @param array $rest
     *
     * @return bool
     */
    private function validateByPattern(array $value, array &$rest)
    {
        $valid = true;
        foreach ($this->patternProperties as $pattern => $propertyValidator) {
            $valid &= $this->validateByPatternUsingValidator(
                $value,
                $rest,
                $pattern,
                $propertyValidator
            );
            if (!$valid) {
                break;
            }
        }
        return $valid;
    }

    /**
     * @param array                                                 $value
     * @param array                                                 $rest
     * @param string                                                $pattern
     * @param \Mcustiel\SimpleRequest\Interfaces\ValidatorInterface $validator
     *
     * @return bool
     */
    private function validateByPatternUsingValidator(
        array $value,
        array &$rest,
        $pattern,
        ValidatorInterface $validator
    ) {
        foreach ($value as $propertyName => $propertyValue) {
            if (preg_match($pattern, $propertyName)) {
                unset($rest[$propertyName]);
                if (!$validator->validate($propertyValue)) {
                    return false;
                }
            }
        }
        return true;
    }

    /**
     * @param array $value
     * @param array $rest
     *
     * @return bool
     */
    private function validateByProperty(array $value, array &$rest)
    {
        $valid = true;
        foreach ($this->properties as $propertyName => $propertyValidator) {
            unset($rest[$propertyName]);
            $valid &= $propertyValidator->validate(
                isset($value[$propertyName]) ? $value[$propertyName] : null
            );
            if (!$valid) {
                break;
            }
        }
        return $valid;
    }

    /**
     * @param \stdClass|array $value
     *
     * @return array
     */
    private function convertToArray($value)
    {
        if (!is_array($value)) {
            return json_decode(json_encode($value), true);
        }
        return $value;
    }

    /**
     * Checks and sets items specification.
     *
     * @param bool|\Mcustiel\SimpleRequest\Interfaces\ValidatorInterface $specification
     *
     * @throws \Mcustiel\SimpleRequest\Exception\UnspecifiedValidatorException
     */
    private function setAdditionalProperties($specification)
    {
        if (is_bool($specification)) {
            $this->additionalProperties = $specification;
        } else {
            $this->additionalProperties = $this->checkIfAnnotationAndReturnObject($specification);
        }
    }

    /**
     * Checks and sets pattern properties specification.
     *
     * @param \Mcustiel\SimpleRequest\Interfaces\ValidatorInterface[] $specification
     *
     * @throws \Mcustiel\SimpleRequest\Exception\UnspecifiedValidatorException
     */
    private function setProperties($specification)
    {
        if (!is_array($specification)) {
            throw new UnspecifiedValidatorException(
                'The validator Properties is being initialized with an invalid '
                . self::PROPERTIES_INDEX
                . ' parameter'
            );
        }
        foreach ($specification as $key => $item) {
            $this->properties[$key] = $this->checkIfAnnotationAndReturnObject($item);
        }
    }

    /**
     * Checks and sets pattern properties specification.
     *
     * @param \Mcustiel\SimpleRequest\Interfaces\ValidatorInterface[] $specification
     *
     * @throws \Mcustiel\SimpleRequest\Exception\UnspecifiedValidatorException
     */
    private function setPatternProperties($specification)
    {
        if (!is_array($specification)) {
            throw new UnspecifiedValidatorException(
                'The validator Properties is being initialized with an invalid '
                . self::PROPERTIES_INDEX
                . ' parameter'
            );
        }
        foreach ($specification as $key => $item) {
            $this->patternProperties[$key] = $this->checkIfAnnotationAndReturnObject($item);
        }
    }
}
