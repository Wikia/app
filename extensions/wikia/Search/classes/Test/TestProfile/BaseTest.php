<?php
namespace Wikia\Search\Test\TestProfile;
use Wikia\Search\Test;
/**
 * Tests for Config class
 */
class BaseTest extends Test\BaseTest
{
	/**
	 * @covers Wikia\Search\TestProfile\Base::getQueryFieldsToBoosts
	 */
	public function testGetQueryFieldsToBoosts() {
		$base = new \Wikia\Search\TestProfile\Base;
		$this->assertAttributeEquals(
				$base->getQueryFieldsToBoosts(),
				'queryFieldsToBoosts',
				$base
		);
	}
	
}