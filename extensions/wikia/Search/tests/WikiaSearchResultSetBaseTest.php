<?php

require_once( 'WikiaSearchBaseTest.php' );

class WikiaSearchResultSetBaseTest extends WikiaSearchBaseTest {
	
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
		                ->setMethods( array( 'prependArticleMatchIfExists', 'setResults' ) )
		                ->getMock();
		$mockResult = $this->getMockBuilder( '\Solarium_Result_Select' )
		                   ->disableOriginalConstructor()
		                   ->setMethods( array( 'getNumFound', 'getDocuments' ) )
		                   ->getMock();
		$config = new Wikia\Search\Config;
		$interface = Wikia\Search\MediaWikiInterface::getInstance();
		$dc = new Wikia\Search\ResultSet\DependencyContainer( array( 'config' => $config, 'interface' => $interface, 'result' => $mockResult ) );
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
		    ->method ( 'prependArticleMatchIfExists' )
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
	public function testAddResultInvalid() {
		$this->prepareMocks( array( 'isValidResult' ) );
		
		$mockSearchResult		= $this->getMockBuilder( 'Wikia\Search\Result' )
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
		
		$mockInterface = $this->getMockBuilder( 'Wikia\Search\MediaWikiInterface' )
		                      ->disableOriginalConstructor()
		                      ->setMethods( array( 'getMediaWikiFormattedTimestamp' ) )
		                      ->getMock();
		
		$mockArrayIterator = $this->getMock( '\ArrayIterator' );
		
		$mockId = "123_456";
		$mockHlSnippet = "I can't believe it's not <em>butter</em>!";
		$mockTimestamp = date( 'Y-m-d' ).'T00:00:00Z'; // always today
		$wfts = wfTimestamp( TS_MW, $mockTimestamp );
		
		$this->resultSet
			->expects	( $this->at( 0 ) )
			->method	( 'isValidResult' )
			->with		( $mockSearchResult )
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
		$mockInterface
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
		
		$intRefl = new ReflectionProperty( 'Wikia\Search\ResultSet\Base', 'interface' );
		$intRefl->setAccessible( true );
		$intRefl->setValue( $this->resultSet, $mockInterface );
		
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
	
	
}