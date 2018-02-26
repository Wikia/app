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
	 * @group Slow
	 * @slowExecutionTime 0.09949 ms
	 * @covers Wikia\Search\Utilities::valueForField
	 */
	public function testValueForField() {
		$this->assertEquals(
				'-(wid:"123")^123',
				Utils::valueForField( 'wid', '123', array( 'negate' => true, 'boost' => 123, 'valueQuote' => '"' ) )
		);
	}

	/**
	 * @covers Wikia\Search\Utilities::rangeIntValueField
	 */
	public function testRangeIntValueField() {
		$this->assertEquals(
			'(xx:[* TO 44])',
			Utils::rangeIntValueField( 'xx', null, 44 )
		);

		$this->assertEquals(
			'(xx:[55 TO *])',
			Utils::rangeIntValueField( 'xx', 55 )
		);

		$this->assertEquals(
			'(xx:[22 TO 33])',
			Utils::rangeIntValueField( 'xx', 22, 33 )
		);
	}
	
	/**
	 * @group Slow
	 * @slowExecutionTime 0.09938 ms
	 * @covers Wikia\Search\Utilities::field
	 */
	public function testField() {
		$this->assertEquals(
				Utils::field( 'html', 'fr' ),
				(string) (new \Wikia\Search\Field\Field( 'html', 'fr' ))
		);
	}
}
