<?php

namespace Wikia\Service\Swagger;

use Swagger\Client\ApiException;
use Swagger\Client\Configuration;
use Wikia\CircuitBreaker\CircuitBreaker;
use Wikia\CircuitBreaker\CircuitBreakerOpen;
use Wikia\CircuitBreaker\ExternalCircuitBreaker;
use Wikia\Logger\Loggable;
use Wikia\Tracer\WikiaTracer;
use Wikia\Util\Statistics\BernoulliTrial;

class ApiClient extends \Swagger\Client\ApiClient {

	use Loggable;

	/** @var BernoulliTrial */
	private $logSampler;

	/** @var string */
	private $serviceName;

	/** @var CircuitBreaker */
	private $circuitBreaker;

	public function __construct(Configuration $config, BernoulliTrial $logSampler,
								CircuitBreaker $circuitBreaker, $serviceName) {
		parent::__construct($config);
		$this->logSampler = $logSampler;
		$this->serviceName = $serviceName;
		$this->circuitBreaker = $circuitBreaker;
	}

	/**
	 * @param string $resourcePath
	 * @param string $method
	 * @param array $queryParams
	 * @param array $postData
	 * @param array $headerParams
	 * @param string|null $responseType
	 * @param string|null $endpointPath
	 * @return mixed|null
	 * @throws ApiException
	 * @throws CircuitBreakerOpen
	 * @throws \FatalError
	 * @throws \MWException
	 */
	public function callApi( $resourcePath, $method, $queryParams, $postData, $headerParams, $responseType=null, $endpointPath=null) {
		$start = microtime(true);
		$response = $exception = null;
		$code = 200;

		if ( !$this->circuitBreaker->OperationAllowed( $this->serviceName ) ) {
			if ( $this->logSampler->shouldSample() ) {
				$this->warning("[circuit breaker] open", [
					'reqMethod' => $method,
					'reqUrl' => "http://".$this->getConfig()->getHost().$resourcePath,
					'caller' => $this->serviceName,
				]);
			}
			throw new CircuitBreakerOpen( $this->serviceName );
		}

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

		$this->circuitBreaker->SetOperationStatus( $this->serviceName, $code < 500 && !$exception );

		// keep sampled logging of all requests, but log all server-side errors (HTTP 500+)
		if ( $this->logSampler->shouldSample() || ( $code >= 500 ) ) {
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
