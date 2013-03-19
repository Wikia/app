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
	
	/**
	 * @covers Wikia\Search\Utilities::sanitizeQuery
	 */
	public function testSanitizeQuery() {
		$qh = $this->getMock( 'Solarium_Query_Helper', array( 'escapeTerm' ) );
		$qhRefl = new \ReflectionProperty( 'Wikia\Search\Utilities', 'queryHelper' );
		$qhRefl->setAccessible( true );
		$qhRefl->setValue( null );
		$qh
		    ->expects( $this->once() )
		    ->method ( 'escapeTerm' )
		    ->with   ( '123 foo?' )
		    ->will   ( $this->returnValue( '123 foo\?' ) ) 
		;
		$this->proxyClass( 'Solarium_Query_Helper', $qh );
		$this->mockApp();
		$this->assertEquals(
				'123 foo\?',
				Utils::sanitizeQuery( '123foo?' )
		);
	}
}