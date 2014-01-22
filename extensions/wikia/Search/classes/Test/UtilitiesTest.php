<?php
/**
 * Class definition for Wikia\Search\Test\UtilitiesTest
 */
namespace Wikia\Search\Test;
use Wikia\Search\Utilities as Utils;
/**
 * Tests utility functions
 * @author relwell
 */
class UtilitiesTest extends BaseTest
{
	/**
	 * @covers Wikia\Search\Utilities::valueForField
	 */
	public function testValueForField() {
		$this->assertEquals(
				'-(wid:"123")^123',
				Utils::valueForField( 'wid', '123', array( 'negate' => true, 'boost' => 123, 'valueQuote' => '"' ) )
		);
	}
	
	/**
	 * @covers Wikia\Search\Utilities::field
	 */
	public function testField() {
		$this->assertEquals(
				Utils::field( 'html', 'fr' ),
				(string) (new \Wikia\Search\Field\Field( 'html', 'fr' ))
		);
	}
}
