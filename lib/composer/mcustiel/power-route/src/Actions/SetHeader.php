<?php

namespace Mcustiel\PowerRoute\Actions;

use Mcustiel\PowerRoute\Common\TransactionData;

class SetHeader implements ActionInterface
{
    use PlaceholderEvaluator;

    public function execute(TransactionData $transactionData, $argument = null)
    {
        $transactionData->setResponse(
            $transactionData->getResponse()->withHeader(
                $argument['name'],
                $this->getValueOrPlaceholder($argument['value'], $transactionData)
            )
        );
    }
}
