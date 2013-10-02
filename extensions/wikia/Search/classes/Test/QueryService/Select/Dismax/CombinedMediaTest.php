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

	const CLASSNAME = 'Wikia\Search\QueryService\Select\Dismax\CombinedMedia';
	
	/**
	 * @covers Wikia\Search\QueryService\Select\Dismax\CombinedMedia::getQueryClausesString
	 */
	public function testGetQueryClausesStringIncludesPhotos() {
		$qs = $this->getMockBuilder( self::CLASSNAME )
		           ->disableOriginalConstructor()
		           ->setMethods( [ 'getConfig', 'getTopicsAsQuery' ] )
		           ->getMock();
		
		$config = $this->getMock( 'Wikia\Search\Config' );
		
		$qs
		    ->expects( $this->once() )
		    ->method ( "getConfig" )
		    ->will   ( $this->returnValue( $config ) )
		;
		$qs
		    ->expects( $this->once() )
		    ->method ( 'getTopicsAsQuery' )
		    ->will   ( $this->returnValue( '"foo" OR "bar"'  ) )
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
				sprintf( '(+((wid:%d AND ("foo" OR "bar")) OR wid:123) AND (ns:%d))', Video::VIDEO_WIKI_ID, \NS_FILE ),
				$get->invoke( $qs )
		);
	}
	
	/**
	 * @covers Wikia\Search\QueryService\Select\Dismax\CombinedMedia::getQueryClausesString
	 */
	public function testGetQueryClausesStringNotIncludesPhotos() {
		$qs = $this->getMockBuilder( self::CLASSNAME )
		           ->disableOriginalConstructor()
		           ->setMethods( [ 'getConfig', 'getTopicsAsQuery' ] )
		           ->getMock();
		
		$config = $this->getMock( 'Wikia\Search\Config' );
		
		$qs
		    ->expects( $this->once() )
		    ->method ( "getConfig" )
		    ->will   ( $this->returnValue( $config ) )
		;
		$qs
		    ->expects( $this->once() )
		    ->method ( 'getTopicsAsQuery' )
		    ->will   ( $this->returnValue( '"foo" OR "bar"'  ) )
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
				sprintf( '(+((wid:%d AND ("foo" OR "bar")) OR wid:123) AND (ns:%d) AND (is_video:true))', Video::VIDEO_WIKI_ID, \NS_FILE ),
				$get->invoke( $qs )
		);
	}
	
	/**
	 * @covers Wikia\Search\QueryService\Select\Dismax\CombinedMedia::getTopicsAsQuery
	 */
	public function testGetTopicsAsQueryWithTopics() {
		$service = $this->getMockBuilder( self::CLASSNAME )
		                ->disableOriginalConstructor()
		                ->setMethods( [ 'getService' ] )
		                ->getMock();
		
		$mwService = $this->getMock( 'Wikia\Search\MediaWikiService', [ 'getGlobalWithDefault' ] );
		
		$service
		    ->expects( $this->once() )
		    ->method ( 'getService' )
		    ->will   ( $this->returnValue( $mwService ) )
		;
		$mwService
		    ->expects( $this->at( 0 ) )
		    ->method ( 'getGlobalWithDefault' )
		    ->with   ( 'WikiVideoSearchTopics', [] )
		    ->will   ( $this->returnValue( [ 'topic 1', 'topic2' ] ) )
		;
		
		$get = new ReflectionMethod( self::CLASSNAME, 'getTopicsAsQuery' );
		$get->setAccessible( true );
		$this->assertEquals(
				'"topic 1" OR "topic2"',
				$get->invoke( $service )
		);
	}
	
	/**
	 * @covers Wikia\Search\QueryService\Select\Dismax\CombinedMedia::getTopicsAsQuery
	 */
	public function testGetTopicsAsQueryNoTopics() {
		$service = $this->getMockBuilder( self::CLASSNAME )
		                ->disableOriginalConstructor()
		                ->setMethods( [ 'getService' ] )
		                ->getMock();
		
		$mwService = $this->getMock( 'Wikia\Search\MediaWikiService', [ 'getGlobal', 'getGlobalWithDefault' ] );
		
		$service
		    ->expects( $this->once() )
		    ->method ( 'getService' )
		    ->will   ( $this->returnValue( $mwService ) )
		;
		$mwService
		    ->expects( $this->at( 0 ) )
		    ->method ( 'getGlobalWithDefault' )
		    ->with   ( 'WikiVideoSearchTopics', [] )
		    ->will   ( $this->returnValue( [] ) )
		;
		$mwService
		    ->expects( $this->at( 1 ) )
		    ->method ( 'getGlobal' )
		    ->with   ( 'Sitename' )
		    ->will   ( $this->returnValue( 'Diamond Lane Wiki' ) )
		;
		$get = new ReflectionMethod( self::CLASSNAME, 'getTopicsAsQuery' );
		$get->setAccessible( true );
		$this->assertEquals(
				'"diamond lane"',
				$get->invoke( $service )
		);
	}
	
}