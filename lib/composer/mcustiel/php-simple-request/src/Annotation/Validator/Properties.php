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
namespace Mcustiel\SimpleRequest\Annotation\Validator;

use Mcustiel\SimpleRequest\Annotation\ValidatorAnnotation;
use Mcustiel\SimpleRequest\Validator\Properties as PropertiesValidator;
use Mcustiel\SimpleRequest\Exception\InvalidAnnotationException;

/**
 * @Annotation
 * @Target({ "PROPERTY", "ANNOTATION" })
 *
 * @author mcustiel
 */
class Properties extends ValidatorAnnotation
{
    public $properties = [];
    public $patternProperties = [];
    public $additionalProperties;

    public function __construct()
    {
        parent::__construct(PropertiesValidator::class);
    }

    public function getValue()
    {
        return [
            'properties'           => $this->getPropertiesConfigFor($this->properties),
            'patternProperties'    => $this->getPropertiesConfigFor($this->patternProperties),
            'additionalProperties' => $this->additionalProperties,
        ];
    }

    private function getPropertiesConfigFor(array $data)
    {
        $count = count($data);
        $this->validatePropertiesCountOrThrowException($count);
        $properties = array();
        for ($i = 0; $i < $count; $i += 2) {
            $properties[$data[$i]] = $data[$i + 1];
        }
        return $properties;
    }

    private function validatePropertiesCountOrThrowException($count)
    {
        if ($count % 2 != 0) {
            throw new InvalidAnnotationException(
                'Properties field must specify a set of (name, validator) pairs'
            );
        }
    }
}
