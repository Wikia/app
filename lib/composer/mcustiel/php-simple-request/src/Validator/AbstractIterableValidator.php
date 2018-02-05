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

use Mcustiel\SimpleRequest\Exception\UnspecifiedValidatorException;

/**
 * Abstract class for validators that recibes an array as specification.
 *
 * @author mcustiel
 */
abstract class AbstractIterableValidator extends AbstractAnnotationSpecifiedValidator
{
    /**
     * List of items specified in the annotation.
     *
     * @var \Mcustiel\SimpleRequest\Interfaces\ValidatorInterface[]
     */
    protected $items = [];

    /**
     * {@inheritdoc}
     *
     * @see \Mcustiel\SimpleRequest\Validator\AbstractAnnotationSpecifiedValidator::setSpecification()
     */
    public function setSpecification($specification = null)
    {
        $this->checkSpecificationIsArray($specification);

        foreach ($specification as $item) {
            $this->items[] = $this->checkIfAnnotationAndReturnObject($item);
        }
    }

    /**
     * {@inheritdoc}
     *
     * @see \Mcustiel\SimpleRequest\Validator\AbstractAnnotationSpecifiedValidator::validate()
     */
    protected function checkSpecificationIsArray($specification)
    {
        if (!is_array($specification)) {
            throw new UnspecifiedValidatorException(
                'The validator is being initialized without an array'
            );
        }
    }
}
