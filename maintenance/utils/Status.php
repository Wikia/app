<?php

class MaintenanceStatus {
	private $cacheKey = null;

	private $STARTED = 'STARTED';
	private $ABORTED = 'ABORTED';
	private $FINISHED = 'FINISHED';
	private $TTL = 7200; // 2h in seconds

	public function __construct($taskName) {
		$this->cacheKey = $taskName . '_status';
	}

	public function markAsStarted() {
		$this->setCachedStatus($this->STARTED);
	}

	public function markAsFinished() {
		$this->setCachedStatus($this->FINISHED);
	}

	public function markAsAborted() {
		$this->setCachedStatus($this->ABORTED);
	}

	public function isRunning() {
		return $this->getCachedStatus() === $this->STARTED;
	}
	
	private function setCachedStatus($status) {
		global $wgMemc;

		$wgMemc->set($this->cacheKey, $status, $this->TTL);
	}

	private function getCachedStatus() {
		global $wgMemc;

		return $wgMemc->get($this->cacheKey);
	}
}
