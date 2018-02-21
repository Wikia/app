<?php

namespace Mcustiel\PowerRoute\Actions;

use Mcustiel\PowerRoute\Common\TransactionData;

class StatusCode implements ActionInterface
{
    public function execute(TransactionData $transactionData, $argument = null)
    {
        $argument = (int) $argument ?: 200;
        if ($argument < 100 || $argument >= 600) {
            throw new \RuntimeException('Invalid status code: ' . $argument);
        }
        $transactionData->setResponse(
            $transactionData->getResponse()->withStatus($argument)
        );
    }
}
