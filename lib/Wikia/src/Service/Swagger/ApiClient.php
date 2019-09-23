<?php

namespace Wikia\Service\Swagger;

use Swagger\Client\ApiException;
use Swagger\Client\Configuration;
use Wikia\CircuitBreaker\CircuitBreakerOpen;
use Wikia\CircuitBreaker\ServiceCircuitBreaker;
use Wikia\Factory\ServiceFactory;
use Wikia\Logger\Loggable;
use Wikia\Tracer\WikiaTracer;
use Wikia\Util\Statistics\BernoulliTrial;

class ApiClient extends \Swagger\Client\ApiClient {

	use Loggable;

	/** @var BernoulliTrial */
	private $logSampler;

	/** @var string */
	private $serviceName;

	/** @var ServiceCircuitBreaker */
	private $circuitBreaker;

	public function __construct( Configuration $config, BernoulliTrial $logSampler, string $serviceName) {
		parent::__construct($config);
		$this->logSampler = $logSampler;
		$this->serviceName = $serviceName;
		$this->circuitBreaker = ServiceFactory::instance()->circuitBreakerFactory()->getCircuitBreaker( $serviceName );
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
	 * @throws \FatalError
	 * @throws \MWException
	 * @throws CircuitBreakerOpen
	 */
	public function callApi( $resourcePath, $method, $queryParams, $postData, $headerParams, $responseType = null, $endpointPath = null ) {
		$start = microtime(true);
		$response = $exception = null;
		$code = 200;

		$this->circuitBreaker->assertOperationAllowed();

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

		$this->circuitBreaker->setOperationStatus( $code < 500 && !$exception );

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
