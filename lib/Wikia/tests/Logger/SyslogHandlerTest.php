<?php
/**
 * Wikia\Logger\SyslogHandler tests
 */

use Wikia\Logger\SyslogHandler;

class SyslogHandlerTest extends \PHPUnit\Framework\TestCase {

	function testGetFormatter() {
		$handler = new SyslogHandler('test');
		$this->assertTrue($handler->getFormatter() instanceof \Wikia\Logger\LogstashFormatter);
	}

}

