<?php
namespace Wikia\Logger;

use Monolog\Formatter\LineFormatter;

class SyslogHandler extends \Monolog\Handler\SyslogHandler {
	protected function getDefaultFormatter() {
		global $wgDevelEnvironment, $wgDevESLog;

		if ($wgDevelEnvironment && !$wgDevESLog) {
			$formatter = new LineFormatter('%message%');
		} else {
			$formatter = new LogstashFormatter(null);

			if ($wgDevelEnvironment && $wgDevESLog) {
				$formatter->enableDevMode();
			}
		}

		return $formatter;
	}
}