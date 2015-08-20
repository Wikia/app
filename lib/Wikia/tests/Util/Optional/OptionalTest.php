<?php

use Wikia\Util\Optional\Optional;

class OptionalTest extends PHPUnit_Framework_TestCase {

	public function testIsPresent() {
		$this->assertFalse(Optional::emptyOptional()->isPresent());
		$this->assertTrue(Optional::of(5)->isPresent());
		$this->assertTrue(Optional::ofNullable("hi")->isPresent());
		$this->assertFalse(Optional::ofNullable(null)->isPresent());
	}

	public function testValid() {
		$optional = Optional::of("test");

		$this->assertTrue($optional->isPresent());
		$this->assertEquals("test", $optional->get());
		$this->assertEquals("test", $optional->orElse("other"));
		$this->assertEquals("test", $optional->orElseThrow());
	}

	/**
	 * @expectedException Wikia\Util\AssertionException
	 */
	public function testNullWhenUsingOf() {
		Optional::of(null);
	}

	/**
	 * @expectedException Wikia\Util\Optional\InvalidOptionalOperation
	 */
	public function testGetWhenNotPresent() {
		Optional::emptyOptional()->get();
	}

	public function testOrElseWhenNotPresent() {
		$this->assertEquals(5, Optional::emptyOptional()->orElse(5));
	}

	/**
	 * @expectedException Wikia\Util\Optional\InvalidOptionalOperation
	 */
	public function testOrElseThrowWhenNotPresent() {
		Optional::emptyOptional()->orElseThrow();
	}

	/**
	 * @expectedException Exception
	 */
	public function testOrElseThrowWhenNotPresentCustomException() {
		Optional::emptyOptional()->orElseThrow(new Exception());
	}
}
