<?php

namespace Wikia\CircuitBreaker;

class RatioBasedCircuitBreaker extends CircuitBreaker {

	protected $failureRatio, $successRatio;
	protected $delayInSec;

	public function __construct($serviceName, DataStorage $dataStorage,
								Ratio $failureRatio, Ratio $successRatio, $delayInSec) {
		parent::__construct($serviceName, $dataStorage);
		$this->failureRatio = $failureRatio;
		$this->successRatio = $successRatio;
		$this->delayInSec = $delayInSec;
		$this->maxHistoryLength = max($this->failureRatio->getDenominator(), $this->successRatio->getDenominator());
	}

	protected function loadData() {
		$r = $this->dataStorage->fetch($this->serviceName);
		if (!empty($r)) {
			$data = json_decode($r, true);
			if ( $data['state'] === State::OPEN &&
				( $data['lastFailureTS'] + $this->delayInSec ) < $this->getmicrotime() ) {
				$data['state'] = State::HALFOPEN;
			}
			return $data;
		}
		return [
			'state' => State::CLOSED,
			'attempts' => [],
			'lastFailureTS' => 0.0
		];
	}

	private function getmicrotime() {
    	list($usec, $sec) = explode(" ",microtime());
    	return ((float)$usec + (float)$sec);
    }

	protected function saveData($data) {
		$this->dataStorage->store($this->serviceName, json_encode($data));
	}

	public function isAvailable() {
		$data = $this->loadData();
		return ($data['state'] !== State::OPEN);
	}

	protected function addOperation($success) {
		$data = $this->loadData();

		$data['attempts'][] = $success;
		if (count($data['attempts']) > $this->maxHistoryLength) {
			$data['attempts'] = array_slice( $data['attempts'], -$this->maxHistoryLength );
		}

		// update the state?
		if ($success) {
			if ($data['state'] === State::HALFOPEN) {
				$history = array_slice($data['attempts'], -$this->successRatio->getDenominator());
				if ( count(array_filter($history)) >= $this->successRatio->getNumerator()) {
					$data['state'] = State::OPEN;
					$data['attempts'] = [];
					// TODO: LOG THE STATE CHANGE!
				}
			}
		} else {
			// failure
			$data['lastFailureTS'] = $this->getmicrotime();
			if ($data['state'] === State::CLOSED || $data['state'] === State::HALFOPEN ) {
				$history = array_slice($data['attempts'], -$this->failureRatio->getDenominator());
				$failures = count($history) - count(array_filter($history));
				if ( $failures >= $this->failureRatio->getNumerator() ) {
					$data['state'] = State::OPEN;
					$data['attempts'] = [];
					// TODO: LOG THE STATE CHANGE!
				}
			}
		}
		$this->saveData($data);
	}

	public function success() {
		$this->addOperation(true);
	}

	public function failure(){
		$this->addOperation(false);
	}
}
