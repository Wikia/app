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

use Mcustiel\SimpleRequest\Annotation\Validator as Annot;

/**
 * @author mcustiel
 */
class AllValidatorsRequest
{
    /**
     * @Annot\AnyOf({ @Annot\IPV4, @Annot\TypeInteger })
     *
     * @var unknown
     */
    private $anyOf;
    /**
     * @Annot\CustomValidator(class="Mcustiel\SimpleRequest\Validator\TypeInteger")
     *
     * @var unknown
     */
    private $custom;
    /**
     * @Annot\DateTimeFormat("d/m/Y H:i:s")
     *
     * @var unknown
     */
    private $date;
    /**
     * @Annot\Email
     *
     * @var unknown
     */
    private $email;
    /**
     * @Annot\Enum({ "val1", "val2", "val3" })
     *
     * @var unknown
     */
    private $enum;
    /**
     * @Annot\ExclusiveMaximum(5)
     *
     * @var unknown
     */
    private $exclusiveMaximum;
    /**
     * @Annot\ExclusiveMinimum(5)
     *
     * @var unknown
     */
    private $exclusiveMinimum;
    /**
     * @Annot\TypeFloat(true)
     *
     * @var unknown
     */
    private $float;
    /**
     * @Annot\HostName
     *
     * @var unknown
     */
    private $hostName;
    /**
     * @Annot\TypeInteger
     *
     * @var unknown
     */
    private $integer;
    /**
     * @Annot\IPV4
     *
     * @var unknown
     */
    private $ipv4;
    /**
     * @Annot\IPV6
     *
     * @var unknown
     */
    private $ipv6;
    /**
     * @Annot\Items(items={ @Annot\Type("integer"), @Annot\MaxLength(5) }, additionalItems=false)
     *
     * @var unknown
     */
    private $items;
    /**
     * @Annot\Maximum(5)
     *
     * @var unknown
     */
    private $maximum;
    /**
     * @Annot\MaxItems(3)
     *
     * @var unknown
     */
    private $maxItems;
    /**
     * @Annot\MaxLength(5)
     *
     * @var unknown
     */
    private $maxLength;
    /**
     * @Annot\MaxProperties(3)
     *
     * @var unknown
     */
    private $maxProperties;
    /**
     * @Annot\Minimum(5)
     *
     * @var unknown
     */
    private $minimum;
    /**
     * @Annot\MinItems(3)
     *
     * @var unknown
     */
    private $minItems;
    /**
     * @Annot\MinLength(2)
     *
     * @var unknown
     */
    private $minLength;
    /**
     * @Annot\MinProperties(3)
     *
     * @var unknown
     */
    private $minProperties;
    /**
     * @Annot\MultipleOf(5)
     *
     * @var unknown
     */
    private $multipleOf;
    /**
     * @Annot\NotEmpty
     *
     * @var unknown
     */
    private $notEmpty;
    /**
     * @Annot\NotNull
     *
     * @var unknown
     */
    private $notNull;
    /**
     * @Annot\Not( @Annot\NotNull )
     *
     * @var unknown
     */
    private $not;
    /**
     * @Annot\OneOf({ @Annot\IPV4, @Annot\TypeInteger, @Annot\Enum({ 1, 2, 3 }) })
     *
     * @var unknown
     */
    private $oneOf;
    /**
     * @Annot\Properties(properties={
     *     "key1", @Annot\Type("integer"),
     *     "key2", @Annot\MaxLength(5)
     * }, additionalProperties=false)
     *
     * @var unknown
     */
    private $properties;
    /**
     * @Annot\RegExp("/[a-z]{3}[0-9]{3}/")
     *
     * @var unknown
     */
    private $regExp;
    /**
     * @Annot\Required( {"key1", "key2"} )
     *
     * @var unknown
     */
    private $required;
    /**
     * @Annot\Type("array")
     *
     * @var unknown
     */
    private $type;
    /**
     * @Annot\TwitterAccount
     *
     * @var unknown
     */
    private $twitterAccount;
    /**
     * @Annot\UniqueItems(true)
     *
     * @var unknown
     */
    private $uniqueItems;
    /**
     * @Annot\Uri
     *
     * @var unknown
     */
    private $url;

    /**
     * @Annot\AllOf({@Annot\DateTime, @Annot\Pattern("/^1981-/")})
     *
     * @var unknown
     */
    private $allOf;

    /**
     * @Annot\Pattern("/[a-z]{3}[0-9]{3}/")
     *
     * @var unknown
     */
    private $pattern;

    /**
     * @Annot\DateTime
     *
     * @var unknown
     */
    private $dateTime;

    /**
     * @Annot\Hexa
     *
     * @var unknown
     */
    private $hexa;

    /**
     * @Annot\MacAddress
     *
     * @var unknown
     */
    private $macAddress;

    public function getAnyOf()
    {
        return $this->anyOf;
    }

    public function setAnyOf($anyOf)
    {
        $this->anyOf = $anyOf;
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

    public function getDate()
    {
        return $this->date;
    }

    public function setDate($date)
    {
        $this->date = $date;
        return $this;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail($email)
    {
        $this->email = $email;
        return $this;
    }

    public function getEnum()
    {
        return $this->enum;
    }

    public function setEnum($enum)
    {
        $this->enum = $enum;
        return $this;
    }

    public function getExclusiveMaximum()
    {
        return $this->exclusiveMaximum;
    }

    public function setExclusiveMaximum($exclusiveMaximum)
    {
        $this->exclusiveMaximum = $exclusiveMaximum;
        return $this;
    }

    public function getExclusiveMinimum()
    {
        return $this->exclusiveMinimum;
    }

    public function setExclusiveMinimum($exclusiveMinimum)
    {
        $this->exclusiveMinimum = $exclusiveMinimum;
        return $this;
    }

    public function getFloat()
    {
        return $this->float;
    }

    public function setFloat($float)
    {
        $this->float = $float;
        return $this;
    }

    public function getHostName()
    {
        return $this->hostName;
    }

    public function setHostName($hostName)
    {
        $this->hostName = $hostName;
        return $this;
    }

    public function getInteger()
    {
        return $this->integer;
    }

    public function setInteger($integer)
    {
        $this->integer = $integer;
        return $this;
    }

    public function getIpv4()
    {
        return $this->ipv4;
    }

    public function setIpv4($ipv4)
    {
        $this->ipv4 = $ipv4;
        return $this;
    }

    public function getIpv6()
    {
        return $this->ipv6;
    }

    public function setIpv6($ipv6)
    {
        $this->ipv6 = $ipv6;
        return $this;
    }

    public function getItems()
    {
        return $this->items;
    }

    public function setItems($items)
    {
        $this->items = $items;
        return $this;
    }

    public function getMaximum()
    {
        return $this->maximum;
    }

    public function setMaximum($maximum)
    {
        $this->maximum = $maximum;
        return $this;
    }

    public function getMaxItems()
    {
        return $this->maxItems;
    }

    public function setMaxItems($maxItems)
    {
        $this->maxItems = $maxItems;
        return $this;
    }

    public function getMaxLength()
    {
        return $this->maxLength;
    }

    public function setMaxLength($maxLength)
    {
        $this->maxLength = $maxLength;
        return $this;
    }

    public function getMaxProperties()
    {
        return $this->maxProperties;
    }

    public function setMaxProperties($maxProperties)
    {
        $this->maxProperties = $maxProperties;
        return $this;
    }

    public function getMinimum()
    {
        return $this->minimum;
    }

    public function setMinimum($minimum)
    {
        $this->minimum = $minimum;
        return $this;
    }

    public function getMinItems()
    {
        return $this->minItems;
    }

    public function setMinItems($minItems)
    {
        $this->minItems = $minItems;
        return $this;
    }

    public function getMinLength()
    {
        return $this->minLength;
    }

    public function setMinLength($minLength)
    {
        $this->minLength = $minLength;
        return $this;
    }

    public function getMinProperties()
    {
        return $this->minProperties;
    }

    public function setMinProperties($minProperties)
    {
        $this->minProperties = $minProperties;
        return $this;
    }

    public function getMultipleOf()
    {
        return $this->multipleOf;
    }

    public function setMultipleOf($multipleOf)
    {
        $this->multipleOf = $multipleOf;
        return $this;
    }

    public function getNotEmpty()
    {
        return $this->notEmpty;
    }

    public function setNotEmpty($notEmpty)
    {
        $this->notEmpty = $notEmpty;
        return $this;
    }

    public function getNotNull()
    {
        return $this->notNull;
    }

    public function setNotNull($notNull)
    {
        $this->notNull = $notNull;
        return $this;
    }

    public function getNot()
    {
        return $this->not;
    }

    public function setNot($not)
    {
        $this->not = $not;
        return $this;
    }

    public function getOneOf()
    {
        return $this->oneOf;
    }

    public function setOneOf($oneOf)
    {
        $this->oneOf = $oneOf;
        return $this;
    }

    public function getProperties()
    {
        return $this->properties;
    }

    public function setProperties($properties)
    {
        $this->properties = $properties;
        return $this;
    }

    public function getRegExp()
    {
        return $this->regExp;
    }

    public function setRegExp($regExp)
    {
        $this->regExp = $regExp;
        return $this;
    }

    public function getRequired()
    {
        return $this->required;
    }

    public function setRequired($required)
    {
        $this->required = $required;
        return $this;
    }

    public function getType()
    {
        return $this->type;
    }

    public function setType($type)
    {
        $this->type = $type;
        return $this;
    }

    public function getTwitterAccount()
    {
        return $this->twitterAccount;
    }

    public function setTwitterAccount($twitterAccount)
    {
        $this->twitterAccount = $twitterAccount;
        return $this;
    }

    public function getUniqueItems()
    {
        return $this->uniqueItems;
    }

    public function setUniqueItems($uniqueItems)
    {
        $this->uniqueItems = $uniqueItems;
        return $this;
    }

    public function getUrl()
    {
        return $this->url;
    }

    public function setUrl($url)
    {
        $this->url = $url;
        return $this;
    }

    public function getAllOf()
    {
        return $this->allOf;
    }

    public function setAllOf($allOf)
    {
        $this->allOf = $allOf;
        return $this;
    }

    public function getPattern()
    {
        return $this->pattern;
    }

    public function setPattern($pattern)
    {
        $this->pattern = $pattern;
        return $this;
    }

    public function getDateTime()
    {
        return $this->dateTime;
    }

    public function setDateTime($dateTime)
    {
        $this->dateTime = $dateTime;
        return $this;
    }

    public function getHexa()
    {
        return $this->hexa;
    }

    public function setHexa($hexa)
    {
        $this->hexa = $hexa;
        return $this;
    }

    public function getMacAddress()
    {
        return $this->macAddress;
    }

    public function setMacAddress($macAddress)
    {
        $this->macAddress = $macAddress;
        return $this;
    }
}
