<?php

use Wikia\CircuitBreaker\CircuitBreaker;
use Wikia\CircuitBreaker\CircuitBreakerFactory;
use Wikia\Util\Statistics\BernoulliTrial;

class CircuitBreakerWrapper {

	private static $cbInstanceLocal;
	private static $cbInstanceExternal;
	private static $cbInstanceNoop;

	private function __construct() { }

	private static function populateInstances() {

		$sampler = new BernoulliTrial(0.01);

		global $wgCircuitBreakerType;

		$wgCircuitBreakerType = 'local';
		self::$cbInstanceLocal = CircuitBreakerFactory::GetCircuitBreaker($sampler);

		$wgCircuitBreakerType = 'external';
		self::$cbInstanceExternal = CircuitBreakerFactory::GetCircuitBreaker($sampler);

		$wgCircuitBreakerType = 'noop';
		self::$cbInstanceNoop = CircuitBreakerFactory::GetCircuitBreaker($sampler);
	}

	public static function getInstance( $type ) {

		if ( !self::$cbInstanceNoop || !self::$cbInstanceExternal || !self::$cbInstanceLocal ) {
			self::populateInstances();
		}

		switch ( $type ) {
			case 'local':
				return self::$cbInstanceLocal;
			case 'external':
				return self::$cbInstanceExternal;
			default:
				return self::$cbInstanceNoop;
		}
	}
}

class WikiaCBTestingController extends WikiaController {

	/** @var CircuitBreaker*/
	private $circuitBreakerNoop;

	/** @var CircuitBreaker*/
	private $circuitBreakerLocal;

	/** @var CircuitBreaker*/
	private $circuitBreakerExternal;

	public function __construct() {
		parent::__construct();

		$this->circuitBreakerNoop = CircuitBreakerWrapper::getInstance('noop');
		$this->circuitBreakerExternal = CircuitBreakerWrapper::getInstance('external');
		$this->circuitBreakerLocal = CircuitBreakerWrapper::getInstance('local');
	}

	public function mockSuccessfulServiceCallNoop() {
		$this->response->setCode(201);
		if ($this->circuitBreakerNoop->OperationAllowed( 'testOperation' )) {
			// Do nothing
			$this->circuitBreakerNoop->SetOperationStatus( 'testOperation', true ); // set status to success
			$this->response->setBody('Closed');
		} else {
			$this->response->setBody('Open');
		}
	}

	public function mockSuccessfulServiceCallLocal() {
		$this->response->setCode(202);
		if ($this->circuitBreakerLocal->OperationAllowed( 'testOperation' )) {
			// Do nothing
			$this->circuitBreakerLocal->SetOperationStatus( 'testOperation', true ); // set status to success
			$this->response->setBody('Closed');
		} else {
			$this->response->setBody('Open');
		}
	}

	public function mockSuccessfulServiceCallExternal() {
		$this->response->setCode(203);
		if ($this->circuitBreakerExternal->OperationAllowed( 'testOperation' )) {
			// Do nothing
			$this->circuitBreakerExternal->SetOperationStatus( 'testOperation', true ); // set status to success
			$this->response->setBody('Closed');
		} else {
			$this->response->setBody('Open');
		}
	}
}
