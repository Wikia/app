<?php
namespace Wikia\Measurements;

use PHPUnit\Framework\TestCase;

class DummyDriverTest extends TestCase {
	public function testCanUse() {
		$this->assertTrue( (new DummyDriver())->canUse() );
	}
}
