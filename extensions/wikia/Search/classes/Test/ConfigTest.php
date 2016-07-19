<?php
namespace Wikia\Search\Test;
use \Wikia\Search\Config, \Solarium_Query_Select, \ReflectionProperty, \ReflectionMethod, \Wikia\Search\Utilities;
/**
 * Tests for Config class
 */
class ConfigTest extends BaseTest {

	public function setUp() {
		$this->service = $this->getMockBuilder( '\Wikia\Search\MediaWikiService' )
		                       ->disableOriginalConstructor();
		
		$this->config = $this->getMockBuilder( '\\Wikia\Search\Config' )
		                     ->disableOriginalConstructor();

		parent::setUp();
	}
	
	protected function setService( $config, $service ) {
		$refl = new ReflectionProperty( '\\Wikia\\Search\\Config', 'service' );
		$refl->setAccessible( true );
		$refl->setValue( $config, $service );
	}
	
	/**
	 * @group Slow
	 * @slowExecutionTime 0.07082 ms
	 * @covers \Wikia\Search\Config::__construct
	 */
	public function testConstructor() {
		$newParams = array( 'rank' => 'newest');
		$config    = new Config( $newParams );
		$this->assertEquals(
				'newest',
				$config->getRank(),
				'Parameters passed during construction with a key equal to a default parameter should be overwritten.'
		);
	}


	/**
	 * @group Slow
	 * @slowExecutionTime 0.07158 ms
	 * @covers \Wikia\Search\Config::getSort
	 * @covers \Wikia\Search\Config::setSort
	 */
	public function testGetSort() {
		$config = new \Wikia\Search\Config;

		$defaultRank = array( 'score', Solarium_Query_Select::SORT_DESC );

		$this->assertEquals(
				$defaultRank,
				$config->getSort(),
				'Search config should sort by score descending by default.'
		);

		$config->setRank( 'foo' );

		$this->assertEquals(
		        $defaultRank,
		        $config->getSort(),
		        'A malformed rank key should return the default sort.'
		);

		$config->setRank( 'newest' );

		$this->assertEquals(
				array( 'created',	Solarium_Query_Select::SORT_DESC ),
				$config->getSort(),
				'A well-formed rank key should return the appropriate sort array.'
		);

		$set = new ReflectionMethod( $config, 'setSort' );
		$set->setAccessible( true );
		$set->invoke( $config, 'created', 'asc' );

		$this->assertEquals(
				array( 'created', 'asc' ),
				$config->getSort(),
				'\Wikia\Search\Config::getSort should return a value set by setSort if it has been invoked'
		);
	}

	/**
	 * @group Slow
	 * @slowExecutionTime 0.0741 ms
	 * @covers \Wikia\Search\Config::hasArticleMatch
	 * @covers \Wikia\Search\Config::setArticleMatch
	 * @covers \Wikia\Search\Config::getArticleMatch
	 * @covers \Wikia\Search\Config::hasMatch
	 * @covers \Wikia\Search\Config::getMatch
	 */
	public function testArticleMatching() {
		$mockArticleMatch = $this->getMockBuilder( 'Wikia\Search\Match\Article' )
		                         ->disableOriginalConstructor()
		                         ->getMock();
		$config = $this->getMock( 'Wikia\Search\Config', [ 'articleMatchPassesFilters' ] );
		$config
		    ->expects( $this->any() )
		    ->method ( 'articleMatchPassesFilters' )
		    ->with   ( $mockArticleMatch )
		    ->will   ( $this->returnValue( true ) )
		;

		$this->assertFalse(
				$config->hasArticleMatch(),
				'\Wikia\Search\Config should not have an article match by default.'
		);
		$this->assertNull(
				$config->getArticleMatch(),
				'\Wikia\Search\Config should return null when getting an uninitialized article match'
		);
		$this->assertEquals(
				$config,
				$config->setArticleMatch( $mockArticleMatch ),
				'\Wikia\Search\Config::setArticleMatch should provide a fluent interface.'
		);
		$this->assertEquals(
				$mockArticleMatch,
				$config->getArticleMatch(),
				'\Wikia\Search\Config::getArticleMatch should return the appropriate article match once set.'
		);
		$this->assertTrue(
				$config->hasMatch()
		);
		$this->assertEquals(
				$mockArticleMatch,
				$config->getMatch(),
				'\Wikia\Search\Config::getMatch should return either article or wiki match.'
		);
	}
	
	/**
	 * @group Slow
	 * @slowExecutionTime 0.0722 ms
	 * @covers \Wikia\Search\Config::hasArticleMatch
	 * @covers \Wikia\Search\Config::setArticleMatch
	 * @covers \Wikia\Search\Config::getArticleMatch
	 * @covers \Wikia\Search\Config::hasMatch
	 * @covers \Wikia\Search\Config::getMatch
	 */
	public function testArticleMatchingFailingFilters() {
		$mockArticleMatch = $this->getMockBuilder( 'Wikia\Search\Match\Article' )
		                         ->disableOriginalConstructor()
		                         ->getMock();
		$config = $this->getMock( 'Wikia\Search\Config', [ 'articleMatchPassesFilters' ] );
		$config
		    ->expects( $this->any() )
		    ->method ( 'articleMatchPassesFilters' )
		    ->with   ( $mockArticleMatch )
		    ->will   ( $this->returnValue( false ) )
		;

		$this->assertFalse(
				$config->hasArticleMatch(),
				'\Wikia\Search\Config should not have an article match by default.'
		);
		$this->assertNull(
				$config->getArticleMatch(),
				'\Wikia\Search\Config should return null when getting an uninitialized article match'
		);
		$this->assertEquals(
				$config,
				$config->setArticleMatch( $mockArticleMatch ),
				'\Wikia\Search\Config::setArticleMatch should provide a fluent interface.'
		);
		$this->assertNull(
				$config->getArticleMatch(),
				'\Wikia\Search\Config::getArticleMatch should not be set if it does not pass filters'
		);
		$this->assertFalse(
				$config->hasMatch()
		);
		$this->assertNull(
				$config->getMatch()
		);
	}
	
	/**
	 * @group Slow
	 * @slowExecutionTime 0.07421 ms
	 * @covers Wikia\Search\Config::articleMatchPassesFilters
	 */
	public function testArticleMatchPassesFiltersImageInVideoFilter() {
		$config = $this->getMockBuilder( 'Wikia\Search\Config' )
		               ->disableOriginalConstructor()
		               ->setMethods( [ 'getPublicFilterKeys', 'getService' ] )
		               ->getMock();
		$match = $this->getMockBuilder( 'Wikia\Search\Match\Article' )
		              ->disableOriginalConstructor()
		              ->setMethods( [ 'getResult' ] )
		              ->getMock();
		$service = $this->getMock( 'Wikia\Search\MediaWikiService', [ 'pageIdIsVideoFile' ] );
		$config
		    ->expects( $this->once() )
		    ->method ( 'getPublicFilterKeys' )
		    ->will   ( $this->returnValue( [ \Wikia\Search\Config::FILTER_IMAGE ] ) )
		;
		$config
		    ->expects( $this->once() )
		    ->method ( 'getService' )
		    ->will   ( $this->returnValue( $service ) )
		;
		$service
		    ->expects( $this->once() )
		    ->method ( 'pageIdIsVideoFile' )
		    ->with   ( 123 )
		    ->will   ( $this->returnValue( true ) )
		;
		$match
		    ->expects( $this->once() )
		    ->method ( 'getResult' )
		    ->will   ( $this->returnValue( [ 'pageid' => 123, 'ns' => NS_FILE ] ) )
		;
		$method = new \ReflectionMethod( 'Wikia\Search\Config', 'articleMatchPassesFilters' );
		$method->setAccessible( true );
		$this->assertFalse(
				$method->invoke( $config, $match )
		);
	}
	
	/**
	 * @group Slow
	 * @slowExecutionTime 0.0731 ms
	 * @covers Wikia\Search\Config::articleMatchPassesFilters
	 */
	public function testArticleMatchPassesFiltersVideoInImageFilter() {
		$config = $this->getMockBuilder( 'Wikia\Search\Config' )
		               ->disableOriginalConstructor()
		               ->setMethods( [ 'getPublicFilterKeys', 'getService' ] )
		               ->getMock();
		$match = $this->getMockBuilder( 'Wikia\Search\Match\Article' )
		              ->disableOriginalConstructor()
		              ->setMethods( [ 'getResult' ] )
		              ->getMock();
		$service = $this->getMock( 'Wikia\Search\MediaWikiService', [ 'pageIdIsVideoFile' ] );
		$config
		    ->expects( $this->once() )
		    ->method ( 'getPublicFilterKeys' )
		    ->will   ( $this->returnValue( [ \Wikia\Search\Config::FILTER_VIDEO] ) )
		;
		$config
		    ->expects( $this->once() )
		    ->method ( 'getService' )
		    ->will   ( $this->returnValue( $service ) )
		;
		$service
		    ->expects( $this->once() )
		    ->method ( 'pageIdIsVideoFile' )
		    ->with   ( 123 )
		    ->will   ( $this->returnValue( false ) )
		;
		$match
		    ->expects( $this->once() )
		    ->method ( 'getResult' )
		    ->will   ( $this->returnValue( [ 'pageid' => 123, 'ns' => NS_FILE ] ) )
		;
		$method = new \ReflectionMethod( 'Wikia\Search\Config', 'articleMatchPassesFilters' );
		$method->setAccessible( true );
		$this->assertFalse(
				$method->invoke( $config, $match )
		);
	}
	
	
	/**
	 * @group Slow
	 * @slowExecutionTime 0.07283 ms
	 * @covers \Wikia\Search\Config::hasWikiMatch
	 * @covers \Wikia\Search\Config::setWikiMatch
	 * @covers \Wikia\Search\Config::getWikiMatch
	 * @covers \Wikia\Search\Config::hasMatch
	 * @covers \Wikia\Search\Config::getMatch
	 */
	public function testWikiMatching() {
		$mockWikiMatch = $this->getMockBuilder( 'Wikia\Search\Match\Wiki' )
		                      ->disableOriginalConstructor()
		                      ->getMock();

		$config = $this->getMockBuilder( 'Wikia\Search\Config' )
			->disableOriginalConstructor()
			->setMethods( [ 'getService' ] )
			->getMock()
		;
		$this->assertFalse(
				$config->hasWikiMatch(),
				'\Wikia\Search\Config should not have an wiki match by default.'
		);
		$this->assertNull(
				$config->getWikiMatch(),
				'\Wikia\Search\Config should return null when getting an uninitialized wiki match'
		);
		$this->assertEquals(
				$config,
				$config->setWikiMatch( $mockWikiMatch ),
				'\Wikia\Search\Config::setWikiMatch should provide a fluent interface.'
		);
		$this->assertEquals(
				$mockWikiMatch,
				$config->getWikiMatch(),
				'\Wikia\Search\Config::getWikiMatch should return the appropriate wiki match once set.'
		);
		$this->assertEquals(
				$mockWikiMatch,
				$config->getMatch(),
				'\Wikia\Search\Config::getMatch should return either article or wiki match.'
		);
		$this->assertTrue(
				$config->hasMatch()
		);
	}

	/**
	 * @group Slow
	 * @slowExecutionTime 0.07752 ms
	 * @covers \Wikia\Search\Config::getInterWiki
	 * @covers \Wikia\Search\Config::setInterWiki
	 * @covers \Wikia\Search\Config::setVideoSearch
	 * @covers \Wikia\Search\Config::setVideoEmbedToolSearch
	 * @covers \Wikia\Search\Config::setVideoTitleSearch
	 * @covers \Wikia\Search\Config::setDirectLuceneQuery
	 * @covers \Wikia\Search\Config::setCrossWikiLuceneQuery
	 */
	public function testSearchTypes() {
		$config = $this->getMockBuilder( 'Wikia\Search\Config' )
		               ->disableOriginalConstructor()
		               ->setMethods( [ 'bootstrapQueryService' ] )
		               ->getMock();
		
		$config
		    ->expects( $this->once() )
		    ->method ( 'bootstrapQueryService' )
		    ->will   ( $this->returnValue( 'Select\\Dismax\\OnWiki' ) )
		;
		
		$types = [ 
				'InterWiki' => 'Select\\Dismax\\InterWiki', 
				'VideoSearch' => 'Select\\Dismax\\Video', 
				'VideoEmbedToolSearch' => 'Select\\Dismax\\VideoEmbedTool', 
				'VideoTitleSearch' => 'Select\\Dismax\\VideoTitle', 
				'DirectLuceneQuery' => 'Select\\Lucene\\Lucene', 
				'CrossWikiLuceneQuery' => 'Select\\Lucene\\CrossWikiLucene' 
		];
		
		foreach ( $types as $type => $service ) {
			$set = new ReflectionMethod( $config, 'set' . $type );
			if ( $type == 'InterWiki' ) {
				$get = new ReflectionMethod( $config, 'get' . $type );
				$this->assertFalse(
						$get->invoke( $config )
				);
			}
			$this->assertAttributeNotEquals(
					$service,
					'queryService',
					$config
			);
			$this->assertEquals(
					$config,
					$set->invoke( $config, true )
			);
			if ( $type == 'InterWiki' ) {
				$this->assertTrue(
						$get->invoke( $config )
				);
			}
			$this->assertAttributeEquals(
					$service,
					'queryService',
					$config
			);
		}
	}
	
	/**
	 * @group Slow
	 * @slowExecutionTime 0.07596 ms
	 * @covers \Wikia\Search\Config::getTruncatedResultsNum
	 */
	public function testGetTruncatedResultsNum() {
		$config = $this->getMock( 'Wikia\\Search\\Config', [ 'getResultsFound', 'getService' ] );

		$singleDigit = 9;

		$config
		    ->expects( $this->at( 0 ) )
		    ->method ( 'getResultsFound' )
		    ->will   ( $this->returnValue( $singleDigit ) )
		;
		

		$this->assertEquals(
				$singleDigit,
				$config->getTruncatedResultsNum(),
				"We should not truncate a single digit result number value."
		);

		$doubleDigit = 26;
		
		$config
		    ->expects( $this->at( 0 ) )
		    ->method ( 'getResultsFound' )
		    ->will   ( $this->returnValue( $doubleDigit ) )
		;

		$this->assertEquals(
				30,
				$config->getTruncatedResultsNum(),
				"We should round only for double digits."
		);

		$tripleDigit = 492;
		
		$config
		    ->expects( $this->at( 0 ) )
		    ->method ( 'getResultsFound' )
		    ->will   ( $this->returnValue( $tripleDigit ) )
		;

		$this->assertEquals(
				500,
				$config->getTruncatedResultsNum(),
				"We should round to hundreds for triple digits."
		);

		$bigDigit = 55555;

		$config
		    ->expects( $this->at( 0 ) )
		    ->method ( 'getResultsFound' )
		    ->will   ( $this->returnValue( $bigDigit ) )
		;

		$this->assertEquals(
				56000,
				$config->getTruncatedResultsNum(),
				"Larger digits should round to the nearest n-1 radix."
		);
		
		$service = $this->service->setMethods( array( 'formatNumber' ) )->getMock();
		$service
		    ->expects( $this->once() )
		    ->method ( 'formatNumber' )
		    ->with   (56000)
		    ->will   ( $this->returnValue( '56,000' ) )
	    ;
		$config
		    ->expects( $this->at( 0 ) )
		    ->method ( 'getResultsFound' )
		    ->will   ( $this->returnValue( $bigDigit ) )
		;
		$config
		    ->expects( $this->at( 1 ) )
		    ->method ( 'getService' )
		    ->will   ( $this->returnValue( $service ) )
		;
		$this->assertEquals(
				'56,000',
				$config->getTruncatedResultsNum( true )
		);
		
	}

	/**
	 * @group Slow
	 * @slowExecutionTime 0.07473 ms
	 * @covers \Wikia\Search\Config::getNumPages
	 */
	public function testGetNumPagesNoResults() {
		$config = $this->getMock( '\\Wikia\\Search\\Config', [ 'getResultsFound', 'getLimit' ] );
		$config
		    ->expects( $this->any() )
		    ->method ( 'getResultsFound' )
		    ->will   ( $this->returnValue( 0 ) )
		;
		$this->assertEquals(
				0,
				$config->getNumPages(),
				'Number of pages should default to zero.'
		);
	}
	
	/**
	 * @group Slow
	 * @slowExecutionTime 0.07363 ms
	 * @covers \Wikia\Search\Config::getNumPages
	 */
	public function testGetNumPagesWithResults() {
		$config = $this->getMock( '\\Wikia\\Search\\Config', [ 'getResultsFound', 'getLimit' ] );
		$numFound = 50;
		$config
		    ->expects( $this->any() )
		    ->method ( 'getResultsFound' )
		    ->will   ( $this->returnValue( $numFound ) )
		;
		$config
		    ->expects( $this->once() )
		    ->method ( 'getLimit' )
		    ->will   ( $this->returnValue( Config::RESULTS_PER_PAGE ) )
		;
		$this->assertEquals(
				ceil( $numFound / \Wikia\Search\Config::RESULTS_PER_PAGE ),
				$config->getNumPages(),
				'Number of pages should be divided by default number of results per page by if no limit is set.'
		);
	}

	/**
	 * @group Slow
	 * @slowExecutionTime 0.07442 ms
	 * @covers \Wikia\Search\Config::getCityId
	 * @covers \Wikia\Search\Config::setCityID
	 */
	public function testSetGetCityId() {
		$config = $this->getMock( '\\Wikia\\Search\\Config', [ 'setWikiId', 'getWikiId' ] );
		
		$config
		    ->expects( $this->once() )
		    ->method ( 'getWikiId' )
		    ->will   ( $this->returnValue( 123 ) )
		;
		$this->assertEquals(
				123,
				$config->getCityId()
		);
		$config
		    ->expects( $this->once() )
		    ->method ( 'setWikiId' )
		    ->with   ( 123 )
		    ->will   ( $this->returnValue( $config ) )
		;
		$this->assertEquals(
				$config,
				$config->setCityId( 123 )
		);
	}

	/**
	 * @covers \Wikia\Search\Config::getMainPage
	 * @covers \Wikia\Search\Config::setMainPage
	 */
	public function testSetMainPage() {
		$config = $this->getMock( '\\Wikia\\Search\\Config', [ 'setMainPage', 'getMainPage' ] );

		$config
			->expects( $this->once() )
			->method ( 'getMainPage' )
			->will   ( $this->returnValue( true ) )
		;
		$this->assertEquals(
			true,
			$config->getMainPage()
		);
		$config
			->expects( $this->once() )
			->method ( 'setMainPage' )
			->with   ( true )
			->will   ( $this->returnValue( $config ) )
		;
		$this->assertEquals(
			$config,
			$config->setMainPage( true )
		);
	}

	/**
	 * @group Slow
	 * @slowExecutionTime 0.18868 ms
	 * @covers \Wikia\Search\Config::getSearchProfiles
	 */
	public function testGetSearchProfiles() {
		$config 			= new Config;

        $this->getStaticMethodMock('SearchEngine', 'searchableNamespaces')
            ->expects   	( $this->any() )
            ->method		( 'searchableNamespaces' )
            ->will			( $this->returnValue( array( NS_MAIN, NS_TALK, NS_CATEGORY, NS_FILE, NS_USER ) ) )
        ;

        $this->getStaticMethodMock('SearchEngine', 'defaultNamespaces')
            ->expects   	( $this->any() )
            ->method		( 'defaultNamespaces' )
            ->will			( $this->returnValue( array( NS_FILE, NS_CATEGORY ) ) )
        ;

        $this->getStaticMethodMock('SearchEngine', 'namespacesAsText')
            ->expects   	( $this->any() )
            ->method		( 'namespacesAsText' )
            ->will			( $this->returnValue( array( 'Article', 'Category' ) ) )
        ;

		$profiles = $config->getSearchProfiles();
		$profileConstants = array( SEARCH_PROFILE_DEFAULT, SEARCH_PROFILE_IMAGES, SEARCH_PROFILE_USERS, SEARCH_PROFILE_ALL );
		foreach ( $profileConstants as $profile ) {
			$this->assertArrayHasKey(
					$profile,
					$profiles
			);
		}
	}

	/**
	 * @group Slow
	 * @slowExecutionTime 0.07765 ms
	 * @covers \Wikia\Search\Config::getActiveTab
	 */
	public function testGetActiveTab() {
		$config = $this->config->setMethods( array( 'getAdvanced', 'getNamespaces', 'getSearchProfiles' ) )->getMock();
		$config
		    ->expects( $this->at( 0 ) )
		    ->method ( 'getAdvanced' )
		    ->will   ( $this->returnValue( true ) )
		;
		$this->assertEquals(
				'advanced',
				$config->getActiveTab()
		);
		$config
		    ->expects( $this->at( 0 ) )
		    ->method ( 'getAdvanced' )
		    ->will   ( $this->returnValue( false ) )
		;
		$config
		    ->expects( $this->at( 1 ) )
		    ->method ( 'getNamespaces' )
		    ->will   ( $this->returnValue( array( 0, 14 ) ) )
		;
		$config
		    ->expects( $this->at( 2 ) )
		    ->method ( 'getSearchProfiles' )
		    ->will   ( $this->returnValue( array( 'default' => array( 'namespaces' => array( 0, 14 ) ), 'images' => array( 'namespaces' => array( 6 ) ) ) ) )
		;
		$this->assertEquals(
				'default',
				$config->getActiveTab()
		);
		$config
		    ->expects( $this->at( 0 ) )
		    ->method ( 'getAdvanced' )
		    ->will   ( $this->returnValue( false ) )
		;
		$config
		    ->expects( $this->at( 1 ) )
		    ->method ( 'getNamespaces' )
		    ->will   ( $this->returnValue( array( 0, 14, 123 ) ) )
		;
		$config
		    ->expects( $this->at( 2 ) )
		    ->method ( 'getSearchProfiles' )
		    ->will   ( $this->returnValue( array( 'default' => array( 'namespaces' => array( 0, 14 ) ), 'images' => array( 'namespaces' => array( 6 ) ) ) ) )
		;
		$this->assertEquals(
				'advanced',
				$config->getActiveTab()
		);
	}

	/**
	 * @group Slow
	 * @group Broken
	 * @slowExecutionTime 0.07724 ms
	 * @covers \Wikia\Search\Config::setFilterQuery
	 * @covers \Wikia\Search\Config::setFilterQueries
	 * @covers \Wikia\Search\Config::getFilterQueries
	 * @covers \Wikia\Search\Config::setFilterQueryByCode
	 * @covers \Wikia\Search\Config::setFilterQueriesFromCodes
	 */
	public function testFilterQueryMethods() {
		$config	= new Config;
		$fqAttr	= new ReflectionProperty( '\Wikia\Search\Config', 'filterQueries' );
		$fqAttr->setAccessible( true );

		$this->assertFalse(
				$config->hasFilterQueries(),
				'\Wikia\Search\Config::hasFilterQueries should return false if no filter queries have been explicitly set.'
		);
		$this->assertEquals(
				$config,
				$config->setFilterQuery( 'foo:bar' ),
				'\Wikia\Search\Config::setFilterQuery should provide a fluent interface.'
		);
		$this->assertArrayHasKey(
				'fq1',
				$fqAttr->getValue( $config ),
				'\Wikia\Search\Config::setFilterQuery should assign an auto-incremented key when a key is not provided'
		);
		$this->assertArrayHasKey(
				'foo',
				$fqAttr->getValue( $config->setFilterQuery( 'bar:foo', 'foo' ) ),
				'\Wikia\Search\Config::setFilterQuery should store the filter query by the provided key'
		);
		$this->assertContains(
				array( 'key' => 'foo', 'query' => 'bar:foo' ),
				$fqAttr->getValue( $config ),
				'\Wikia\Search\Config::setFilterQuery should store the key and query as associative values in the value array per Solarium expected format'
		);
		$this->assertTrue(
				$config->hasFilterQueries(),
				'\Wikia\Search\Config::hasFilterQueries should return true if filter queries have been set'
		);
		$this->assertEquals(
				$fqAttr->getValue( $config ),
				$config->getFilterQueries(),
				'\Wikia\Search\Config::getFilterQueries should return the filterQueries attribute'
		);
		$this->assertEquals(
				$config,
				$config->setFilterQueries( array() ),
				'\Wikia\Search\Config::setFilterQueries should provide a fluent interface'
		);
		$this->assertEmpty(
				$fqAttr->getValue( $config ),
				'Passing an empty array to \Wikia\Search\Config::setFilterQueries should remove all filter queries.'
		);
		$this->assertEquals(
				0,
				\Wikia\Search\Config::$filterQueryIncrement,
				'\Wikia\Search\Config::setFilterQueries should reset the filter query increment'
		);

		$config->setFilterQueries( array(
				array(
						'query' => 'foo:bar',
						'key'   => 'baz',
				),
				'qux',
				true
		));
		$this->assertArrayHasKey(
				'baz',
				$fqAttr->getValue( $config ),
				'A properly formatted filter query array passed as a value to the array argument of '
				.' \Wikia\Search\Config::setFilterQueries should respect the previously set key'
		);
		$this->assertArrayHasKey(
				'fq1',
				$fqAttr->getValue( $config ),
				'Values in the argument array that are string-typed should receive '
				.' an auto-incremented key per \Wikia\Search\Config::setFilterQuery'
		);
		$this->assertEquals(
				2,
				count( $fqAttr->getValue( $config ) ),
				'Values in the array passed to \Wikia\Search\Config::setFilterQueries that are not properly formatted should be ignored'
		);

		// resetting
		$config->setFilterQueries( array() );

		$this->assertEquals(
				$config,
				$config->setFilterQueryByCode( 'is_video' ),
				'\Wikia\Search\Config::setFilterQueryByCode should provide a fluent interface'
		);
		$fqArray = $fqAttr->getValue( $config );
		$this->assertArrayHasKey(
				'is_video',
				$fqArray,
				'\Wikia\Search\Config::setFilterQueryByCode should set the code as the key for the new filter query'
		);

		$fcAttr = new ReflectionProperty( '\Wikia\Search\Config', 'filterCodes' );
		$fcAttr->setAccessible( true );
		$filterCodes = $fcAttr->getValue( $config );

		$this->assertEquals(
				array( 'key' => 'is_video', 'query' => $filterCodes['is_video'] ),
				$fqArray['is_video'],
				'\Wikia\Search\Config::setFilterQueryByCode should set exactly the query string that is '
				.'the value in \Wikia\Search\Config::filterCodes, keyed by the code provided'
		);

		$mockWikia = $this->getMock( 'Wikia', array( 'log' ) );
		$mockWikia
			->staticExpects	( $this->any() )
			->method		( 'log' )
		;
		$this->mockClass( 'Wikia', $mockWikia );
		// this satisfies the above expectation
		$config->setFilterQueryByCode( 'notacode' );

		$this->assertEquals(
				$config,
				$config->setFilterQueriesFromCodes( array( 'is_video', 'is_image' ) ),
				'\Wikia\Search\Config::setFilterQueriesFromCodes should provide a fluent interface'
		);
		$this->assertEquals(
				2,
				count( $fqAttr->getValue( $config ) ),
				'\Wikia\Search\Config::setFilterQueriesFromCode should function over each array '
				.' value provided as a code key to \Wikia\Search\Config::setFilterQueryByCode. '
				.' This test also proves a vital part of filter query data architecture: overwriting a key is allowed, '
				.' and warnings are not issues if you do so.'
		);
		// needs resetting to get the testing environment back in shape
		\Wikia\Search\Config::$filterQueryIncrement = 0;
	}

	/**
	 * @group Slow
	 * @slowExecutionTime 0.07581 ms
	 * @covers \Wikia\Search\Config::getRequestedFields
	 */
	public function testGetRequestedFields() {
		$config = new Config;

		$config->setRequestedFields( array( 'html' ) );

		$fields = $config->getRequestedFields();

		$this->assertContains(
				'html',
				$fields
		);
	}
	
	/**
	 * @group Slow
	 * @slowExecutionTime 0.07465 ms
	 * @covers \Wikia\Search\Config::getPublicFilterKeys
	 */
	public function testGetPublicFilterKeys() {
		$config = new Config;
		
		$config->setFilterQueryByCode( 'is_image' );
		
		$this->assertContains(
				'is_image',
				$config->getPublicFilterKeys(),
				'A public filter key registered in \Wikia\Search\Config::publicFilterKeys should be returned by \Wikia\Search\Config::getPublicFilterKeys'
		);
		
	}
	
	/**
	 * @group Slow
	 * @slowExecutionTime 0.07419 ms
	 * @covers \Wikia\Search\Config::hasFilterQueries
	 */
	public function testHasFilterQueries() {
		$config = new \Wikia\Search\Config;
		$this->assertFalse(
				$config->hasFilterQueries()
		);
		$config->setFilterQuery( 'foo', 'bar' );
		$this->assertTrue(
				$config->hasFilterQueries()
		);
	}
	
	/**
	 * @group Slow
	 * @slowExecutionTime 0.07694 ms
	 * @covers \Wikia\Search\Config::setQuery
	 * @covers \Wikia\Search\Config::getQuery
	 */
	public function testQueryMethods() {
		$mockQuery = $this->getMock( 'Wikia\Search\Query\Select', [ 'getNamespaceId' ], [ 'foo' ] );
		$mockConfig = $this->getMock( 'Wikia\Search\Config', [ 'getNamespaces' ] );
		
		$this->mockClass( 'Wikia\Search\Query\Select', $mockQuery );

		$this->assertNull(
				$mockConfig->getQuery()
		);
		$mockQuery
		    ->expects( $this->at( 0 ) )
		    ->method ( 'getNamespaceId' )
		    ->will   ( $this->returnValue( null ) )
		;
		$this->assertEquals(
				$mockConfig,
				$mockConfig->setQuery( 'foo' )
		);
		$this->assertEquals(
				$mockConfig->getQuery(),
				$mockQuery
		);
		$mockQuery
		    ->expects( $this->at( 0 ) )
		    ->method ( 'getNamespaceId' )
		    ->will   ( $this->returnValue( NS_CATEGORY ) )
		;
		$mockConfig
		    ->expects( $this->once() )
		    ->method ( 'getNamespaces' )
		    ->will   ( $this->returnValue( [ NS_MAIN ] ) )
		;
		$this->assertEquals(
				$mockConfig,
				$mockConfig->setQuery( 'foo' )
		);
		$this->assertAttributeEquals(
				NS_CATEGORY,
				'queryNamespace',
				$mockConfig
		);
		
	}
	
	/**
	 * @group Slow
	 * @slowExecutionTime 0.07311 ms
	 * @covers \Wikia\Search\Config::getNamespaces
	 * @todo mock better
	 */
	public function testGetNamespaces() {return;
		$config = $this->config->setMethods( null )->getMock();
		$service = $this->config->setMethods( array( 'getDefaultNamespacesFromSearchEngine' ) )->getMock();
		$this->setService( $config, $service );
		$config->setQueryNamespace( 123 );
		$service
		    ->expects( $this->once() )
		    ->method ( 'getDefaultNamespacesFromSearchEngine' )
		    ->will   ( $this->returnValue( array( 0, 14 ) ) )
	    ;
		$this->assertEquals(
				array( 0, 14, 123 ),
				$config->getNamespaces()
		);
	}
	
	/**
	 * @group Slow
	 * @slowExecutionTime 0.07538 ms
	 * @covers \Wikia\Search\Config::getQuery
	 */
	public function testGetQuery() {
		$config = new \Wikia\Search\Config;
		$this->assertNull(
				$config->getQuery()
		);
		$query = "foo and: bar & baz";
		$config->setQuery( $query );
		$this->assertInstanceOf(
				'Wikia\Search\Query\Select',
				$config->getQuery()
		);
		$this->assertAttributeContains(
				$query,
				'rawQuery',
				$config->getQuery()
		);
		$config = new \Wikia\Search\Config( [ 'query' => 'foo' ] );
		$this->assertInstanceOf(
				'Wikia\Search\Query\Select',
				$config->getQuery()
		);
	}
	
	/**
	 * @group Slow
	 * @slowExecutionTime 0.07579 ms
	 * @covers Wikia\Search\Config::getWikiId
	 */
	public function testGetWikiIdDefault() {
		$config = $this->getMockBuilder( 'Wikia\Search\Config' )
		               ->disableOriginalConstructor()
		               ->setMethods( [ 'getService' ] )
		               ->getMock();
		$service = $this->getMockBuilder( 'Wikia\Search\MediaWikiService' )
		                ->setMethods( [ 'getWikiId' ] )
		                ->getMock();
		$this->assertAttributeEmpty(
				'wikiId',
				$config
		);
		$config
		    ->expects( $this->once() )
		    ->method ( 'getService' )
		    ->will   ( $this->returnValue( $service ) )
		;
		$service
		    ->expects( $this->once() )
		    ->method ( 'getWikiId' )
		    ->will   ( $this->returnValue( 123 ) )
		;
		$this->assertEquals(
				123,
				$config->getWikiId(),
				'Wikia\Search\Config should default to ID of current wiki if the wiki ID has not been set'
		);
		$this->assertAttributeEquals(
				123,
				'wikiId',
				$config,
				'Calling Wikia\Search\Config::getWikiID on a config whose ID has not been set should store the current wiki in the wikiId attribute'
		);
	}
	
	/**
	 * @group Slow
	 * @slowExecutionTime 0.07413 ms
	 * @covers Wikia\Search\Config::setWikiId
	 * @covers Wikia\Search\Config::getWikiId
	 */
	public function testSetAndGetWikiId() {
		$config = new Config;
		$this->assertAttributeEmpty(
				'wikiId',
				$config
		);
		$config->setWikiId( 123 );
		$this->assertAttributeEquals(
				123,
				'wikiId',
				$config
		);
		$this->assertEquals(
				123,
				$config->getWikiId()
		);
	}

	/**
	 * @group Slow
	 * @slowExecutionTime 0.07462 ms
	 * @covers Wikia\Search\Config::getLanguageCode
	 * @covers Wikia\Search\Config::setLanguageCode
	 */
	public function testSetAndGetLanguageCode() {
		$mockService = $this->getMockBuilder( 'Wikia\Search\MediaWikiService' )
			->setMethods( [ 'getLanguageCode' ] )
			->getMock();
		$config = $this->getMockBuilder( 'Wikia\Search\Config' )
			->disableOriginalConstructor()
			->setMethods( [ 'getService' ] )
			->getMock();

		$mockService
			->expects( $this->once() )
			->method( 'getLanguageCode' )
			->will( $this->returnValue( 'en' ) )
		;

		$config
			->expects( $this->once() )
			->method( 'getService' )
			->will( $this->returnValue( $mockService ) )
		;

		$this->assertAttributeEmpty(
			'languageCode',
			$config,
			'At create languageCode field should be empty'
		);

		$this->assertEquals(
			'en',
			$config->getLanguageCode(),
			'Default value should equals en.'
		);

		$config->setLanguageCode( 'pl' );

		$this->assertAttributeEquals(
			'pl',
			'languageCode',
			$config
		);

		$this->assertEquals(
			'pl',
			$config->getLanguageCode()
		);

	}
	
	/**
	 * @group Slow
	 * @slowExecutionTime 0.0725 ms
	 * @covers Wikia\Search\Config::setLimit
	 * @covers Wikia\Search\Config::getLimit
	 */
	public function testSetGetLimit() {
		$config = new Config;
		$this->assertAttributeEquals(
				\Wikia\Search\Config::RESULTS_PER_PAGE,
				'limit',
				$config
		);
		$this->assertEquals(
				$config,
				$config->setLimit( 123 )
		);
		$this->assertAttributeEquals(
				123,
				'limit',
				$config
		);
		$this->assertEquals(
				$config,
				$config->setLimit( 500 )
		);
		$this->assertAttributeEquals(
				200,
				'limit',
				$config,
				'We restrict the number of results in a search to 200'
		);
		$this->assertEquals(
				200,
				$config->getLimit()
		);
	}
	
	/**
	 * @group Slow
	 * @slowExecutionTime 0.07239 ms
	 * @covers Wikia\Search\Config::setPage
	 * @covers Wikia\Search\Config::getPage
	 */
	public function testSetGetPage() {
		$config = new Config;
		$this->assertAttributeEquals(
				1,
				'page',
				$config
		);
		$this->assertEquals(
				$config,
				$config->setPage( 2 )
		);
		$this->assertAttributeEquals(
				2,
				'page',
				$config
		);
		$this->assertEquals(
				2,
				$config->getPage()
		);
	}
	
	/**
	 * @group Slow
	 * @slowExecutionTime 0.07962 ms
	 * @covers Wikia\Search\Config::getRank
	 * @covers Wikia\Search\Config::setRank
	 */
	public function testGetSetRank() {
		$config = new Config;
		$this->assertAttributeEquals(
				$config::RANK_DEFAULT,
				'rank',
				$config,
				'Default rank should be default on instantiation'
		);
		$this->assertEquals(
				$config::RANK_DEFAULT,
				$config->getRank(),
				'getRank should return value of rank property'
		);
		$this->assertEquals(
				$config,
				$config->setRank( $config::RANK_NEWEST ),
				'setrank should provide a fluent interface'
		);
		$this->assertAttributeEquals(
				$config::RANK_NEWEST,
				'rank',
				$config,
				'setrank should mutate the rank attribute'
		);
	}

	/**
	 * @group Slow
	 * @slowExecutionTime 0.07653 ms
	 * @covers Wikia\Search\Config
	 */
	public function testSetGetABTestGroup() {
		$config = new Config;
		$this->assertAttributeEmpty(
				'boostGroup',
				$config
		);
		$this->assertEquals(
				$config,
				$config->setBoostGroup( 'A' )
		);
		$this->assertAttributeEquals(
				'A',
				'boostGroup',
				$config
		);
		$this->assertEquals(
				'A',
				$config->getBoostGroup()
		);
	}
	
	/**
	 * @group Slow
	 * @slowExecutionTime 0.07502 ms
	 * @covers Wikia\Search\Config::getTestProfile
	 * @covers Wikia\Search\Config::initiateTestProfile
	 */
	public function testGetTestProfileNotSet() {
		$config = new Config;
		$this->assertAttributeEmpty(
				'boostGroup',
				$config
		);
		$this->assertInstanceOf(
				'Wikia\Search\TestProfile\Base',
				$config->getTestProfile(),
				'The default test group should be Base'
		);
	}
	
	/**
	 * @group Slow
	 * @slowExecutionTime 0.07379 ms
	 * @covers Wikia\Search\Config::getTestProfile
	 * @covers Wikia\Search\Config::initiateTestProfile
	 */
	public function testGetTestProfileExplicitBase() {
		$config = new Config;
		$config->setBoostGroup( 'Base' );
		$this->assertInstanceOf(
				'Wikia\Search\TestProfile\Base',
				$config->getTestProfile(),
				'We should support explicitly setting "Base" as the test group.'
		);
		// note that this is really just a logic hack -- we're using the backoff tested below for now
	}

	/**
	 * @group Slow
	 * @slowExecutionTime 0.07386 ms
	 * @covers Wikia\Search\Config::getTestProfile
	 * @covers Wikia\Search\Config::initiateTestProfile
	 */
	public function testGetTestProfileWithTestGroup() {
		$config = new Config;
		$config->setBoostGroup( 'A' );
		$this->assertInstanceOf(
				'Wikia\Search\TestProfile\GroupA',
				$config->getTestProfile(),
				'We should be able to access the correct test profile when given a letter value'
		);
	}

	/**
	 * @group Slow
	 * @slowExecutionTime 0.07465 ms
	 * @covers Wikia\Search\Config::getTestProfile
	 * @covers Wikia\Search\Config::initiateTestProfile
	 */
	public function testGetTestProfileNonexistentTestGroup() {
		$config = new Config;
		$config->setBoostGroup( 'THIS_AINT_NO_TEST_GROUP' );
		$this->assertInstanceOf(
				'Wikia\Search\TestProfile\Base',
				$config->getTestProfile(),
				'A non-existent test group should back off to base'
		);
	}
	
	/**
	 * @group Slow
	 * @slowExecutionTime 0.07421 ms
	 * @covers Wikia\Search\Config::setStart
	 * @covers Wikia\Search\Config::getStart
	 */
	public function testSetGetStart() {
		$start = 12345; // could never be our default start
		$config = new Config;
		$this->assertEquals(
				$config,
				$config->setStart( $start )
		);
		$this->assertAttributeEquals(
				$start,
				'start',
				$config
		);
		$this->assertEquals(
				$start,
				$config->getStart()
		);
	}

	/**
	 * @covers Wikia\Search\Config::setMinArticleQuality
	 * @covers Wikia\Search\Config::getMinArticleQuality
	 */
	public function testGetMinArticleQuality() {
		$val = 13; // could never be our default start
		$config = new Config();
		$this->assertEquals(
			$config,
			$config->setMinArticleQuality( $val )
		);
		$this->assertAttributeEquals(
			$val,
			'minArticleQuality',
			$config
		);
		$this->assertEquals(
			$val,
			$config->getMinArticleQuality()
		);
	}


	/**
	 * @covers Wikia\Search\Config::setPageId
	 * @covers Wikia\Search\Config::getPageId
	 */
	public function testSetPageId() {
		$val = 13; // could never be our default start
		$config = new Config();
		$this->assertEquals(
			$config,
			$config->setPageId( $val )
		);
		$this->assertAttributeEquals(
			$val,
			'pageId',
			$config
		);
		$this->assertEquals(
			$val,
			$config->getPageId()
		);
	}

	/**
	 * @group Slow
	 * @slowExecutionTime 0.07426 ms
	 * @covers Wikia\Search\Config::setMinimumMatch
	 * @covers Wikia\Search\Config::getMinimumMatch
	 */
	public function testSetGetMm() {
		$mm = '200%';
		$config = new Config;
		$this->assertEquals(
				$config,
				$config->setMinimumMatch( $mm )
		);
		$this->assertAttributeEquals(
				$mm,
				'minimumMatch',
				$config
		);
		$this->assertEquals(
				$mm,
				$config->getMinimumMatch()
		);
	}
	
	/**
	 * @group Slow
	 * @slowExecutionTime 0.07702 ms
	 * @covers Wikia\Search\Config::getLength
	 */
	public function testGetLengthWithMatch() {
		$config = $this->getMockBuilder( 'Wikia\Search\Config' )
		               ->disableOriginalConstructor()
		               ->setMethods( [ 'getPage', 'hasMatch' ] )
		               ->getMock();

		$config->expects( $this->any() )
			->method( 'getPage' )
			->will( $this->returnValue( 0 ) )
		;
		$config->expects( $this->any() )
			->method( 'hasMatch' )
			->will( $this->returnValue( true ) )
		;
		$config->setLimit( 1 );

		$this->assertEquals(
				$config->getLength(),
				0,
				'Wikia\Search\Config::getLength should be limit 0 if we have a match and are on first page'
		);
	}

	/**
	 * @covers Wikia\Search\Config::mustAddMatchedRecords
	 */
	public function testMustAddMatchedRecords() {
		$config = $this->getMockBuilder( 'Wikia\Search\Config' )
			->disableOriginalConstructor()
			->setMethods( [ 'getPage', 'hasMatch' ] )
			->getMock()
		;
		$config->expects( $this->any() )
			->method( 'getPage' )
			->will( $this->returnValue( 2 ) )
		;
		$config->expects( $this->any() )
			->method( 'hasMatch' )
			->will( $this->returnValue( true ) )
		;
		$this->assertEquals( 1, $config->mustAddMatchedRecords() );
	}
	
	/**
	 * @covers Wikia\Search\Config::setNamespaces
	 */
	public function testSetNamespaces() {
		$config = new Config;
		$ns = [ 1, 2, 3, 4 ,5, 6, 7, 8, 9 ];
		$this->assertEquals(
				$config,
				$config->setNamespaces( $ns )
		);
		$this->assertAttributeEquals(
				$ns,
				'namespaces',
				$config
		);
		
	}
	
	/**
	 * @group Slow
	 * @slowExecutionTime 0.07548 ms
	 * @covers Wikia\Search\Config::getNamespaces
	 */
	public function testGetNamespacesLazyLoad() {
		$config = $this->getMockBuilder( 'Wikia\Search\Config' )
		               ->disableOriginalConstructor()
		               ->setMethods( [ 'getService' ] )
		               ->getMock();
		
		$service = $this->getMockBuilder( 'Wikia\Search\MediaWikiService' )
		                ->disableOriginalConstructor()
		                ->setMethods( [ 'getDefaultNamespacesFromSearchEngine' ] )
		                ->getMock();
		
		$ns = [ 1, 2, 3, 4, 5 ];
		$this->assertAttributeEmpty(
				'namespaces',
				$config
		);
		$config
		    ->expects( $this->once() )
		    ->method ( 'getService' )
		    ->will   ( $this->returnValue( $service ) )
		;
		$service
		    ->expects( $this->once() )
		    ->method ( "getDefaultNamespacesFromSearchEngine" )
		    ->will   ( $this->returnValue( $ns ) )
		;
		$this->assertEquals(
				$ns,
				$config->getNamespaces()
		);
		$this->assertAttributeEquals(
				$ns,
				'namespaces',
				$config
		);
	}
	
	/**
	 * @group Slow
	 * @slowExecutionTime 0.07538 ms
	 * @covers Wikia\Search\Config::getNamespaces
	 */
	public function testGetNamespacesWithQueryNamespace() {
		$config = $this->getMockBuilder( 'Wikia\Search\Config' )
		               ->disableOriginalConstructor()
		               ->setMethods( [ 'getService' ] )
		               ->getMock();
		
		$ns = [ 1, 2, 3, 4, 5 ];
		$newNs = array_merge( $ns, [ 6 ] );
		$config->setNamespaces( $ns );
		
		$qn = new ReflectionProperty( 'Wikia\Search\Config', 'queryNamespace' );
		$qn->setAccessible( true );
		$qn->setValue( $config, 6 );
		
		$config
		    ->expects( $this->never() )
		    ->method ( 'getService' )
		;
		$this->assertEquals(
				$newNs,
				$config->getNamespaces()
		);
		$this->assertAttributeEquals(
				$newNs,
				'namespaces',
				$config
		);
	}
	
	/**
	 * @group Slow
	 * @slowExecutionTime 0.07537 ms
	 * @covers Wikia\Search\Config::setRank
	 * @covers Wikia\Search\Config::getRank
	 * @covers Wikia\Search\Config::getSort
	 */
	public function testSetGetRankGetSort() {
		$config = new Config;
		$this->assertAttributeEquals(
				[ 'score', 'desc' ],
				'sort',
				$config
		);
		$this->assertAttributeEquals(
				'default',
				'rank',
				$config
		);
		$this->assertEquals(
				$config,
				$config->setRank( $config::RANK_MOST_VIEWED )
		);
		$this->assertEquals(
				$config::RANK_MOST_VIEWED,
				$config->getRank()
		);
		$this->assertEquals(
				[ 'views', 'desc' ],
				$config->getSort()
		);
		$this->assertAttributeEquals(
				$config::RANK_MOST_VIEWED,
				'rank',
				$config
		);
	}
	
	/**
	 * @group Slow
	 * @slowExecutionTime 0.07327 ms
	 * @covers Wikia\Search\Config::setRequestedFields
	 */
	public function testSetRequestedFields() {
		$config = new Config;
		$fields = [ 'fake', 'fake2', 'fake3' ];
		$this->assertEquals(
				$config,
				$config->setRequestedFields( $fields )
		);
		$this->assertAttributeEquals(
				$fields,
				'requestedFields',
				$config
		);
	}
	
	/**
	 * @group Slow
	 * @slowExecutionTime 0.07447 ms
	 * @covers Wikia\Search\Config::setRank
	 */
	public function testSetRankBadRankName() {
		$config = new Config;
		$this->assertEquals(
				$config,
				$config->setRank( 'this is a totally fake rank' ),
				'Setting an incorrect rank on config should fail gracefully'
		);
		$this->assertEquals(
				$config::RANK_DEFAULT,
				$config->getRank(),
				'An incorrect rank value should not mutate the config rank propery'
		);
	}

	/**
	 * @group Slow
	 * @slowExecutionTime 0.07418 ms
	 * @covers Wikia\Search\Config::setHub
	 * @covers Wikia\Search\Config::getHub
	 */
	public function testSetGetHub() {
		$hub = 'Entertainment';
		$config = new Config;
		$this->assertEquals(
				$config,
				$config->setHub( $hub )
		);
		$this->assertAttributeEquals(
				$hub,
				'hub',
				$config
		);
		$this->assertEquals(
				$hub,
				$config->getHub()
		);
	}
	
	/**
	 * @group Slow
	 * @slowExecutionTime 0.07394 ms
	 * @covers Wikia\Search\Config::setAdvanced
	 * @covers Wikia\Search\Config::getAdvanced
	 */
	public function testSetGetAdvanced() {
		$config = new Config;
		$this->assertEquals(
				$config,
				$config->setAdvanced( true )
		);
		$this->assertAttributeEquals(
				true,
				'advanced',
				$config
		);
		$this->assertEquals(
				true,
				$config->getAdvanced()
		);
	}
	
	/**
	 * @group Slow
	 * @slowExecutionTime 0.07453 ms
	 * @covers Wikia\Search\Config::setError
	 * @covers Wikia\Search\Config::getError
	 */
	public function testSetGetError() {
		$error = $this->getMockBuilder( 'Exception' )
		              ->disableOriginalConstructor()
		              ->getMock();
		$config = new Config;
		$this->assertEquals(
				$config,
				$config->setError( $error )
		);
		$this->assertAttributeEquals(
				$error,
				'error',
				$config
		);
		$this->assertEquals(
				$error,
				$config->getError()
		);
	}
	
	/**
	 * @group Slow
	 * @slowExecutionTime 0.07416 ms
	 * @covers Wikia\Search\Config::setSkipBoostFunctions
	 * @covers Wikia\Search\Config::getSkipBoostFunctions
	 */
	public function testSetGetSkipboostFunctions() {
		$config = new Config;
		$this->assertEquals(
				$config,
				$config->setSkipBoostFunctions( true )
		);
		$this->assertAttributeEquals(
				true,
				'skipBoostFunctions',
				$config
		);
		$this->assertEquals(
				true,
				$config->getSkipBoostFunctions()
		);
	}
	
	/**
	 * @group Slow
	 * @slowExecutionTime 0.07473 ms
	 * @covers Wikia\Search\Config::setQueryService
	 */
	public function testSetQueryServiceNonExistentClass() {
		$config = new Config;
		$meth = new ReflectionMethod( $config, 'setQueryService' );
		$meth->setAccessible( true );
		try {
			$meth->invoke( $config, 'this will never be a class', true );
		} catch ( \Exception $e ) { }
		$this->assertInstanceOf(
				'Exception',
				$e
		);
	}
	
	/**
	 * @covers Wikia\Search\Config::setQueryService
	 */
	public function testSetQueryService() {
		$config = new Config;
		$meth = new ReflectionMethod( $config, 'setQueryService' );
		$meth->setAccessible( true );
		$this->assertEquals(
				$config,
				$meth->invoke( $config, 'Select\\Dismax\\OnWiki', true )
		);
		$this->assertAttributeEquals(
				'Select\\Dismax\\OnWiki',
				'queryService',
				$config
		);
		$meth->invoke( $config, 'Select\\Dismax\\Video', false );
		$this->assertAttributeEquals(
				'Select\\Dismax\\OnWiki',
				'queryService',
				$config,
				'We should be able to vacuously "unapply" unregistered query services'
		);
		$meth->invoke( $config, 'Select\\Dismax\\OnWiki', false );
		$this->assertAttributeEquals(
				null,
				'queryService',
				$config,
				'Apply as false means we now have no query service registered'
		);
	}
	
	/**
	 * @group Slow
	 * @slowExecutionTime 0.0772 ms
	 * @covers Wikia\Search\Config::bootstrapQueryService
	 */
	public function testBootstrapQueryServiceDefault() {
		$config = $this->getMockBuilder( 'Wikia\Search\Config' )
		               ->disableOriginalConstructor()
		               ->setMethods( [ 'getWikiId', 'getService' ] )
		               ->getMock();
		
		$service = $this->getMock( 'Wikia\Search\MediaWikiService', [ 'getGlobal' ] );
		$bs = new ReflectionMethod( $config, 'bootstrapQueryService' );
		$bs->setAccessible( true );
		$config
		    ->expects( $this->once() )
		    ->method ( 'getWikiId' )
		    ->will   ( $this->returnValue( 123 ) )
		;
		$config
		    ->expects( $this->once() )
		    ->method ( 'getService' )
		    ->will   ( $this->returnValue( $service ) )
		;
		$service
		    ->expects( $this->once() )
		    ->method ( 'getGlobal' )
		    ->with   ( 'EnableWikiaHomePageExt' )
		    ->will   ( $this->returnValue( false ) )
		;
		$this->assertEquals(
				'Select\\Dismax\\OnWiki',
				$bs->invoke( $config )
		);
	}
	
	/**
	 * @group Slow
	 * @slowExecutionTime 0.0758 ms
	 * @covers Wikia\Search\Config::bootstrapQueryService
	 */
	public function testBootstrapQueryServiceVideo() {
		$config = $this->getMockBuilder( 'Wikia\Search\Config' )
		               ->disableOriginalConstructor()
		               ->setMethods( [ 'getWikiId', 'getService' ] )
		               ->getMock();
		
		$service = $this->getMock( 'Wikia\Search\MediaWikiService', [ 'getGlobal' ] );
		$bs = new ReflectionMethod( $config, 'bootstrapQueryService' );
		$bs->setAccessible( true );
		$config
		    ->expects( $this->once() )
		    ->method ( 'getWikiId' )
		    ->will   ( $this->returnValue( \Wikia\Search\QueryService\Select\Dismax\Video::VIDEO_WIKI_ID ) )
		;
		$config
		    ->expects( $this->once() )
		    ->method ( 'getService' )
		    ->will   ( $this->returnValue( $service ) )
		;
		$service
		    ->expects( $this->once() )
		    ->method ( 'getGlobal' )
		    ->with   ( 'EnableWikiaHomePageExt' )
		    ->will   ( $this->returnValue( false ) )
		;
		$this->assertEquals(
				'Select\\Dismax\\Video',
				$bs->invoke( $config )
		);
	}
	
	/**
	 * @group Slow
	 * @slowExecutionTime 0.07578 ms
	 * @covers Wikia\Search\Config::bootstrapQueryService
	 */
	public function testBootstrapQueryServiceInterWiki() {
		$config = $this->getMockBuilder( 'Wikia\Search\Config' )
		               ->disableOriginalConstructor()
		               ->setMethods( [ 'getWikiId', 'getService' ] )
		               ->getMock();
		
		$service = $this->getMock( 'Wikia\Search\MediaWikiService', [ 'getGlobal' ] );
		$bs = new ReflectionMethod( $config, 'bootstrapQueryService' );
		$bs->setAccessible( true );
		$config
		    ->expects( $this->once() )
		    ->method ( 'getWikiId' )
		    ->will   ( $this->returnValue( 123 ) )
		;
		$config
		    ->expects( $this->once() )
		    ->method ( 'getService' )
		    ->will   ( $this->returnValue( $service ) )
		;
		$service
		    ->expects( $this->once() )
		    ->method ( 'getGlobal' )
		    ->with   ( 'EnableWikiaHomePageExt' )
		    ->will   ( $this->returnValue( true ) )
		;
		$this->assertEquals(
				'Select\\Dismax\\InterWiki',
				$bs->invoke( $config )
		);
	}
	
	/**
	 * @group Slow
	 * @slowExecutionTime 0.07476 ms
	 * @covers Wikia\Search\Config::getQueryService
	 */
	public function testGetQueryService() {
		$config = $this->getMockBuilder( 'Wikia\Search\Config' )
		               ->disableOriginalConstructor()
		               ->setMethods( [ 'bootstrapQueryService' ] )
		               ->getMock();
		
		$config
		    ->expects( $this->once() )
		    ->method ( "bootstrapQueryService" )
		    ->will   ( $this->returnValue( 'Select\\Dismax\\OnWiki' ) )
		;
		$this->assertEquals(
				'\\Wikia\\Search\\QueryService\\Select\\Dismax\\OnWiki',
				$config->getQueryService()
		);
		$this->assertEquals(
				'\\Wikia\\Search\\QueryService\\Select\\Dismax\\OnWiki',
				$config->getQueryService(),
				"Run a second time to ensure we only call bootstrapQueryService once"
		);
	}
	
	/**
	 * @group Slow
	 * @slowExecutionTime 0.07508 ms
	 * @covers Wikia\Search\Config::getService
	 */
	public function testGetService() {
		$config = new Config;
		$meth = new ReflectionMethod( $config, 'getService' );
		$meth->setAccessible( true );
		$this->assertAttributeEmpty(
				'service',
				$config
		);
		$this->assertInstanceOf(
				'Wikia\Search\MediaWikiService',
				$meth->invoke( $config )
		);
		$this->assertAttributeInstanceOf(
				'Wikia\Search\MediaWikiService',
				'service',
				$config
		);
	}
	
	/**
	 * @group Slow
	 * @slowExecutionTime 0.07596 ms
	 * @covers Wikia\Search\Config::getQueryFieldsToBoosts
	 */
	public function testGetQueryFieldsToBoosts() {
		$testProfile = $this->getMock( 'Wikia\\Search\\TestProfile\\Base', [ 'getQueryFieldsToBoosts' ] );
		$config = $this->getMock( 'Wikia\\Search\\Config', [ 'getTestProfile' ] );
		$qf2b = [ 'foo_txt' => 100 ];
		$config
		    ->expects( $this->once() )
		    ->method ( 'getTestProfile' )
		    ->will   ( $this->returnValue( $testProfile ) )
		;
		$testProfile
		    ->expects( $this->once() )
		    ->method ( 'getQueryFieldsToBoosts' )
		    ->will   ( $this->returnValue( $qf2b ) )
		;
		$this->assertEquals(
				$qf2b,
				$config->getQueryFieldsToBoosts()
		);
	}
	
	/**
	 * @covers Wikia\Search\Config::getQueryFields
	 */
	public function testGetQueryFields() {
		$config = $this->getMock( 'Wikia\\Search\\Config', [ 'getQueryFieldsToBoosts' ] );
		$qf2b = [ 'foo_txt' => 100 ];
		$config
		    ->expects( $this->once() )
		    ->method ( 'getQueryFieldsToBoosts' )
		    ->will   ( $this->returnValue( $qf2b ) )
		;
		$this->assertEquals(
				[ 'foo_txt' ],
				$config->getQueryFields()
		);
	}
	
	/**
	 * @group Slow
	 * @slowExecutionTime 0.0751 ms
	 * @covers Wikia\Search\Config::getResults
	 */
	public function testSetGetResults() {
		$config = new Config;
		$this->assertAttributeEmpty(
				'results',
				$config
		);
		$results = $this->getMockBuilder( 'Wikia\\Search\\ResultSet\\Base' )
		                ->disableOriginalConstructor()
		                ->getMock();
		$this->assertEquals(
				$config,
				$config->setResults( $results )
		);
		$this->assertAttributeEquals(
				$results,
				'results',
				$config
		);
		$this->assertEquals(
				$results,
				$config->getResults()
		);
	}
	
	/**
	 * @group Slow
	 * @slowExecutionTime 0.07594 ms
	 * @covers Wikia\Search\Config::getResultsFound
	 */
	public function testGetResultsFound() {
		$config = new Config;
		
		$this->assertEquals(
				0,
				$config->getResultsFound(),
				'With no result set, config should say results found is zero'
		);
		
		$results = $this->getMockBuilder( 'Wikia\\Search\\ResultSet\\Base' )
		                ->disableOriginalConstructor()
		                ->setMethods( [ 'getResultsFound' ] )
		                ->getMock();
		
		$results
		    ->expects( $this->once() )
		    ->method ( 'getResultsFound' )
		    ->will   ( $this->returnValue( 100 ) )
		;
		
		$config->setResults( $results );
		
		$this->assertEquals(
				100,
				$config->getResultsFound() 
		);		
	}
}
