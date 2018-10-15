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
		$this->setCachedStatus( self::STARTED );
	}

	public function markAsFinished() {
		$this->setCachedStatus( self::FINISHED );
	}

	public function markAsAborted() {
		$this->setCachedStatus( self::ABORTED );
	}

	public function isRunning() {
		return $this->getCachedStatus() === self::STARTED;
	}

	private function setCachedStatus( $status ) {
		global $wgMemc;

		$wgMemc->set( $this->cacheKey, $status, self::TTL );
	}

	private function getCachedStatus() {
		global $wgMemc;

		return $wgMemc->get( $this->cacheKey );
	}
}
