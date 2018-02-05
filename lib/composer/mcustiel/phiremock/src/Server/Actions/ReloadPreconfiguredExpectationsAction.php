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

use Mcustiel\Phiremock\Server\Model\ExpectationStorage;
use Mcustiel\PowerRoute\Actions\ActionInterface;
use Mcustiel\PowerRoute\Common\TransactionData;
use Psr\Log\LoggerInterface;

class ReloadPreconfiguredExpectationsAction implements ActionInterface
{
    /**
     * @var \Mcustiel\Phiremock\Server\Model\ExpectationStorage
     */
    private $expectationStorage;
    /**
     * @var \Mcustiel\Phiremock\Server\Model\ExpectationStorage
     */
    private $expectationBackup;
    /**
     * @var \Psr\Log\LoggerInterface
     */
    private $logger;

    /**
     * @param ExpectationStorage $expectationStorage
     * @param ExpectationStorage $expectationBackup
     * @param LoggerInterface    $logger
     */
    public function __construct(
        ExpectationStorage $expectationStorage,
        ExpectationStorage $expectationBackup,
        LoggerInterface $logger
    ) {
        $this->expectationStorage = $expectationStorage;
        $this->expectationBackup = $expectationBackup;
        $this->logger = $logger;
    }

    /**
     * {@inheritdoc}
     *
     * @see \Mcustiel\PowerRoute\Actions\ActionInterface::execute()
     */
    public function execute(TransactionData $transactionData, $argument = null)
    {
        foreach ($this->expectationBackup->listExpectations() as $expectation) {
            $this->expectationStorage->addExpectation($expectation);
        }
        $this->logger->debug('Pre-defined expectations are restored, scenarios and requests history are cleared.');

        $transactionData->setResponse(
            $transactionData->getResponse()->withStatus(200)
        );
    }
}
