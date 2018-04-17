<?php

namespace Mcustiel\PowerRoute\Actions;

use Mcustiel\PowerRoute\Common\TransactionData;

class NotFound implements ActionInterface
{
    public function execute(TransactionData $transactionData, $argument = null)
    {
        $transactionData->setResponse($transactionData->getResponse()->withStatus(404, 'Not Found'));
    }
}
