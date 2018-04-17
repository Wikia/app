<?php

namespace Mcustiel\PowerRoute\Actions;

use Mcustiel\PowerRoute\Common\TransactionData;

class ServerError implements ActionInterface
{
    public function execute(TransactionData $transactionData, $argument = null)
    {
        $argument = (int) $argument;
        if ($argument < 500 || $argument >= 600) {
            $argument = 500;
        }
        $transactionData->setResponse(
            $transactionData->getResponse()->withStatus($argument)
        );
    }
}
