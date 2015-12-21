<?php

namespace Wikia\Service\Swagger;

use Swagger\Client\ApiException;
use Swagger\Client\Configuration;
use Wikia\Logger\Loggable;
use Wikia\Util\Statistics\BernoulliTrial;

class ApiClient extends \Swagger\Client\ApiClient {

	use Loggable;

	/** @var BernoulliTrial */
	private $logSampler;

	/** @var string */
	private $serviceName;

	public function __construct(Configuration $config, BernoulliTrial $logSampler, $serviceName) {
		parent::__construct($config);
		$this->logSampler = $logSampler;
		$this->serviceName = $serviceName;
	}

	public function callApi($resourcePath, $method, $queryParams, $postData, $headerParams, $responseType=null) {
		$start = microtime(true);
		$response = $exception = null;
		$reqUrl = "http://".$this->getConfig()->getHost()."/${resourcePath}";
		$code = 200;

		try {
			$response = parent::callApi($resourcePath, $method, $queryParams, $postData, $headerParams, $responseType);
		} catch (ApiException $e) {
			$exception = $e;
			$code = $e->getCode();
		}

		if ($this->logSampler->shouldSample()) {
			$this->info("Http request", [
				'serviceName' => $this->serviceName,
				'statusCode' => $code,
				'reqMethod' => $method,
				'reqUrl' => $reqUrl,
				'isOk' => $exception == null,
				'requestTimeMS' => (int)((microtime(true) - $start) * 1000.0)
			]);
		}

		if ($exception != null) {
			throw $exception;
		}

		return $response;
	}

	protected function getLoggerContext() {
		return [
			'host' => $this->getConfig()->getHost(),
			'service' => $this->serviceName,
		];
	}
}
