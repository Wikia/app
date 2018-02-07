<?php

namespace Mcustiel\PowerRoute\Actions;

use Mcustiel\Mockable\DateTime;
use Mcustiel\PowerRoute\Common\TransactionData;

class SaveCookie implements ActionInterface
{
    use PlaceholderEvaluator;

    public function execute(TransactionData $transactionData, $argument = null)
    {
        $transactionData->setResponse(
            $transactionData->getResponse()->withHeader(
                'Set-Cookie',
                $this->buildSetCookieHeaderValue(
                    $argument,
                    $transactionData
                )
            )
        );
    }

    private function buildSetCookieHeaderValue($argument, $transactionData)
    {
        $value = $this->getValueOrPlaceholder($argument['value'], $transactionData);

        return $argument['name'] . '=' . $value . $this->getSetCookieDatePart($argument)
            . (isset($argument['domain']) ? '; domain=' . $argument['domain'] : '')
            . (isset($argument['path']) ? '; path=' . $argument['path'] : '')
            . (isset($argument['secure']) ? '; secure' : '');
    }

    private function getSetCookieDatePart($argument)
    {
        return isset($argument['ttl']) ? '; expires=' . date(
            DATE_COOKIE,
            ((new DateTime())->toPhpDateTime()->getTimestamp() + $argument['ttl'])
        ) : '';
    }
}
