<?php
/**
 * Wikia\Logger\SyslogHandler tests
 */

use Wikia\Logger\SyslogHandler;
use Monolog\Formatter\LineFormatter;

class SyslogHandlerTest extends PHPUnit_Framework_TestCase {

	function testGetFormatter() {
		$handler = new SyslogHandler('test');
		$this->assertTrue($handler->setModeLogstashFormat()->getFormatter() instanceof \Wikia\Logger\LogstashFormatter);
		$this->assertTrue($handler->setModeLineFormat()->getFormatter() instanceof \Monolog\Formatter\LineFormatter);
	}

}

