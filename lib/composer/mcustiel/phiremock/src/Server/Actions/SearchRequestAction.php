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

namespace Mcustiel\Phiremock\Server\Actions;

use Mcustiel\Phiremock\Domain\Expectation;
use Mcustiel\Phiremock\Server\Model\ExpectationStorage;
use Mcustiel\Phiremock\Server\Utils\RequestExpectationComparator;
use Mcustiel\PowerRoute\Actions\ActionInterface;
use Mcustiel\PowerRoute\Common\TransactionData;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Log\LoggerInterface;

class SearchRequestAction implements ActionInterface
{
    /**
     * @var \Mcustiel\Phiremock\Server\Model\ExpectationStorage
     */
    private $storage;
    /**
     * @var \Mcustiel\Phiremock\Server\Utils\RequestExpectationComparator
     */
    private $comparator;
    /**
     * @var \Psr\Log\LoggerInterface
     */
    private $logger;

    /**
     * @param ExpectationStorage           $storage
     * @param RequestExpectationComparator $comparator
     * @param LoggerInterface              $logger
     */
    public function __construct(
        ExpectationStorage $storage,
        RequestExpectationComparator $comparator,
        LoggerInterface $logger
    ) {
        $this->storage = $storage;
        $this->comparator = $comparator;
        $this->logger = $logger;
    }

    /**
     * {@inheritdoc}
     *
     * @see \Mcustiel\PowerRoute\Actions\ActionInterface::execute()
     */
    public function execute(TransactionData $transactionData, $argument = null)
    {
        $this->logger->debug('Searching matching expectation for request');
        $request = $transactionData->getRequest();
        $this->logger->info('Request received: ' . $this->getLoggableRequest($request));
        $foundExpectation = $this->searchForMatchingExpectation($request);
        if (null === $foundExpectation) {
            $transactionData->set('foundExpectation', false);

            return;
        }
        $transactionData->set('foundExpectation', $foundExpectation);
    }

    /**
     * @param ServerRequestInterface $request
     *
     * @return null|\Mcustiel\Phiremock\Domain\Expectation
     */
    private function searchForMatchingExpectation(ServerRequestInterface $request)
    {
        $lastFound = null;
        foreach ($this->storage->listExpectations() as $expectation) {
            $lastFound = $this->getNextMatchingExpectation($lastFound, $request, $expectation);
        }

        return $lastFound;
    }

    /**
     * @param null|\Mcustiel\Phiremock\Domain\Expectation $lastFound
     * @param ServerRequestInterface                      $request
     * @param Expectation                                 $expectation
     *
     * @return \Mcustiel\Phiremock\Domain\Expectation
     */
    private function getNextMatchingExpectation($lastFound, ServerRequestInterface $request, Expectation $expectation)
    {
        if ($this->comparator->equals($request, $expectation)) {
            if (null === $lastFound || $expectation->getPriority() > $lastFound->getPriority()) {
                $lastFound = $expectation;
            }
        }

        return $lastFound;
    }

    /**
     * @param ServerRequestInterface $request
     *
     * @return string
     */
    private function getLoggableRequest(ServerRequestInterface $request)
    {
        return $request->getMethod() . ': '
            . $request->getUri()->__toString() . ' || '
                . preg_replace('|\s+|', ' ', $request->getBody()->__toString());
    }
}
