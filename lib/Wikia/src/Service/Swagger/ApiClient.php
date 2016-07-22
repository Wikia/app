<?php

namespace Wikia\Service\Swagger;

use Swagger\Client\ApiException;
use Swagger\Client\Configuration;
use Wikia\Logger\Loggable;
use Wikia\Tracer\WikiaTracer;
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

	public function callApi($resourcePath, $method, $queryParams, $postData, $headerParams, $responseType=null, $endpointPath = NULL) {
		$start = microtime(true);
		$response = $exception = null;
		$code = 200;

		// adding internal headers
		WikiaTracer::instance()->setRequestHeaders( $headerParams, true );

		try {
			$response = parent::callApi($resourcePath, $method, $queryParams, $postData, $headerParams, $responseType);
		} catch (ApiException $e) {
			$exception = $e;
			$code = $e->getCode();
		}

		wfRunHooks( 'AfterHttpRequest', [ $method, $this->config->getHost(), $this->serviceName, $start, null ] ); # PLATFORM-2079

		if ($this->logSampler->shouldSample()) {
			$this->info("Http request", [
				'statusCode' => $code,
				'reqMethod' => $method,
				'reqUrl' => "http://".$this->getConfig()->getHost().$resourcePath,
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
			'service' => $this->serviceName,
		];
	}
}
