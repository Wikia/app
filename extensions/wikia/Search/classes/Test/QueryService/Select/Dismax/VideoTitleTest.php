<?php
/**
 * Class definition for Wikia\Search\Test\QueryService\Select\Dismax\VideoTitleTest
 */
namespace Wikia\Search\Test\QueryService\Select;
use Wikia\Search\Test\BaseTest, ReflectionMethod, Wikia\Search\QueryService\DependencyContainer, Wikia\Search\QueryService\Select\Video;
/**
 * Tests the functionality of Wikia\Search\QueryService\Select\Dismax\VideoTitle
 * @author relwell
 */
class VideoTitleTest extends BaseTest
{
	/**
	 * @covers Wikia\Search\QueryService\Select\Dismax\VideoTitle::getSelectQuery
	 */
	public function testGetSelectQuery() {
		$mockClient = $this->getMockBuilder( 'Solarium_Client' )
		                   ->disableOriginalConstructor()
		                   ->setMethods( [ 'createSelect' ] )
		                   ->getMock();
		
		$mockSolariumQuery = $this->getMockBuilder( 'Solarium_Query_Select' )
		                          ->disableOriginalConstructor()
		                          ->setMethods( [ 'setDocumentClass', 'getDismax', 'setQuery' ] )
		                          ->getMock();
		
		$mockDismax = $this->getMockBuilder( 'Solarium_Query_Select_Component_DisMax' )
		                   ->disableOriginalConstructor()
		                   ->setMethods( [ 'setQueryParser', 'setQueryFields', 'setMinimumMatch', 'setPhraseFields', 'setPhraseSlop' ] )
		                   ->getMock();
		
		$mockService = $this->getMock( 'Wikia\Search\MediaWikiService', [ 'getHubForWikiId', 'getWikiId' ] );
		
		$mockConfig = $this->getMock( 'Wikia\Search\Config', [ 'getMinimumMatch', 'getQuery' ] );

		$dc = new \Wikia\Search\QueryService\DependencyContainer( [ 'client' => $mockClient, 'service' => $mockService, 'config' => $mockConfig ] );
		
		$mockSelect = $this->getMockBuilder( 'Wikia\Search\QueryService\Select\Dismax\VideoTitle' )
		                   ->setConstructorArgs( [ $dc ] )
		                   ->getMock();
		
		$mockQuery = $this->getMock( 'Wikia\Search\Query\Select', [ 'getSanitizedQuery' ], [ 'foo' ] );
		
		$mockClient
		    ->expects( $this->once() )
		    ->method ( 'createSelect' )
		    ->will   ( $this->returnValue( $mockSolariumQuery ) )
		;
		$mockSolariumQuery
		    ->expects( $this->once() )
		    ->method ( 'setDocumentClass' )
		    ->with   ( '\Wikia\Search\Result' )
		;
		$mockSolariumQuery
		    ->expects( $this->once() )
		    ->method ( 'getDismax' )
		    ->will   ( $this->returnValue( $mockDismax ) )
		;
		$mockDismax
		    ->expects( $this->once() )
		    ->method ( 'setQueryParser' )
		    ->with   ( 'edismax' )
		    ->will   ( $this->returnValue( $mockDismax ) )
		;
		$mockDismax
		    ->expects( $this->once() )
		    ->method ( 'setQueryFields' )
		    ->with   ( 'title_en' )
		    ->will   ( $this->returnValue( $mockDismax ) )
		;
		$mockDismax
		    ->expects( $this->once() )
		    ->method ( 'setPhraseFields' )
		    ->with   ( 'title_en' )
		    ->will   ( $this->returnValue( $mockDismax ) )
		;
		$mockDismax
		    ->expects( $this->once() )
		    ->method ( 'setPhraseSlop' )
		    ->with   ( 4 )
		    ->will   ( $this->returnValue( $mockDismax ) )
		;
		$mockConfig
		    ->expects( $this->once() )
		    ->method ( 'getMinimumMatch' )
		    ->will   ( $this->returnValue( '80%' ) )
		;
		$mockDismax
		    ->expects( $this->once() )
		    ->method ( 'setMinimumMatch' )
		    ->with   ( '80%' )
		    ->will   ( $this->returnValue( $mockDismax ) )
		;
		$mockService
		    ->expects( $this->once() )
		    ->method ( 'getWikiId' )
		    ->will   ( $this->returnValue( 123 ) )
		;
		$mockService
		    ->expects( $this->once() )
		    ->method ( 'getHubForWikiId' )
		    ->with   ( 123 )
		    ->will   ( $this->returnValue( 'Entertainment' ) ) 
		;
		$mockConfig
		    ->expects( $this->once() )
		    ->method ( 'getQuery' )
		    ->will   ( $this->returnValue( $mockQuery ) )
		;
		$mockQuery
		    ->expects( $this->once() )
		    ->method ( 'getSanitizedQuery' )
		    ->will  ( $this->returnValue( 'foo' ) )
		;
		$params = [ \Wikia\Search\QueryService\Select\Dismax\Video::VIDEO_WIKI_ID, 'Entertainment', 'foo' ];
		$mockSolariumQuery
		    ->expects( $this->once() )
		    ->method ( 'setQuery' )
		    ->with   ( "+(wid:%1% AND is_video:true AND categories_mv_en:%2%) AND +(%3%)", $params )
		;
		$getSelect = new ReflectionMethod( 'Wikia\Search\QueryService\Select\Dismax\VideoTitle', 'getSelectQuery' );
		$getSelect->setAccessible( true );
		$this->assertEquals(
				$mockSolariumQuery,
				$getSelect->invoke( $mockSelect )
		);
	}
	
}