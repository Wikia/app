<?php
/**
 * Wikia\Logger\SyslogHandler tests
 */

use Wikia\Logger\SyslogHandler;
use PHPUnit\Framework\TestCase;

class SyslogHandlerTest extends TestCase {

	function testGetFormatter() {
		$handler = new SyslogHandler('test');
		$this->assertTrue($handler->getFormatter() instanceof \Wikia\Logger\LogstashFormatter);
	}

}

