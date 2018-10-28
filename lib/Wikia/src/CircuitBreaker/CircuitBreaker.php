<?php


namespace Wikia\CircuitBreaker;

use Wikia\Sass\Exception;

abstract class CircuitBreaker {
	protected $serviceName;
	protected $dataStorage;

	public function __construct($serviceName, DataStorage $dataStorage) {
		$this->serviceName = $serviceName;
		$this->dataStorage = $dataStorage;
	}

	abstract public function isAvailable();
	abstract public function success();
	abstract public function failure();

	public function wrapCall( $wrappedFn, $failureTesterFn, $onCBOpenFn) {
		if (!$this->isAvailable()) {
			// TODO: LOG THAT CALL WAS CACELLED
			return $onCBOpenFn();
		}
		try {
			$result = $wrappedFn();
			$this->success();
			return $result;
		} catch(\Exception $e) {
			if ( $failureTesterFn($e) ) {
				$this->success();
			} else {
				$this->failure();
			}
			throw $e;
		}
	}
}
