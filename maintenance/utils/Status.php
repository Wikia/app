<?php

class MaintenanceStatus {
	private $cacheKey = null;

	const STARTED = 'STARTED';
	const ABORTED = 'ABORTED';
	const FINISHED = 'FINISHED';
	const TTL = 7200; // 2h in seconds

	public function __construct( $taskName ) {
		$this->cacheKey = wfMemcKey( $taskName . '_status' );
	}

	public function markAsStarted() {
		$this->setCachedStatus( MaintenanceStatus::STARTED );
	}

	public function markAsFinished() {
		$this->setCachedStatus( MaintenanceStatus::FINISHED );
	}

	public function markAsAborted() {
		$this->setCachedStatus( MaintenanceStatus::ABORTED );
	}

	public function isRunning() {
		return $this->getCachedStatus() === MaintenanceStatus::STARTED;
	}

	private function setCachedStatus( $status ) {
		global $wgMemc;

		$wgMemc->set( $this->cacheKey, $status, MaintenanceStatus::TTL );
	}

	private function getCachedStatus() {
		global $wgMemc;

		return $wgMemc->get( $this->cacheKey );
	}
}
