<?php

require_once( 'WikiaSearchBaseTest.php' );

class WikiaSearchResultSetBaseTest extends WikiaSearchBaseTest
{
	protected $config;
	protected $resultSet;
	protected $searchResult;

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
	 * @covers Wikia\Search\ResultSet\Base::__construct
	 */
	public function testConstructor() {
		$this->prepareMocks();
		
		$mockResult = $this->getMockBuilder( 'WikiaSearchResult' )
		                   ->disableOriginalClone()
		                   ->setMethods( array( null ) )
		                   ->getMock();
		
		$resultsFound = 10;
		$this->searchResult
		    ->expects( $this->once() )
		    ->method ( 'getNumFound' )
		    ->will   ( $this->returnValue( $resultsFound ) )
		;
		$this->searchResult
		    ->expects( $this->once() )
		    ->method ( 'getDocuments' )
		    ->will   ( $this->returnValue( array( $mockResult ) ) )
		;
		
		$set = $this->getMockBuilder(  '\Wikia\Search\ResultSet\Base' )
		            ->setMethods( array( 'configure' ) )
		            ->setConstructorArgs( array( $this->searchResult, $this->config ) )
		            ->getMock();
		
		$expectedMemberVars = array(
				'searchResultObject' => $this->searchResult,
				'searchConfig' => $this->config,
				'resultsFound' => $resultsFound
				);
		
		foreach ( $expectedMemberVars as $name => $val ) {
			$refl = new ReflectionProperty( '\Wikia\Search\ResultSet\Base', $name );
			$refl->setAccessible( true );
			$this->assertEquals(
					$val,
					$refl->getValue( $set ),
					"\Wikia\Search\ResultSet\Base->{$name} should be set during __construct"
			);
		}
	
	}
	
	
	
	/**
	 * @covers \Wikia\Search\ResultSet\Base::setResults
	 */
	public function testSetResults() {
		$this->prepareMocks( array( 'addResult' ) );
		
		$mockResult = $this->getMockBuilder( 'WikiaSearchResult' )
							->disableOriginalConstructor()
							->getMock(); 
		
		$this->resultSet
			->expects	( $this->once() )
			->method	( 'addResult' )
			->with		( $mockResult )
		;
		
		$this->assertEquals(
				$this->resultSet,
				$this->resultSet->setResults( array( $mockResult ) ),
				'\Wikia\Search\ResultSet\Base::setResults should provide a fluent interface'
		);
	}
	
	/**
	 * @covers \Wikia\Search\ResultSet\Base::setResultsFound
	 */
	public function testSetResultsFound() {
		$this->prepareMocks( array( 'prependArticleMatchIfExists' ) ); // not providing a method to mock makes our mock result set cranky
		
		$this->assertEquals(
				$this->resultSet,
				$this->resultSet->setResultsFound( 10 ),
				'\Wikia\Search\ResultSet\Base::setResultsFound should provide a fluent interface'
		);
		
		$property = new ReflectionProperty( '\Wikia\Search\ResultSet\Base', 'resultsFound' );
		$property->setAccessible( true );
		
		$this->assertEquals(
				10,
				$property->getValue( $this->resultSet ),
				'\Wikia\Search\ResultSet\Base::setResultsFound should set the resultsFound variable'
		);
	}
	
	/**
	 * @covers \Wikia\Search\ResultSet\Base::prependArticleMatchIfExists
	 */
	public function testPrependArticleMatchIfExistsNoMatch() {
		$this->prepareMocks( array( 'getResultsStart', 'addResult' ), array( 'hasArticleMatch', 'getArticleMatch' ) );
		
		$this->config
			->expects	( $this->at( 0 ) )
			->method	( 'hasArticleMatch' )
			->will		( $this->returnValue( false ) )
		;
		$this->resultSet
			->expects	( $this->never() )		//should be short-circuited
			->method	( 'getResultsStart' )
		;
		
		$prepend = new ReflectionMethod( '\Wikia\Search\ResultSet\Base', 'prependArticleMatchIfExists' );
		$prepend->setAccessible( true );
		
		$this->assertEquals(
				$this->resultSet,
				$prepend->invoke( $this->resultSet ),
				'\Wikia\Search\ResultSet\Base::prependArticleMatchIfExists should provide a fluent interface'
		);
	}
	
	/**
	 * @covers \Wikia\Search\ResultSet\Base::prependArticleMatchIfExists
	 */
	public function testPrependArticleMatchIfExistsMatchWithPagination() {
		$this->prepareMocks( array( 'getResultsStart', 'addResult' ), array( 'hasArticleMatch', 'getArticleMatch' ) );
		
		$this->config
			->expects	( $this->at( 0 ) )
			->method	( 'hasArticleMatch' )
			->will		( $this->returnValue( true ) )
		;
		$this->resultSet
			->expects	( $this->at( 0 ) )
			->method	( 'getResultsStart' )
			->will		( $this->returnValue( 20 ) )
		;
		$this->config
			->expects	( $this->never() )
			->method	( 'getArticleMatch' )
		;
		
		$prepend = new ReflectionMethod( '\Wikia\Search\ResultSet\Base', 'prependArticleMatchIfExists' );
		$prepend->setAccessible( true );
		
		$this->assertEquals(
				$this->resultSet,
				$prepend->invoke( $this->resultSet ),
				'\Wikia\Search\ResultSet\Base::prependArticleMatchIfExists should provide a fluent interface'
		);
	}
	

	/**
	 * @covers \Wikia\Search\ResultSet\Base::addResult
	 */
	public function testAddResultInvalid() {
		$this->prepareMocks( array( 'isValidResult' ) );
		
		$mockSearchResult		= $this->getMockBuilder( 'WikiaSearchResult' )
									->disableOriginalConstructor()
									->getMock();
		
		$this->resultSet
			->expects	( $this->at( 0 ) )
			->method	( 'isValidResult' )
			->with		( $mockSearchResult )
			->will		( $this->returnValue( false ) )
		;
		
		$addResult = new ReflectionMethod( '\Wikia\Search\ResultSet\Base', 'addResult' );
		$addResult->setAccessible( true );
		
		try {
			$addResult->invoke( $this->resultSet, $mockSearchResult );
		} catch ( Exception $e ) { }
		
		$this->assertInstanceOf(
				'WikiaException',
				$e,
				'\Wikia\Search\ResultSet\Base::addResult should throw an exception if attempting to add an invalid result'
		);
	}
	
	/**
	 * @covers \Wikia\Search\ResultSet\Base::addResult
	 */
	public function testAddResultValid() {
		$this->prepareMocks( array( 'isValidResult' ), array(), array( 'getHighlighting' ) );
		
		$mockSearchResult		= $this->getMockBuilder( 'WikiaSearchResult' )
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
		
		$mockLang				= $this->getMockBuilder( 'Language' )
									->disableOriginalConstructor()
									->setMethods( array( 'date' ) )
									->getMock();
		
		$mockWf					= $this->getMockBuilder( 'WikiaFunctionWrapper' )
									->disableOriginalConstructor()
									->setMethods( array( 'Timestamp' ) )
									->getMock();
		
		$mockId = "123_456";
		$mockHlSnippet = "I can't believe it's not <em>butter</em>!";
		$mockTimestamp = date( 'Y-m-d' ).'T00:00:00Z'; // always today
		$wfts = wfTimestamp( TS_MW, $mockTimestamp );
		
		$this->resultSet
			->expects	( $this->at( 0 ) )
			->method	( 'isValidResult' )
			//->with		( $mockSearchResult )
			->will		( $this->returnValue( true ) )
		;
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
			->with		( WikiaSearch::field( 'html' ) )
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
			->method	( 'setVar' )
			->with		( 'created', $mockTimestamp )
			->will		( $this->returnValue( $mockSearchResult ) )
		;
		$mockWf
			->expects	( $this->at( 0 ) )
			->method	( 'Timestamp' )
			->with		( TS_MW, $mockTimestamp )
			->will		( $this->returnValue( $wfts ) )
		;
		$mockLang
			->expects	( $this->at( 0 ) )
			->method	( 'date' )
			->with		( $wfts )
			->will		( $this->returnValue( 'Today' ) )
		;
		$mockSearchResult
			->expects	( $this->at( 4 ) )
			->method	( 'setVar' )
			->with		( 'fmt_timestamp', 'Today' )
			->will		( $this->returnValue( $mockSearchResult ) )
		;
		$mockSearchResult
			->expects	( $this->at( 5 ) )
			->method	( 'getVar' )
			->with		( 'fmt_timestamp' )
			->will		( $this->returnValue( 'Today' ) )
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
			->with		( WikiaSearch::field( 'categories' ) )
			->will		( $this->returnValue( null ) )
		;
		$mockSearchResult
			->expects	( $this->at( 8 ) )
			->method	( 'setVar' )
			->with		( 'categories', 'NONE' )
			->will		( $this->returnValue( $mockSearchResult ) )
		;
		$mockSearchResult
			->expects	( $this->at( 9 ) )
			->method	( 'offsetGet' )
			->with		( 'wikiarticles' )
			->will		( $this->returnValue( 12345 ) )
		;
		$mockSearchResult
			->expects	( $this->at( 10 ) )
			->method	( 'setVar' )
			->with		( 'cityArticlesNum', 12345 )
			->will		( $this->returnValue( $mockSearchResult ) )
		;
		$mockSearchResult
			->expects	( $this->at( 11 ) )
			->method	( 'offsetGet' )
			->with		( WikiaSearch::field( 'wikititle' ) )
			->will		( $this->returnValue( "My Wiki" ) )
		;
		$mockSearchResult
			->expects	( $this->at( 12 ) )
			->method	( 'setVar' )
			->with		( 'wikititle', "My Wiki" )
			->will		( $this->returnValue( $mockSearchResult ) )
		;
		
		
		$mockWg = (object) array(
				'Lang'	=>	$mockLang,
				);
		
		$wrapper = new ReflectionProperty( '\Wikia\Search\ResultSet\Base', 'wf' );
		$wrapper->setAccessible( true );
		$wrapper->setValue( $this->resultSet, $mockWf );
		
		$global = new ReflectionProperty( '\Wikia\Search\ResultSet\Base', 'wg' );
		$global->setAccessible( true );
		$global->setValue( $this->resultSet, $mockWg );
		
		$addResult = new ReflectionMethod( '\Wikia\Search\ResultSet\Base', 'addResult' );
		$addResult->setAccessible( true );

		$this->assertEquals(
				$this->resultSet,
				$addResult->invoke( $this->resultSet, $mockSearchResult ),
				'\Wikia\Search\ResultSet\Base::addResult should provide a fluent interface'
		);
		
		$results = new ReflectionProperty( '\Wikia\Search\ResultSet\Base', 'results' );
		$results->setAccessible( true );
		
		$this->assertArrayHasKey(
				$mockId,
				$results->getValue( $this->resultSet ),
				'\Wikia\Search\ResultSet\Base::addResult should add a result to the results array keyed by the ID of the document'
		);
	}
	
	/**
	 * @covers \Wikia\Search\ResultSet\Base::getResultsFound
	 */
	public function testGetResultsFound() {
		$this->prepareMocks( array( 'getResultsStart' ) );
		
		$rf = new ReflectionProperty( '\Wikia\Search\ResultSet\Base', 'resultsFound' );
		$rf->setAccessible( true );
		$rf->setValue( $this->resultSet, 20 );
		
		$this->assertEquals(
				20,
				$this->resultSet->getResultsFound(),
				'\Wikia\Search\ResultSet\Base::getResultsFound should return the value set in the "resultFound" property'
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
	 * @covers \Wikia\Search\ResultSet\Base::getResultsNum
	 * @covers \Wikia\Search\ResultSet\Base::hasResults
	 */
	public function testResultCountMethods() {
		$this->prepareMocks( array( 'getResultsFound' ) );
		
		$this->assertEquals(
				0,
				$this->resultSet->getResultsNum(),
				'\Wikia\Search\ResultSet\Base::getResultsNum should return 0 if there are no results'
		);
		$this->assertFalse(
				$this->resultSet->hasResults(),
				'\Wikia\Search\ResultSet\Base::hasResults should return false if there are no results'
		);
		
		$mockResult = $this->getMockBuilder( 'WikiaSearchResult' )
							->disableOriginalConstructor()
							->getMock();
		
		$results = new ReflectionProperty( '\Wikia\Search\ResultSet\Base', 'results' );
		$results->setAccessible( true );
		$results->setValue( $this->resultSet, array( '123_234' => $mockResult ) );
		
		$this->assertEquals(
				1,
				$this->resultSet->getResultsNum(),
				'\Wikia\Search\ResultSet\Base::getResultsNum should return the count of the result array'
		);
		$this->assertTrue(
				$this->resultSet->hasResults(),
				'\Wikia\Search\ResultSet\Base::hasResults should return false if there are any results'
		);
	}
	
	
	
	/**
	 * @covers \Wikia\Search\ResultSet\Base::setHeader
	 * @covers \Wikia\Search\ResultSet\Base::getHeader
	 */
	public function testSetHeader() {
		$this->prepareMocks( array( 'hasArticleMatch' ) );
		
		$this->assertEquals(
				'foo',
				$this->resultSet->setHeader( 'bar', 'foo' )->getHeader( 'bar' ),
				'\Wikia\Search\ResultSet\Base::setHeader should provide a fluent interface and set the value for the key in the headers array. ' .
				'Calling getHeader() should return the value for the provided key.'
		);
	}
	
	/**
	 * @covers \Wikia\Search\ResultSet\Base::isValidResult
	 */
	public function testIsValidResult() {
		$this->prepareMocks( array( 'hasArticleMatch' ) );
		
		$mockResult = $this->getMockBuilder( 'WikiaSearchResult' )
							->disableOriginalConstructor()
							->getMock();
		
		$isValid = new ReflectionMethod( '\Wikia\Search\ResultSet\Base', 'isValidResult' );
		$isValid->setAccessible( true );
		
		$this->assertTrue(
				$isValid->invoke( $this->resultSet, $mockResult ),
				'WikiaSearchResult::isValidResult should return true if the provided argument is an instance of WikiaSearchResult'
		);
		$this->assertTrue(
				$isValid->invoke( $this->resultSet, $this->resultSet ),
				'WikiaSearchResult::isValidResult should return true if the provided argument is an instance of \Wikia\Search\ResultSet\Base'
		);
		$this->assertFalse(
				$isValid->invoke( $this->resultSet, $this->searchResult ),
				'WikiaSearchResult::isValidResult should return false for items that are not WikiaSearchResult or \Wikia\Search\ResultSet\Base'
		);
	}
	
	/**
	 * @covers \Wikia\Search\ResultSet\Base::getQuery
	 */
	public function testGetQuery() {
		$this->prepareMocks( array( 'hasArticleMatch' ), array( 'getQuery' ) );
		
		$this->config
			->expects	( $this->at( 0 ) )
			->method	( 'getQuery' )
			->with		( WikiaSearchConfig::QUERY_ENCODED )
			->will		( $this->returnValue( 'query' ) )
		;
		$this->assertEquals(
				'query',
				$this->resultSet->getQuery( WikiaSearchConfig::QUERY_ENCODED ),
				'\Wikia\Search\ResultSet\Base::getQuery should return the value of WikiaSearchConfig::getQuery, encoded'
		);
	}
	
	/**
	 * @covers \Wikia\Search\ResultSet\Base::getQueryTime
	 */
	public function testGetQueryTime() {
		$this->prepareMocks( array( 'hasArticleMatch' ), array(), array( 'getQueryTime' ) );
		
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
	
	/**
	 * @covers \Wikia\Search\ResultSet\Base::getParent
	 */
	public function testGetParent() {
		$this->prepareMocks( array( 'getId' ) );
		
		$resultSet2 = clone $this->resultSet;
		
		$parent = new ReflectionProperty( '\Wikia\Search\ResultSet\Base', 'parent' );
		$parent->setAccessible( true );
		$parent->setValue( $this->resultSet, $resultSet2 );
		
		$this->assertEquals(
				$resultSet2,
				$this->resultSet->getParent(),
				'\Wikia\Search\ResultSet\Base::getParent() should return the value set in the parent attribute'
		);
	}
	
	/**
	 * @covers \Wikia\Search\ResultSet\Base::getId
	 */
	public function testGetId() {
		$this->prepareMocks( array( 'getResultsNum' ) );
		
		$host = new ReflectionProperty( '\Wikia\Search\ResultSet\Base', 'host' );
		$host->setAccessible( true );
		$host->setValue( $this->resultSet, 'foo.wikia.com' );
		
		$this->assertEquals(
				'foo.wikia.com',
				$this->resultSet->getId(),
				'\Wikia\Search\ResultSet\Base::getId() should return the value of the host property if it is set'
		);
	}
	
	/**
	 * @covers \Wikia\Search\ResultSet\Base::getResults
	 */
	public function testGetResults() {
		$this->prepareMocks( array( 'prependArticleMatchIfExists' ) );
		
		$mockResult = $this->getMockBuilder( 'WikiaSearchResult' )
							->disableOriginalConstructor()
							->getMock();
		
		$mockResults = array( $mockResult );
		
		$results = new ReflectionProperty( '\Wikia\Search\ResultSet\Base', 'results' );
		$results->setAccessible( true );
		$results->setValue( $this->resultSet, $mockResults );
		
		$this->assertEquals(
				$mockResults,
				$this->resultSet->getResults(),
				'\Wikia\Search\ResultSet\Base::getResults should return the value of the results property'
		);
	}
	
	/**
	 * @covers \Wikia\Search\ResultSet\Base::toNestedArray
	 */
	public function testToNestedArray() {
		$this->prepareMocks( array( 'getResults' ) );
		
		$mockResult = $this->getMockBuilder( 'WikiaSearchResult' )
							->disableOriginalConstructor()
							->setMethods( array( 'toArray' ) )
							->getMock();
		
		$resultArray = array( 'title' => "mytitle", 'url' => 'myurl' );
		
		$mockResult
			->expects	( $this->at( 0 ) )
			->method	( 'toArray' )
			->with		( array( 'title', 'url' ) )
			->will		( $this->returnValue( $resultArray ) )
		;
		
		$mockResults = array( $mockResult );
		
		$results = new ReflectionProperty( '\Wikia\Search\ResultSet\Base', 'results' );
		$results->setAccessible( true );
		$results->setValue( $this->resultSet, $mockResults );
		
		$this->assertEquals(
				array( $resultArray ),
				$this->resultSet->toNestedArray(),
				'\Wikia\Search\ResultSet\Base should return an array of results that have been transformed to array'
		);
	}
	
	/**
	 * @covers \Wikia\Search\ResultSet\Base::toArray
	 */
	public function testToArray() {
		
		$mockSet = $this->getMockBuilder( '\Wikia\Search\ResultSet\Base' )
		                ->disableOriginalConstructor()
		                ->setMethods( array( 'getHeader' ) )
		                ->getMock();
		
		$title = "Kendrick Lamar Wiki";
		$url = "http://goodkidmaadwikicities.wikia.com/";
		
		$mockSet
		    ->expects( $this->at( 0 ) )
		    ->method ( 'getHeader' )
		    ->with   ( 'cityTitle' )
		    ->will   ( $this->returnValue( $title ) )
		;
		$mockSet
		    ->expects( $this->at( 1 ) )
		    ->method ( 'getHeader' )
		    ->with   ( 'cityUrl' )
		    ->will   ( $this->returnValue( $url ) )
		;
		$this->assertEquals(
				array( 'title' => $title, 'url' => $url ),
				$mockSet->toArray()
		);
		
	}
}