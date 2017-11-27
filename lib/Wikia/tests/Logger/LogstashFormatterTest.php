<?php
/**
 * Wikia\Logger\LogstashFormatter tests
 */

use Wikia\Logger\LogstashFormatter;
use PHPUnit\Framework\TestCase;

/**
 * @group WikiaLogger
 */
class LogstashFormatterTest extends TestCase {

	function testNormalizePath() {
		global $IP;
		$this->assertEquals( '/foo/bar', LogstashFormatter::normalizePath( $IP . '/foo/bar') );
		$this->assertEquals( '/lib/Wikia/tests/Logger/LogstashFormatterTest.php', LogstashFormatter::normalizePath( __FILE__ ) );
	}

	function testNormalizeException() {
		global $IP;
		$ex = new Exception();

		$handler = new LogstashFormatter('test');
		$data = $handler->normalizeException($ex);

		$this->assertFalse( startsWith( $data['trace'][1], $IP ) );
		$this->assertTrue( startsWith( $data['trace'][1], '/lib' ) );

		$this->assertFalse( startsWith( $data['file'], $IP ) );
		$this->assertTrue( startsWith( $data['file'], '/lib' ) );
	}
}
