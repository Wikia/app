<?php
/**
 * Class definition for Wikia\Search\Test\QueryService\Select\Dismax\CombinedMediaTest
 */
namespace Wikia\Search\Test\QueryService\Select\Dismax;
use Wikia\Search\Test\BaseTest, Wikia\Search\Utilities, \Wikia\Search\QueryService\Select\Dismax\Video, ReflectionMethod;
/**
 * Tests the functionality of the CombinedMedia QueryService
 */
class CombinedMediaTest extends BaseTest
{

	/**
	 * @covers Wikia\Search\QueryService\Select\Dismax\CombinedMedia::getQueryClausesString
	 */
	public function testGetQueryClausesStringIncludesPhotos() {
		$qs = $this->getMockBuilder( 'Wikia\Search\QueryService\Select\Dismax\CombinedMedia' )
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
				sprintf( '(+(wid:%d OR wid:123) AND (ns:%d))', Video::VIDEO_WIKI_ID, \NS_FILE ),
				$get->invoke( $qs )
		);
	}
	
	/**
	 * @covers Wikia\Search\QueryService\Select\Dismax\CombinedMedia::getQueryClausesString
	 */
	public function testGetQueryClausesStringNotIncludesPhotos() {
		$qs = $this->getMockBuilder( 'Wikia\Search\QueryService\Select\Dismax\CombinedMedia' )
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
				sprintf( '(+(wid:%d OR wid:123) AND (ns:%d) AND (is_video:true))', Video::VIDEO_WIKI_ID, \NS_FILE ),
				$get->invoke( $qs )
		);
	}
	
}