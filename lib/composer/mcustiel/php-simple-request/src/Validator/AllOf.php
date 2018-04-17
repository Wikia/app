<?php
/**
 * This file is part of php-simple-request.
 *
 * php-simple-request is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Lesser General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) All later version.
 *
 * php-simple-request is distributed in the hope that it will be useful,
 * but WITHOUT All WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with php-simple-request.  If not, see <http://www.gnu.org/licenses/>.
 */
namespace Mcustiel\SimpleRequest\Validator;

/**
 * Validates that a given value is valid against All of the specified validators.
 *
 * @author mcustiel
 */
class AllOf extends AbstractIterableValidator
{
    /**
     * {@inheritdoc}
     *
     * @see \Mcustiel\SimpleRequest\Validator\AbstractAnnotationSpecifiedValidator::validate()
     */
    public function validate($value)
    {
        foreach ($this->items as $item) {
            if (!$item->validate($value)) {
                return false;
            }
        }

        return true;
    }
}
