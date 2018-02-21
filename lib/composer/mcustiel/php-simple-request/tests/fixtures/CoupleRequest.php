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

use Mcustiel\SimpleRequest\Annotation as SRA;

class CoupleRequest
{
    /**
     * @SRA\Validator\DateTimeFormat("Y-m-d")
     *
     * @var unknown
     */
    private $togetherSince;
    /**
     * @SRA\ParseAs("\Fixtures\PersonRequest")
     *
     * @var \Fixtures\PersonRequest
     */
    private $person1;
    /**
     * @SRA\ParseAs("\Fixtures\PersonRequest")
     *
     * @var \Fixtures\PersonRequest
     */
    private $person2;

    public function getTogetherSince()
    {
        return $this->togetherSince;
    }

    public function setTogetherSince($togetherSince)
    {
        $this->togetherSince = $togetherSince;
        return $this;
    }

    public function getPerson1()
    {
        return $this->person1;
    }

    public function setPerson1($person1)
    {
        $this->person1 = $person1;
        return $this;
    }

    public function getPerson2()
    {
        return $this->person2;
    }

    public function setPerson2($person2)
    {
        $this->person2 = $person2;
        return $this;
    }
}
