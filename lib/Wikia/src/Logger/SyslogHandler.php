<?php
namespace Wikia\Logger;

class SyslogHandler extends \Monolog\Handler\SyslogHandler {

	// all logs go to ELK by default
	protected function getDefaultFormatter() {
		return new LogstashFormatter(null);
	}

}
