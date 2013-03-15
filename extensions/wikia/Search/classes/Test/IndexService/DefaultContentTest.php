<?php
/**
 * Class definition for Wikia\Search\Test\IndexService\DefaultContentTest
 */
namespace Wikia\Search\Test\IndexService;
use Wikia\Search\Test\BaseTest, Wikia\Search\IndexService\DefaultContent, ReflectionMethod, ReflectionProperty;
/**
 * Tests the Default Content service, which is pretty thorny
 * @author relwell
 */
class DefaultContentTest extends BaseTest
{
	/**
	 * @covers Wikia\Search\IndexService\DefaultContent::Field
	 */
	public function testField() {
		$dynamicField = \Wikia\Search\Utilities::field( 'html' );
		$mockService = $this->getMock( 'Wikia\Search\MediaWikiService', array( 'getGlobal' ) );
		$utils = $this->getMock( 'Wikia\Search\Utilities', array( 'field' ) );
		$this->proxyClass( 'Wikia\Search\MediaWikiService', $mockService );
		$this->proxyClass( 'Wikia\Search\Utilities', $utils );
		$this->mockApp();
		$dc = new DefaultContent();
		$field = new ReflectionMethod( 'Wikia\Search\IndexService\DefaultContent', 'field' );
		$field->setAccessible( true );
		$mockService
		    ->expects( $this->at( 0 ) )
		    ->method ( 'getGlobal' )
		    ->with   ( 'AppStripsHtml' )
		    ->will   ( $this->returnValue( true ) )
		;
		$utils
		    ->staticExpects( $this->once() )
		    ->method       ( 'field' )
		    ->with         ( 'html' )
		    ->will         ( $this->returnValue( $dynamicField ) )
		;
		$this->assertEquals(
				$dynamicField,
				$field->invoke( $dc, 'html' )
		);
		$mockService
		    ->expects( $this->at( 0 ) )
		    ->method ( 'getGlobal' )
		    ->with   ( 'AppStripsHtml' )
		    ->will   ( $this->returnValue( false ) )
		;
		$this->assertEquals(
				'html',
				$field->invoke( $dc, 'html' )
		);
	}
	
}