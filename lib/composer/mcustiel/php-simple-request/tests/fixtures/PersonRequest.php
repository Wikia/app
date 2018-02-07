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
namespace Fixtures;

use Mcustiel\SimpleRequest\Annotation\Validator\NotEmpty;
use Mcustiel\SimpleRequest\Annotation\Validator\TypeInteger;
use Mcustiel\SimpleRequest\Annotation\Filter\Trim;
use Mcustiel\SimpleRequest\Annotation\Filter\UpperCase;

/**
 * @author mcustiel
 */
class PersonRequest
{
    /**
     * @NotEmpty
     * @Trim
     *
     * @var unknown
     */
    private $firstName;
    /**
     * @Trim
     * @UpperCase
     * @NotEmpty
     *
     * @var unknown
     */
    private $lastName;
    /**
     * @TypeInteger
     *
     * @var unknown
     */
    private $age;

    public function getFirstName()
    {
        return $this->firstName;
    }

    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;
        return $this;
    }

    public function getLastName()
    {
        return $this->lastName;
    }

    public function setLastName($lastName)
    {
        $this->lastName = $lastName;
        return $this;
    }

    public function getAge()
    {
        return $this->age;
    }

    public function setAge($age)
    {
        $this->age = $age;
        return $this;
    }
}
