<?php

namespace Mcustiel\PowerRoute\Actions;

use Mcustiel\PowerRoute\Common\RequestUrlAccess;
use Mcustiel\PowerRoute\Common\TransactionData;
use Psr\Http\Message\ServerRequestInterface;

trait PlaceholderEvaluator
{
    use RequestUrlAccess;

    /**
     * @param mixed                                    $value
     * @param \Psr\Http\Message\ServerRequestInterface $transactiondata
     *
     * @return mixed
     */
    public function getValueOrPlaceholder($value, TransactionData $transactiondata)
    {
        return preg_replace_callback(
            '/\{\{\s*(var|uri|get|post|header|cookie|method)(?:\.([a-z0-9-_]+))?\s*\}\}/i',
            function ($matches) use ($transactiondata) {
                return $this->getValueFromPlaceholder(
                    $matches[1],
                    isset($matches[2]) ? $matches[2] : null,
                    $transactiondata
                );
            },
            $value
        );
    }

    /**
     * @param string                                   $from
     * @param string|null                              $name
     * @param \Psr\Http\Message\ServerRequestInterface $transactionData
     *
     * @return mixed
     */
    private function getValueFromPlaceholder($from, $name, TransactionData $transactionData)
    {
        switch ($from) {
            case 'var':
                return $transactionData->get($name);
            case 'method':
                return $transactionData->getRequest()->getMethod();
            case 'uri':
                return $this->getParsedUrl($name, $transactionData->getRequest());
            case 'get':
                return $transactionData->getRequest()->getQueryParams()[$name];
            case 'header':
                return $transactionData->getRequest()->getHeader($name);
            case 'cookie':
                return $transactionData->getRequest()->getCookieParams()[$name];
            case 'post':
            case 'bodyParam':
                return $this->getValueFromParsedBody($name, $transactionData->getRequest());
        }
    }

    private function getParsedUrl($name, ServerRequestInterface $request)
    {
        if ($name !== null) {
            return $this->getValueFromUrlPlaceholder($name, $request->getUri());
        }

        return $request->getUri()->__toString();
    }

    private function getValueFromParsedBody($name, ServerRequestInterface $request)
    {
        $data = $request->getParsedBody();

        return is_array($data) ? $data[$name] : $data->$name;
    }
}
