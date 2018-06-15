<?php
namespace Wikia\Logger;

use PHPUnit\Framework\TestCase;

class StatusProcessorTest extends TestCase {

	/** @var StatusProcessor $statusProcessor */
	private $statusProcessor;

	protected function setUp() {
		parent::setUp();

		$this->statusProcessor = new StatusProcessor();
	}

	public function testFormatStatusOk() {
		$record = [
			'context' => [
				'a_status' => \Status::newGood( 1791 )
			]
		];

		$formatted = call_user_func( $this->statusProcessor, $record );

		$this->assertTrue( $formatted['context']['a_status']['is_ok'] );
		$this->assertEquals( 1791, $formatted['context']['a_status']['value'] );
	}


	public function testFormatStatusFatal() {
		$record = [
			'context' => [
				'failed_status' => \Status::newFatal( 'there was an error' )
			]
		];

		$formatted = call_user_func( $this->statusProcessor, $record );

		$this->assertFalse( $formatted['context']['failed_status']['is_ok'] );
		$this->assertContains( 'there was an error', $formatted['context']['failed_status']['message'] );
	}
}
