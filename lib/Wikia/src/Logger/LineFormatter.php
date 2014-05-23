<?php


namespace Wikia\Logger;

class LineFormatter extends \Monolog\Formatter\LineFormatter implements DevModeFormatterInterface {

	private $devMode = false;

	public function enableDevMode() {
		$this->devMode = true;
	}

	public function disableDevMode() {
		$this->devMode = false;
	}

	public function isInDevMode() {
		return $this->devMode === true;
	}

}
