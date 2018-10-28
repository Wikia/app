<?php

namespace Wikia\Service\Swagger;

use Swagger\Client\ApiException;
use Swagger\Client\Configuration;
use Wikia\CircuitBreaker;
use Wikia\Logger\Loggable;
use Wikia\Tracer\WikiaTracer;
use Wikia\Util\Statistics\BernoulliTrial;

class ApiClient extends \Swagger\Client\ApiClient {

	use Loggable;

	/** @var BernoulliTrial */
	private $logSampler;

	/** @var string */
	private $serviceName;

	/** @var CircuitBreaker\CircuitBreaker */
	private $circuitBreaker = null;

	public function __construct(Configuration $config, BernoulliTrial $logSampler, $serviceName) {
		parent::__construct($config);
		$this->logSampler = $logSampler;
		$this->serviceName = $serviceName;
	}

	public function setCircuitBreaker( CircuitBreaker\CircuitBreaker $circuitBreaker ) {
		$this->circuitBreaker = $circuitBreaker;
	}

	public function callApi($resourcePath, $method, $queryParams, $postData, $headerParams, $responseType=null, $endpointPath=null) {
		if ( is_null( $this->circuitBreaker ) ) {
			return $this->internalCallApi($resourcePath, $method, $queryParams, $postData, $headerParams, $responseType,
				$endpointPath);
		}
		return $this->circuitBreaker->wrapCall(
			function() use ($resourcePath, $method, $queryParams, $postData, $headerParams, $responseType,
				$endpointPath) {
				return $this->internalCallApi($resourcePath, $method, $queryParams, $postData, $headerParams, $responseType,
					$endpointPath);
			},
			function( $exception ) {
				if ($exception instanceof \Swagger\Client\ApiException) {
					// code 0 is for connection/timeout errors
					if ($exception->getCode() == 502 || $exception->getCode() == 504 || $exception->getCode() == 0) {
						return false;
					}
				}
				return true;
			},
			function() {
				throw new \Swagger\Client\ApiException("Circuit breaken open", 504);
			});
	}

	public function internalCallApi($resourcePath, $method, $queryParams, $postData, $headerParams, $responseType=null, $endpointPath=null) {
		$start = microtime(true);
		$response = $exception = null;
		$code = 200;

		// adding internal headers
		WikiaTracer::instance()->setRequestHeaders( $headerParams, true );

		try {
			$response = parent::callApi($resourcePath, $method, $queryParams, $postData, $headerParams, $responseType, $endpointPath);
		} catch (ApiException $e) {
			$exception = $e;
			$code = $e->getCode();
		}

		\Hooks::run( 'AfterHttpRequest', [ $method, $this->config->getHost(), $this->serviceName,
										   $start, null ] ); # PLATFORM-2079

		$params = [
			'statusCode' => (int) $code,
			'served-by' => $this->getConfig()->getHost(),
			'reqMethod' => $method,
			'reqUrl' => "http://".$this->getConfig()->getHost().$resourcePath,
			'caller' => $this->serviceName,
			'isOk' => $exception == null,
			'requestTimeMS' => (int)((microtime(true) - $start) * 1000.0)
		];

		if ($exception instanceof \Swagger\Client\ApiException) {
			$params[ 'exception' ] = $exception;
			$level = 'error';
			$message = "HTTP request failed - {$this->serviceName} service";
		}
		else {
			$message = "Http request";
			$level = 'debug';
		}

		// keep sampled logging of all requests, but log all server-side errors (HTTP 500+)
		if ( $this->logSampler->shouldSample() ||  ( $code >= 500 ) ) {
			$this->$level( $message, $params );
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
