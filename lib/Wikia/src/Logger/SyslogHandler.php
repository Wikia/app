<?php
namespace Wikia\Logger;

class SyslogHandler extends \Monolog\Handler\SyslogHandler implements DevModeFormatterInterface {

	const LINEFORMATTER_FORMAT = '%message%';

	private $devMode = false;

	public function enableDevMode() {
		$this->devMode = true;
		$this->getFormatter()->enableDevMode();
	}

	public function disableDevMode() {
		$this->devMode = false;
		$this->getFormatter()->disableDevMode();
	}

	public function isInDevMode() {
		return $this->devMode === true;
	}

	public function setModeLineFormat() {
		$this->setFormatter(new LineFormatter(self::LINEFORMATTER_FORMAT));
		return $this;
	}

	public function setModeLogstashFormat() {
		$this->setFormatter(new LogstashFormatter(null));
		return $this;
	}

	protected function getDefaultFormatter() {
		return new LineFormatter(self::LINEFORMATTER_FORMAT);
	}

}
