<?php
/**
 * Class definition for Wikia\Search\Test\QueryService\Select\Dismax\CombinedMediaTest
 */
namespace Wikia\Search\Test\QueryService\Select\Dismax;

use ReflectionMethod;
use Wikia\Search\Test\BaseTest;

/**
 * Tests the functionality of the CombinedMedia QueryService
 */
class CombinedMediaTest extends BaseTest
{

	const CLASSNAME = 'Wikia\Search\QueryService\Select\Dismax\CombinedMedia';
	
	/**
	 * @covers \Wikia\Search\QueryService\Select\Dismax\CombinedMedia::getQueryClausesString
	 */
	public function testGetQueryClausesStringIncludesPhotos() {
		$qs = $this->getMockBuilder( self::CLASSNAME )
		           ->disableOriginalConstructor()
		           ->setMethods( [ 'getConfig' ] )
		           ->getMock();
		
		$config = $this->getMock( 'Wikia\Search\Config' );
		
		$qs
		    ->expects( $this->once() )
		    ->method ( "getConfig" )
		    ->will   ( $this->returnValue( $config ) )
		;
		$config
		    ->expects( $this->once() )
		    ->method ( "getWikiId" )
		    ->will   ( $this->returnValue( 123 ) )
		;
		$config
		    ->expects( $this->once() )
		    ->method ( "getCombinedMediaSearchIsVideoOnly" )
		    ->will   ( $this->returnValue( false ) )
		;
		$get = new ReflectionMethod( $qs, 'getQueryClausesString' );
		$get->setAccessible( true );
		$this->assertEquals(
				sprintf( '(+(wid:123) AND (ns:%d))',  \NS_FILE ),
				$get->invoke( $qs )
		);
	}
	
	/**
	 * @covers \Wikia\Search\QueryService\Select\Dismax\CombinedMedia::getQueryClausesString
	 */
	public function testGetQueryClausesStringNotIncludesPhotos() {
		$qs = $this->getMockBuilder( self::CLASSNAME )
		           ->disableOriginalConstructor()
		           ->setMethods( [ 'getConfig' ] )
		           ->getMock();
		
		$config = $this->getMock( 'Wikia\Search\Config' );
		
		$qs
		    ->expects( $this->once() )
		    ->method ( "getConfig" )
		    ->will   ( $this->returnValue( $config ) )
		;
		$config
		    ->expects( $this->once() )
		    ->method ( "getWikiId" )
		    ->will   ( $this->returnValue( 123 ) )
		;
		$config
		    ->expects( $this->once() )
		    ->method ( "getCombinedMediaSearchIsVideoOnly" )
		    ->will   ( $this->returnValue( true ) )
		;
		$get = new ReflectionMethod( $qs, 'getQueryClausesString' );
		$get->setAccessible( true );
		$this->assertEquals(
				sprintf( '(+(wid:123) AND (ns:%d) AND (is_video:true))', \NS_FILE ),
				$get->invoke( $qs )
		);
	}
}
