<?php

namespace Mcustiel\PowerRoute\Actions;

use Mcustiel\PowerRoute\Common\TransactionData;

interface ActionInterface
{
    /**
     * @param \Mcustiel\PowerRoute\Common\TransactionData $transactionData this object is modified inside the class
     * @param mixed                                       $argument
     */
    public function execute(TransactionData $transactionData, $argument = null);
}
