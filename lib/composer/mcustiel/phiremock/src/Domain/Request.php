<?php
/**
 * This file is part of Phiremock.
 *
 * Phiremock is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Lesser General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * Phiremock is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Phiremock.  If not, see <http://www.gnu.org/licenses/>.
 */

namespace Mcustiel\Phiremock\Domain;

use Mcustiel\SimpleRequest\Annotation\Filter as SRF;
use Mcustiel\SimpleRequest\Annotation\Validator as SRV;

class Request implements \JsonSerializable
{
    /**
     * @var string
     *
     * @SRF\LowerCase
     * @SRV\OneOf({
     *      @SRV\Type("null"),
     *      @SRV\Enum({"get", "post", "put", "delete", "fetch", "options", "head", "patch"})
     * })
     */
    private $method;
    /**
     * @var Condition
     *
     * @SRF\CustomFilter(class="\Mcustiel\Phiremock\Server\Http\RequestFilters\ConvertToCondition")
     */
    private $url;
    /**
     * @var Condition
     *
     * @SRF\CustomFilter(class="\Mcustiel\Phiremock\Server\Http\RequestFilters\ConvertToCondition")
     */
    private $body;
    /**
     * @var Condition[]
     *
     * @SRF\CustomFilter(class="\Mcustiel\Phiremock\Server\Http\RequestFilters\HeadersConditionsFilter")
     */
    private $headers;

    public function __toString()
    {
        return print_r(
            [
                'method'  => $this->method,
                'url'     => isset($this->url) ? $this->url->__toString() : 'null',
                'body'    => isset($this->body) ? $this->body->getMatcher() . ' => ' . (isset($this->body->getValue()[5000]) ? '--VERY LONG CONTENTS--' : $this->body->getValue()) : 'null',
                'headers' => print_r($this->headers, true),
            ],
            true
        );
    }

    /**
     * @return string
     */
    public function getMethod()
    {
        return $this->method;
    }

    /**
     * @param string $method
     *
     * @return \Mcustiel\Phiremock\Domain\Request
     */
    public function setMethod($method)
    {
        $this->method = $method;

        return $this;
    }

    /**
     * @return \Mcustiel\Phiremock\Domain\Condition
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @param \Mcustiel\Phiremock\Domain\Condition $url
     *
     * @return \Mcustiel\Phiremock\Domain\Request
     */
    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * @return \Mcustiel\Phiremock\Domain\Condition
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * @param \Mcustiel\Phiremock\Domain\Condition $body
     *
     * @return \Mcustiel\Phiremock\Domain\Request
     */
    public function setBody($body)
    {
        $this->body = $body;

        return $this;
    }

    /**
     * @return \Mcustiel\Phiremock\Domain\Condition[]
     */
    public function getHeaders()
    {
        return $this->headers;
    }

    /**
     * @param \Mcustiel\Phiremock\Domain\Condition[] $headers
     *
     * @return \Mcustiel\Phiremock\Domain\Request
     */
    public function setHeaders($headers)
    {
        $this->headers = $headers;

        return $this;
    }

    /**
     * {@inheritdoc}
     *
     * @see \JsonSerializable::jsonSerialize()
     */
    public function jsonSerialize()
    {
        return [
            'method'  => $this->method,
            'url'     => $this->url,
            'body'    => $this->body,
            'headers' => $this->headers,
        ];
    }
}
