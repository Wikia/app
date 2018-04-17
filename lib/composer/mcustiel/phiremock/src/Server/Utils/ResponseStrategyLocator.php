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

namespace Mcustiel\Phiremock\Server\Utils;

use Mcustiel\DependencyInjection\DependencyInjectionService;
use Mcustiel\Phiremock\Domain\Expectation;
use Mcustiel\Phiremock\Server\Config\Matchers;
use Mcustiel\Phiremock\Server\Utils\Strategies\HttpResponseStrategy;
use Mcustiel\Phiremock\Server\Utils\Strategies\ProxyResponseStrategy;
use Mcustiel\Phiremock\Server\Utils\Strategies\RegexResponseStrategy;

class ResponseStrategyLocator
{
    /**
     * @var \Mcustiel\DependencyInjection\DependencyInjectionService
     */
    private $diService;

    /**
     * @param DependencyInjectionService $dependencyService
     */
    public function __construct(DependencyInjectionService $dependencyService)
    {
        $this->diService = $dependencyService;
    }

    /**
     * @param \Mcustiel\Phiremock\Domain\Expectation $expectation
     *
     * @return \Mcustiel\Phiremock\Server\Utils\Strategies\ResponseStrategyInterface
     */
    public function getStrategyForExpectation(Expectation $expectation)
    {
        if (!empty($expectation->getProxyTo())) {
            return $this->diService->get(ProxyResponseStrategy::class);
        }
        if ($this->requestBodyOrUrlAreRegexp($expectation)) {
            return $this->diService->get(RegexResponseStrategy::class);
        }

        return $this->diService->get(HttpResponseStrategy::class);
    }

    /**
     * @param Expectation $expectation
     *
     * @return bool
     */
    private function requestBodyOrUrlAreRegexp(Expectation $expectation)
    {
        return $expectation->getRequest()->getBody()
            && Matchers::MATCHES === $expectation->getRequest()->getBody()->getMatcher()
            || $expectation->getRequest()->getUrl()
            && Matchers::MATCHES === $expectation->getRequest()->getUrl()->getMatcher();
    }
}
