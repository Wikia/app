<?php
namespace Wikia\Logger;

use Monolog\Formatter\LineFormatter;

class SyslogHandler extends \Monolog\Handler\SyslogHandler {
	protected function getDefaultFormatter() {
		global $wgDevelEnvironment;

		if ($wgDevelEnvironment) {
			return new LineFormatter('%message%');
		} else {
			return new LogstashFormatter(null);
		}
	}
}