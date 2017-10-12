<?php
namespace Wikia\Logger;

class SyslogHandler extends \Monolog\Handler\SyslogHandler {

	protected function getDefaultFormatter() {
		return new LogstashFormatter();
	}

}
