<?php
/**
 * Class definition for Wikia\Search\Test\ResultSet\BaseTest
 */
namespace Wikia\Search\Test\ResultSet;
use Wikia, ReflectionMethod, ReflectionProperty;
/**
 * Tests base result set class
 */
class BaseTest extends Wikia\Search\Test\BaseTest {
	
	/**
	 * Convenience method to easily handle the necessary dependencies & method mocking for recurrent mocks
	 * @param array $resultSetMethods
	 * @param array $configMethods
	 * @param array $resultMethods
	 */
	protected function prepareMocks( $resultSetMethods = array(), $configMethods = array(), $resultMethods = array() ) { 
	
		$this->searchResult		=	$this->getMockBuilder( 'Solarium_Result_Select' )
									->disableOriginalConstructor()
									->setMethods( $resultMethods )
									->getMock();
		
		$this->config		=	$this->getMockBuilder( 'WikiaSearchConfig' )
									->disableOriginalConstructor()
									->setMethods( $configMethods )
									->getMock();
		
		$this->resultSet	=	$this->getMockBuilder( '\Wikia\Search\ResultSet\Base' )
									->disableOriginalConstructor()
									->setMethods( $resultSetMethods )
									->getMock();
		
		$reflResult = new ReflectionProperty( '\Wikia\Search\ResultSet\Base', 'searchResultObject' );
		$reflResult->setAccessible( true );
		$reflResult->setValue( $this->resultSet, $this->searchResult );
		
		$reflConfig = new ReflectionProperty(  '\Wikia\Search\ResultSet\Base', 'searchConfig' );
		$reflConfig->setAccessible( true );
		$reflConfig->setValue( $this->resultSet, $this->config );
	}
	
	/**
	 * @covers Wikia\Search\ResultSet\Base::configure
	 */
	public function testConfigure() {
		$mockSet = $this->getMockBuilder( 'Wikia\Search\ResultSet\Base' )
		                ->disableOriginalConstructor()
		                ->setMethods( array( 'prependMatchIfExists', 'setResults', 'handleMatchPrepends' ) )
		                ->getMock();
		$mockResult = $this->getMockBuilder( '\Solarium_Result_Select' )
		                   ->disableOriginalConstructor()
		                   ->setMethods( array( 'getNumFound', 'getDocuments' ) )
		                   ->getMock();
		$config = new Wikia\Search\Config;
		$service = new Wikia\Search\MediaWikiService;
		$dc = new Wikia\Search\ResultSet\DependencyContainer( array( 'config' => $config, 'service' => $service, 'result' => $mockResult ) );
		$docArray = array( 'this value does not actually matter' );
		$mockResult
		    ->expects( $this->once() )
		    ->method ( 'getNumFound' )
		    ->will   ( $this->returnValue( 100 ) )
		;
		$mockResult
		    ->expects( $this->once() )
		    ->method ( 'getDocuments' )
		    ->will   ( $this->returnValue( $docArray ) )
		;
		$mockSet
		    ->expects( $this->once() )
		    ->method ( 'handleMatchPrepends' )
		    ->will   ( $this->returnValue( $mockSet ) )
		;
		$mockSet
		    ->expects( $this->once() )
		    ->method ( 'setResults' )
		    ->will   ( $this->returnValue( $docArray ) )
		;
		$configure = new ReflectionMethod( 'Wikia\Search\ResultSet\Base', 'configure' );
		$configure->setAccessible( true );
		$configure->invoke( $mockSet, $dc );
	}
	
	/**
	 * @covers Wikia\Search\ResultSet\Base::setResults
	 */
	public function testSetResults() {
		$mockSet = $this->getMockBuilder( 'Wikia\Search\ResultSet\Base' )
		                ->disableOriginalConstructor()
		                ->setMethods( array( 'addResult' ) )
		                ->getMock();
		
		$mockResult = $this->getMock( 'Wikia\Search\Result' );
		
		$mockSet
		    ->expects( $this->once() )
		    ->method ( 'addResult' )
		    ->with   ( $mockResult )
		;
		$this->assertEquals(
				$mockSet,
				$mockSet->setResults( array( $mockResult ) )
		);
	}
	/**
	 * @covers \Wikia\Search\ResultSet\Base::addResult
	 */
	public function testAddResult() {
		$this->prepareMocks( array(), array(), array( 'getHighlighting' ) );
		
		$mockSearchResult		= $this->getMockBuilder( 'Wikia\Search\Result' )
									->disableOriginalConstructor()
									->setMethods( array( 'offsetGet', 'setText', 'setVar', 'getVar' ) )
									->getMock();
		
		$mockHighlighting		= $this->getMockBuilder( 'Solarium_Result_Select_Highlighting' )
									->disableOriginalConstructor()
									->setMethods( array( 'getResult' ) )
									->getMock();
		
		$mockHighlightingResult	= $this->getMockBuilder( 'Solarium_Result_Select_Highlighting_Result' )
									->disableOriginalConstructor()
									->setMethods( array( 'getField' ) )
									->getMock();
		
		$mockService = $this->getMockBuilder( 'Wikia\Search\MediaWikiService' )
		                      ->disableOriginalConstructor()
		                      ->setMethods( array( 'getMediaWikiFormattedTimestamp' ) )
		                      ->getMock();
		
		$mockArrayIterator = $this->getMock( '\ArrayIterator' );
		
		$mockId = "123_456";
		$mockHlSnippet = "I can't believe it's not <em>butter</em>!";
		$mockTimestamp = date( 'Y-m-d' ).'T00:00:00Z'; // always today
		$wfts = wfTimestamp( TS_MW, $mockTimestamp );
		
		$mockSearchResult
			->expects	( $this->at( 0 ) )
			->method	( 'offsetGet' )
			->with		( 'id' )
			->will		( $this->returnValue( $mockId ) )
		;
		$this->searchResult
			->expects	( $this->at( 0 ) )
			->method	( 'getHighlighting' )
			->will		( $this->returnValue( $mockHighlighting ) )
		;
		$mockHighlighting
			->expects	( $this->at( 0 ) )
			->method	( 'getResult' )
			->with		( $mockId )
			->will		( $this->returnValue( $mockHighlightingResult ) )
		;
		$mockHighlightingResult
			->expects	( $this->at( 0 ) )
			->method	( 'getField' )
			->with		( Wikia\Search\Utilities::field( 'html' ) )
			->will		( $this->returnValue( array( $mockHlSnippet ) ) )
		;
		$mockSearchResult
			->expects	( $this->at( 1 ) )
			->method	( 'setText' )
			->with		( $mockHlSnippet )
		;
		$mockSearchResult
			->expects	( $this->at( 2 ) )
			->method	( 'offsetGet' )
			->with		( 'created' )
			->will		( $this->returnValue( $mockTimestamp ) )
		;
		$mockSearchResult
			->expects	( $this->at( 3 ) )
			->method	( 'offsetGet' )
			->with		( 'created' )
			->will		( $this->returnValue( $mockTimestamp ) )
		;
		$mockService
		    ->expects( $this->once() )
		    ->method ( 'getMediaWikiFormattedTimestamp' )
		    ->with   ( $mockTimestamp )
		    ->will   ( $this->returnValue( 'Today' ) )
		;
		$mockSearchResult
			->expects	( $this->at( 4 ) )
			->method	( 'setVar' )
			->with		( 'fmt_timestamp', 'Today' )
			->will		( $this->returnValue( $mockSearchResult ) )
		;
		$mockSearchResult
			->expects	( $this->at( 5 ) )
			->method	( 'offsetGet' )
			->with		( 'created' )
			->will		( $this->returnValue( $mockTimestamp ) )
		;
		$mockSearchResult
			->expects	( $this->at( 6 ) )
			->method	( 'setVar' )
			->with		( 'created_30daysago', false )
			->will		( $this->returnValue( $mockSearchResult ) )
		;
		$mockSearchResult
			->expects	( $this->at( 7 ) )
			->method	( 'offsetGet' )
			->with		( 'wikiarticles' )
			->will		( $this->returnValue( 12345 ) )
		;
		$mockSearchResult
			->expects	( $this->at( 8 ) )
			->method	( 'setVar' )
			->with		( 'cityArticlesNum', 12345 )
			->will		( $this->returnValue( $mockSearchResult ) )
		;
		$mockSearchResult
			->expects	( $this->at( 9 ) )
			->method	( 'offsetGet' )
			->with		( Wikia\Search\Utilities::field( 'wikititle' ) )
			->will		( $this->returnValue( "My Wiki" ) )
		;
		$mockSearchResult
			->expects	( $this->at( 10 ) )
			->method	( 'setVar' )
			->with		( 'wikititle', "My Wiki" )
			->will		( $this->returnValue( $mockSearchResult ) )
		;
		$mockArrayIterator
		    ->expects( $this->once() )
		    ->method ( 'offsetSet' )
		    ->with   ( $mockId, $mockSearchResult )
		;
		
		$intRefl = new ReflectionProperty( 'Wikia\Search\ResultSet\Base', 'service' );
		$intRefl->setAccessible( true );
		$intRefl->setValue( $this->resultSet, $mockService );
		
		$global = new ReflectionProperty( '\Wikia\Search\ResultSet\Base', 'results' );
		$global->setAccessible( true );
		$global->setValue( $this->resultSet, $mockArrayIterator );
		
		$addResult = new ReflectionMethod( '\Wikia\Search\ResultSet\Base', 'addResult' );
		$addResult->setAccessible( true );

		$this->assertEquals(
				$this->resultSet,
				$addResult->invoke( $this->resultSet, $mockSearchResult ),
				'\Wikia\Search\ResultSet\Base::addResult should provide a fluent interface'
		);
	}
	

	
	/**
	 * @covers \Wikia\Search\ResultSet\Base::getResultsStart
	 */
	public function testGetResultsStart() {
		$this->prepareMocks( array( 'getResultsFound' ), array(), array( 'getStart' ) );
		
		$this->searchResult
			->expects	( $this->at( 0 ) )
			->method	( 'getStart' )
			->will		( $this->returnValue( 0 ) )
		;
		$this->assertEquals(
				0,
				$this->resultSet->getResultsStart(),
				'\Wikia\Search\ResultSet\Base::getResultsStart should pass the return value of the search result object\'s getStart() method'
		);
	}
	
	/**
	 * @covers \Wikia\Search\ResultSet\Base::getQueryTime
	 */
	public function testGetQueryTime() {
		$this->prepareMocks( null, array(), array( 'getQueryTime' ) );
		
		$this->searchResult
			->expects	( $this->at( 0 ) )
			->method	( 'getQueryTime' )
			->will		( $this->returnValue( 750 ) )
		;
		$this->assertEquals(
				750,
				$this->resultSet->getQueryTime(),
				'\Wikia\Search\ResultSet\Base::getQueryTime should return the value of WikiaSearchConfig::getQueryTime'
		);
	}
	
	/**
	 * @covers Wikia\Search\ResultSet\Base::HandleMatchPrepends
	 */
	public function testHandleMatchPrependsStartNotZero() {
		$this->prepareMocks( [ 'getResultsStart', 'prependWikiMatchIfExists', 'prependArticleMatchIfExists' ], [ 'getInterWiki' ] );
		
		$this->resultSet
		    ->expects( $this->once() )
		    ->method ( "getResultsStart" )
		    ->will   ( $this->returnValue( 5 ) )
		;
		$this->config
		    ->expects( $this->never() )
		    ->method ( 'getInterWiki' )
		;
		$this->resultSet
		    ->expects( $this->never() )
		    ->method ( "prependWikiMatchIfExists" )
		;
		$this->resultSet
		    ->expects( $this->never() )
		    ->method ( "prependArticleMatchIfExists" )
		;
		$handle = new ReflectionMethod( $this->resultSet, 'handleMatchPrepends' );
		$handle->setAccessible( true );
		$this->assertEquals(
				$this->resultSet,
				$handle->invoke( $this->resultSet )
		);
	}
	
	/**
	 * @covers Wikia\Search\ResultSet\Base::HandleMatchPrepends
	 */
	public function testHandleMatchPrependsOnWiki() {
		$this->prepareMocks( [ 'getResultsStart', 'prependWikiMatchIfExists', 'prependArticleMatchIfExists' ], [ 'getInterWiki' ] );
		
		$this->resultSet
		    ->expects( $this->once() )
		    ->method ( "getResultsStart" )
		    ->will   ( $this->returnValue( 0 ) )
		;
		$this->config
		    ->expects( $this->once() )
		    ->method ( 'getInterWiki' )
		    ->will   ( $this->returnValue( false ) )
		;
		$this->resultSet
		    ->expects( $this->never() )
		    ->method ( "prependWikiMatchIfExists" )
		;
		$this->resultSet
		    ->expects( $this->once() )
		    ->method ( "prependArticleMatchIfExists" )
		;
		$handle = new ReflectionMethod( $this->resultSet, 'handleMatchPrepends' );
		$handle->setAccessible( true );
		$this->assertEquals(
				$this->resultSet,
				$handle->invoke( $this->resultSet )
		);
	}
	
	/**
	 * @covers Wikia\Search\ResultSet\Base::HandleMatchPrepends
	 */
	public function testHandleMatchPrependsInterWiki() {
		$this->prepareMocks( [ 'getResultsStart', 'prependWikiMatchIfExists', 'prependArticleMatchIfExists' ], [ 'getInterWiki' ] );
		
		$this->resultSet
		    ->expects( $this->once() )
		    ->method ( "getResultsStart" )
		    ->will   ( $this->returnValue( 0 ) )
		;
		$this->config
		    ->expects( $this->once() )
		    ->method ( 'getInterWiki' )
		    ->will   ( $this->returnValue( true ) )
		;
		$this->resultSet
		    ->expects( $this->once() )
		    ->method ( "prependWikiMatchIfExists" )
		;
		$this->resultSet
		    ->expects( $this->never() )
		    ->method ( "prependArticleMatchIfExists" )
		;
		$handle = new ReflectionMethod( $this->resultSet, 'handleMatchPrepends' );
		$handle->setAccessible( true );
		$this->assertEquals(
				$this->resultSet,
				$handle->invoke( $this->resultSet )
		);
	}
	
	/**
	 * @covers Wikia\Search\ResultSet\Base::prependWikiMatchIfExists
	 */
	public function testPrependWikiMatchNoMatch() {
		$this->prepareMocks( [ 'addMatchResult' ], [ 'hasWikiMatch', 'getWikiMatch' ] );
		$this->config
		    ->expects( $this->once() )
		    ->method ( 'hasWikiMatch' )
		    ->will   ( $this->returnValue( false ) )
		;
		$this->config
		    ->expects( $this->never() )
		    ->method ( 'getWikiMatch' )
		;
		$this->resultSet
		    ->expects( $this->never() )
		    ->method ( "addMatchResult" )
		;
		$prepend = new ReflectionMethod( $this->resultSet, 'prependWikiMatchIfExists' );
		$prepend->setAccessible( true );
		$this->assertEquals(
				$this->resultSet,
				$prepend->invoke( $this->resultSet )
		);
	}
	
	/**
	 * @covers Wikia\Search\ResultSet\Base::prependWikiMatchIfExists
	 */
	public function testPrependWikiMatchWithMatch() {
		$this->prepareMocks( [ 'addMatchResult' ], [ 'hasWikiMatch', 'getWikiMatch' ] );
		$mockWikiMatch = $this->getMockBuilder( 'Wikia\Search\Match\Wiki' )
		                      ->disableOriginalConstructor()
		                      ->getMock();
		$this->config
		    ->expects( $this->once() )
		    ->method ( 'hasWikiMatch' )
		    ->will   ( $this->returnValue( true ) )
		;
		$this->config
		    ->expects( $this->once() )
		    ->method ( 'getWikiMatch' )
		    ->will   ( $this->returnValue( $mockWikiMatch ) )
		;
		$this->resultSet
		    ->expects( $this->once() )
		    ->method ( "addMatchResult" )
		    ->with   ( $mockWikiMatch )
		;
		$prepend = new ReflectionMethod( $this->resultSet, 'prependWikiMatchIfExists' );
		$prepend->setAccessible( true );
		$this->assertEquals(
				$this->resultSet,
				$prepend->invoke( $this->resultSet )
		);
	}
	
	/**
	 * @covers Wikia\Search\ResultSet\Base::prependArticleMatchIfExists
	 */
	public function testPrependArticleMatchNoMatch() {
		$this->prepareMocks( [ 'addMatchResult' ], [ 'hasArticleMatch', 'getArticleMatch' ] );
		$this->config
		    ->expects( $this->once() )
		    ->method ( 'hasArticleMatch' )
		    ->will   ( $this->returnValue( false ) )
		;
		$this->config
		    ->expects( $this->never() )
		    ->method ( 'getArticleMatch' )
		;
		$this->resultSet
		    ->expects( $this->never() )
		    ->method ( "addMatchResult" )
		;
		$prepend = new ReflectionMethod( $this->resultSet, 'prependArticleMatchIfExists' );
		$prepend->setAccessible( true );
		$this->assertEquals(
				$this->resultSet,
				$prepend->invoke( $this->resultSet )
		);
	}
	
	/**
	 * @covers Wikia\Search\ResultSet\Base::prependArticleMatchIfExists
	 */
	public function testPrependArticleMatchWithMatch() {
		$this->prepareMocks( [ 'addMatchResult' ], [ 'hasArticleMatch', 'getArticleMatch' ] );
		$mockArticleMatch = $this->getMockBuilder( 'Wikia\Search\Match\Article' )
		                      ->disableOriginalConstructor()
		                      ->getMock();
		$this->config
		    ->expects( $this->once() )
		    ->method ( 'hasArticleMatch' )
		    ->will   ( $this->returnValue( true ) )
		;
		$this->config
		    ->expects( $this->once() )
		    ->method ( 'getArticleMatch' )
		    ->will   ( $this->returnValue( $mockArticleMatch ) )
		;
		$this->resultSet
		    ->expects( $this->once() )
		    ->method ( "addMatchResult" )
		    ->with   ( $mockArticleMatch )
		;
		$prepend = new ReflectionMethod( $this->resultSet, 'prependArticleMatchIfExists' );
		$prepend->setAccessible( true );
		$this->assertEquals(
				$this->resultSet,
				$prepend->invoke( $this->resultSet )
		);
	}
	
	
	/**
	 * @covers \Wikia\Search\ResultSet\Base::isOnlyArticleMatchFound
	 */
	public function testIsOnlyArticleMatchFoundWrongResultNum() {
		$this->prepareMocks( array( 'getResultsNum' ) );
		
		$this->resultSet
			->expects	( $this->at( 0 ) )
			->method	( 'getResultsNum' )
			->will		( $this->returnValue( 0 ) )
		;
		
		$this->assertFalse(
				$this->resultSet->isOnlyArticleMatchFound(),
				'\Wikia\Search\ResultSet\Base::isOnlyArticleMatchFound should return false unless there is only one result, and it is marked as an article match'
		);
	}
	
	/**
	 * @covers Wikia\Search\ResultSet\Base::addMatchResult
	 */
	public function testAddMatchResultNoResult() {
		$this->prepareMocks( [ 'addResult' ] );
		$match = $this->getMockBuilder( 'Wikia\Search\Match\Article' )
		              ->disableOriginalConstructor()
		              ->setMethods( [ 'getResult' ] )
		              ->getMock();
		$result = $this->getMock( 'Wikia\Search\Result' );
		$this->assertAttributeEquals(
				0,
				'resultsFound',
				$this->resultSet
		);
		$match
		    ->expects( $this->once() )
		    ->method ( "getResult" )
		    ->will   ( $this->returnValue( null ) )
		;
		$this->resultSet
		    ->expects( $this->never() )
		    ->method ( "addResult" )
		;
		$add = new ReflectionMethod( $this->resultSet, 'addMatchResult' );
		$add->setAccessible( true );
		$this->assertEquals(
				$this->resultSet,
				$add->invoke( $this->resultSet, $match )
		);
		$this->assertAttributeEquals(
				0,
				'resultsFound',
				$this->resultSet
		);
	}
	
	/**
	 * @covers Wikia\Search\ResultSet\Base::addMatchResult
	 */
	public function testAddMatchResultWithResult() {
		$this->prepareMocks( [ 'addResult' ] );
		$match = $this->getMockBuilder( 'Wikia\Search\Match\Article' )
		              ->disableOriginalConstructor()
		              ->setMethods( [ 'getResult' ] )
		              ->getMock();
		$result = $this->getMock( 'Wikia\Search\Result' );
		$this->assertAttributeEquals(
				0,
				'resultsFound',
				$this->resultSet
		);
		$match
		    ->expects( $this->once() )
		    ->method ( "getResult" )
		    ->will   ( $this->returnValue( $result ) )
		;
		$this->resultSet
		    ->expects( $this->once() )
		    ->method ( "addResult" )
		    ->with   ( $result )
		;
		$add = new ReflectionMethod( $this->resultSet, 'addMatchResult' );
		$add->setAccessible( true );
		$this->assertEquals(
				$this->resultSet,
				$add->invoke( $this->resultSet, $match )
		);
		$this->assertAttributeEquals(
				1,
				'resultsFound',
				$this->resultSet
		);
	}
	
	
	/**
	 * @covers \Wikia\Search\ResultSet\Base::isOnlyArticleMatchFound
	 */
	public function testIsOnlyArticleMatchFoundNotArticleMatch() {
		$this->prepareMocks( array( 'getResultsNum' ) );
		
		$mockResult = $this->getMockBuilder( 'WikiaSearchResult' )
							->disableOriginalConstructor()
							->setMethods( array( 'getVar' ) )
							->getMock();
		
		$this->resultSet
			->expects	( $this->at( 0 ) )
			->method	( 'getResultsNum' )
			->will		( $this->returnValue( 1 ) )
		;
		
		$mockResult
			->expects	( $this->at( 0 ) )
			->method	( 'getVar' )
			->with		( 'isArticleMatch' )
			->will		( $this->returnValue( false ) )
		;

		$results = new ReflectionProperty( '\Wikia\Search\ResultSet\Base', 'results' );
		$results->setAccessible( true );
		$results->setValue( $this->resultSet, array( $mockResult ) );
		
		$this->assertFalse(
				$this->resultSet->isOnlyArticleMatchFound(),
				'\Wikia\Search\ResultSet\Base::isOnlyArticleMatchFound should return false unless there is only one result, and it is marked as an article match'
		);
	}
	
	/**
	 * @covers \Wikia\Search\ResultSet\Base::isOnlyArticleMatchFound
	 */
	public function testIsOnlyArticleMatchFoundCorrect() {
		$this->prepareMocks( array( 'getResultsNum' ) );
		
		$mockResult = $this->getMockBuilder( 'WikiaSearchResult' )
							->disableOriginalConstructor()
							->setMethods( array( 'getVar' ) )
							->getMock();
		
		$this->resultSet
			->expects	( $this->at( 0 ) )
			->method	( 'getResultsNum' )
			->will		( $this->returnValue( 1 ) )
		;
		
		$mockResult
			->expects	( $this->at( 0 ) )
			->method	( 'getVar' )
			->with		( 'isArticleMatch' )
			->will		( $this->returnValue( true ) )
		;

		$results = new ReflectionProperty( '\Wikia\Search\ResultSet\Base', 'results' );
		$results->setAccessible( true );
		$results->setValue( $this->resultSet, array( $mockResult ) );
		
		$this->assertTrue(
				$this->resultSet->isOnlyArticleMatchFound(),
				'\Wikia\Search\ResultSet\Base::isOnlyArticleMatchFound should return true when there is only one result, and it is marked as an article match'
		);
	}
	
}
