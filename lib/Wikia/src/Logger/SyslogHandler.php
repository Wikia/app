<?php
namespace Wikia\Logger;
use Monolog\Formatter\LineFormatter;

class SyslogHandler extends \Monolog\Handler\SyslogHandler {

	const LINEFORMATTER_FORMAT = '%message%';

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
