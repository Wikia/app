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

use Mcustiel\Phiremock\Common\StringStream;
use Mcustiel\Phiremock\Domain\Expectation;
use Mcustiel\Phiremock\Server\Actions\Base\AbstractRequestAction;
use Mcustiel\Phiremock\Server\Model\RequestStorage;
use Mcustiel\Phiremock\Server\Utils\RequestExpectationComparator;
use Mcustiel\PowerRoute\Actions\ActionInterface;
use Mcustiel\PowerRoute\Common\TransactionData;
use Mcustiel\SimpleRequest\RequestBuilder;
use Psr\Log\LoggerInterface;

class CountRequestsAction extends AbstractRequestAction implements ActionInterface
{
    /**
     * @var \Mcustiel\Phiremock\Server\Model\RequestStorage
     */
    private $requestsStorage;
    /**
     * @var \Mcustiel\Phiremock\Server\Utils\RequestExpectationComparator
     */
    private $comparator;

    /**
     * @param RequestBuilder               $requestBuilder
     * @param RequestStorage               $storage
     * @param RequestExpectationComparator $comparator
     * @param LoggerInterface              $logger
     */
    public function __construct(
        RequestBuilder $requestBuilder,
        RequestStorage $storage,
        RequestExpectationComparator $comparator,
        LoggerInterface $logger
    ) {
        parent::__construct($requestBuilder, $logger);
        $this->requestsStorage = $storage;
        $this->comparator = $comparator;
    }

    /**
     * {@inheritdoc}
     *
     * @see \Mcustiel\PowerRoute\Actions\ActionInterface::execute()
     */
    public function execute(TransactionData $transactionData, $argument = null)
    {
        $transactionData->setResponse(
            $this->processAndGetResponse(
                $transactionData,
                function (TransactionData $transaction, Expectation $expectation) {
                    $this->validateRequestOrThrowException($expectation, $this->logger);
                    $count = $this->searchForExecutionsCount($expectation);
                    $this->logger->debug('Found ' . $count . ' request matching the expectation');

                    return $transaction->getResponse()
                        ->withStatus(200)
                        ->withHeader('Content-Type', 'application/json')
                        ->withBody(new StringStream(json_encode(['count' => $count])));
                }
            )
        );
    }

    /**
     * @param Expectation $expectation
     *
     * @return int
     */
    private function searchForExecutionsCount(Expectation $expectation)
    {
        $count = 0;
        foreach ($this->requestsStorage->listRequests() as $request) {
            if ($this->comparator->equals($request, $expectation)) {
                ++$count;
            }
        }

        return $count;
    }
}
