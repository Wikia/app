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

use Mcustiel\Phiremock\Server\Model\ScenarioStorage;
use Mcustiel\Phiremock\Server\Utils\ResponseStrategyLocator;
use Mcustiel\PowerRoute\Actions\ActionInterface;
use Mcustiel\PowerRoute\Actions\NotFound;
use Mcustiel\PowerRoute\Common\TransactionData;
use Psr\Http\Message\ResponseInterface;
use Psr\Log\LoggerInterface;

class VerifyRequestFound implements ActionInterface
{
    /**
     * @var \Mcustiel\Phiremock\Server\Model\ScenarioStorage
     */
    private $scenarioStorage;
    /**
     * @var \Psr\Log\LoggerInterface
     */
    private $logger;
    /**
     * @var \Mcustiel\Phiremock\Server\Utils\ResponseStrategyLocator
     */
    private $responseStrategyFactory;

    /**
     * @param ScenarioStorage         $scenarioStorage
     * @param LoggerInterface         $logger
     * @param ResponseStrategyLocator $responseStrategyFactory
     */
    public function __construct(
        ScenarioStorage $scenarioStorage,
        LoggerInterface $logger,
        ResponseStrategyLocator $responseStrategyFactory
    ) {
        $this->scenarioStorage = $scenarioStorage;
        $this->logger = $logger;
        $this->responseStrategyFactory = $responseStrategyFactory;
    }

    public function execute(TransactionData $transactionData, $argument = null)
    {
        /**
         * @var \Mcustiel\Phiremock\Domain\Expectation
         */
        $foundExpectation = $transactionData->get('foundExpectation');
        if (!$foundExpectation) {
            (new NotFound())->execute($transactionData);

            return;
        }

        $this->processScenario($foundExpectation);

        $response = $this->responseStrategyFactory
            ->getStrategyForExpectation($foundExpectation)
            ->createResponse($foundExpectation, $transactionData);

        $this->logger->debug('Responding: ' . $this->getLoggableResponse($response));
        $transactionData->setResponse($response);
    }

    /**
     * @param ResponseInterface $response
     *
     * @return string
     */
    private function getLoggableResponse(ResponseInterface $response)
    {
        $body = $response->getBody()->__toString();

        return $response->getStatusCode() . ' / '
            . strlen($body) > 5000 ? '--VERY LONG CONTENTS--' : preg_replace('|\s+|', ' ', $body);
    }

    /**
     * @param \Mcustiel\Phiremock\Domain\Expectation $foundExpectation
     */
    private function processScenario($foundExpectation)
    {
        if ($foundExpectation->getNewScenarioState()) {
            if (!$foundExpectation->getScenarioName()) {
                throw new \RuntimeException(
                    'Expecting scenario state without specifying scenario name'
                );
            }
            $this->scenarioStorage->setScenarioState(
                $foundExpectation->getScenarioName(),
                $foundExpectation->getNewScenarioState()
            );
        }
    }
}
