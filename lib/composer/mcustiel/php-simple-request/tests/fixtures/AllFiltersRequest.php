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

use Mcustiel\SimpleRequest\Annotation\Filter\Capitalize;
use Mcustiel\SimpleRequest\Annotation\Filter\CustomFilter;
use Mcustiel\SimpleRequest\Annotation\Filter\DefaultValue;
use Mcustiel\SimpleRequest\Annotation\Filter\LowerCase;
use Mcustiel\SimpleRequest\Annotation\Filter\RegexReplace;
use Mcustiel\SimpleRequest\Annotation\Filter\StringReplace;
use Mcustiel\SimpleRequest\Annotation\Filter\ToFloat;
use Mcustiel\SimpleRequest\Annotation\Filter\ToInteger;
use Mcustiel\SimpleRequest\Annotation\Filter\Trim;
use Mcustiel\SimpleRequest\Annotation\Filter\UpperCase;

/**
 * @author mcustiel
 */
class AllFiltersRequest
{
    /**
     * @Capitalize
     */
    private $capitalize;

    /**
     * @CustomFilter(class="Mcustiel\SimpleRequest\Filter\Capitalize", value=true)
     *
     * @var unknown
     */
    private $custom;

    /**
     * @DefaultValue("potato")
     *
     * @var unknown
     */
    private $defaultValue;

    /**
     * @LowerCase
     *
     * @var unknown
     */
    private $lowerCase;

    /**
     * @RegexReplace(pattern="/(\b[a-z]{3}\b)/i", replacement="12${1}34")
     *
     * @var unknown
     */
    private $regexReplace;

    /**
     * @StringReplace(pattern="ONE", replacement="Four")
     *
     * @var unknown
     */
    private $stringReplace;

    /**
     * @ToFloat
     *
     * @var unknown
     */
    private $toFloat;

    /**
     * @ToInteger
     *
     * @var unknown
     */
    private $toInteger;

    /**
     * @Trim
     *
     * @var unknown
     */
    private $trim;

    /**
     * @UpperCase
     *
     * @var unknown
     */
    private $upperCase;

    public function getCapitalize()
    {
        return $this->capitalize;
    }

    public function setCapitalize($capitalize)
    {
        $this->capitalize = $capitalize;
        return $this;
    }

    public function getCustom()
    {
        return $this->custom;
    }

    public function setCustom($custom)
    {
        $this->custom = $custom;
        return $this;
    }

    public function getLowerCase()
    {
        return $this->lowerCase;
    }

    public function setLowerCase($lowerCase)
    {
        $this->lowerCase = $lowerCase;
        return $this;
    }

    public function getUpperCase()
    {
        return $this->upperCase;
    }

    public function setUpperCase($upperCase)
    {
        $this->upperCase = $upperCase;
        return $this;
    }

    public function getDefaultValue()
    {
        return $this->defaultValue;
    }

    public function setDefaultValue($defaultValue)
    {
        $this->defaultValue = $defaultValue;
        return $this;
    }

    public function getRegexReplace()
    {
        return $this->regexReplace;
    }

    public function setRegexReplace($regexReplace)
    {
        $this->regexReplace = $regexReplace;
        return $this;
    }

    public function getStringReplace()
    {
        return $this->stringReplace;
    }

    public function setStringReplace($stringReplace)
    {
        $this->stringReplace = $stringReplace;
        return $this;
    }

    public function getToFloat()
    {
        return $this->toFloat;
    }

    public function setToFloat($toFloat)
    {
        $this->toFloat = $toFloat;
        return $this;
    }

    public function getToInteger()
    {
        return $this->toInteger;
    }

    public function setToInteger($toInteger)
    {
        $this->toInteger = $toInteger;
        return $this;
    }

    public function getTrim()
    {
        return $this->trim;
    }

    public function setTrim($trim)
    {
        $this->trim = $trim;
        return $this;
    }
}
