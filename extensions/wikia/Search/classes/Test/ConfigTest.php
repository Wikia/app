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
	 * @covers \Wikia\Search\Config::getSort
	 * @todo fix
	 */
	public function testGetSort() {return;
		$config = new \Wikia\Search\Config;

		$defaultRank = array( 'score',		Solarium_Query_Select::SORT_DESC );

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

		$config->setSort( array( 'created', 'asc' ) );

		$this->assertEquals(
				array( 'created', 'asc' ),
				$config->getSort(),
				'\Wikia\Search\Config::getSort should return a value set by setSort if it has been invoked'
		);
	}

	/**
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
		$config = new \Wikia\Search\Config();

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
		$config = new \Wikia\Search\Config();

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
	 * @covers \Wikia\Search\Config::getInterWiki
	 * @covers \Wikia\Search\Config::setInterWiki
	 */
	public function testInterWiki() {
		$config	= new \Wikia\Search\Config;

		$this->assertFalse(
				$config->getInterWiki(),
				'Interwiki accessor method should be false by default.'
		);
		$this->assertEquals(
				$config,
				$config->setInterWiki( true ),
				'WikiaSearch::setInterWiki should provide fluent interface.'
		);
		$this->assertTrue(
				$config->getInterWiki(),
				'Interwiki accessor method should always have the same value, regardless of previous mutated state.'
		);
	}

	/**
	 * @covers \Wikia\Search\Config::getTruncatedResultsNum
	 * @todo mock this better now that we directly grab this val from resultset
	 */
	public function testGetTruncatedResultsNum() {return;
		$config	= new \Wikia\Search\Config;

		$singleDigit = 9;

		$config->setResultsFound( $singleDigit );

		$this->assertEquals(
				$singleDigit,
				$config->getTruncatedResultsNum(),
				"We should not truncate a single digit result number value."
		);

		$doubleDigit = 26;

		$config->setResultsFound( $doubleDigit );

		$this->assertEquals(
				30,
				$config->getTruncatedResultsNum(),
				"We should round only for double digits."
		);

		$tripleDigit = 492;

		$config->setResultsFound( $tripleDigit );

		$this->assertEquals(
				500,
				$config->getTruncatedResultsNum(),
				"We should round to hundreds for triple digits."
		);

		$bigDigit = 55555;

		$config->setResultsFound( $bigDigit );

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
		$this->setService( $config, $service );
		$this->assertEquals(
				'56,000',
				$config->getTruncatedResultsNum( true )
		);
		
	}

	/**
	 * @covers \Wikia\Search\Config::getNumPages
	 * @todo mock better
	 */
	public function testGetNumPages() { return;
		$config = new \Wikia\Search\Config;

		$this->assertEquals(
				0,
				$config->getNumPages(),
				'Number of pages should default to zero.'
		);

		$numFound = 50;
		$config->setResultsFound( $numFound );

		$this->assertEquals(
				ceil( $numFound / \Wikia\Search\Config::RESULTS_PER_PAGE ),
				$config->getNumPages(),
				'Number of pages should be divided by default number of results per page by if no limit is set.'
		);

		$newLimit = 20;
		$config->setLimit( $newLimit );

		$this->assertEquals(
		        ceil( $numFound / $newLimit ),
		        $config->getNumPages(),
		        'Number of pages should be informed by limit set by user.'
		);
	}

	/**
	 * @covers \Wikia\Search\Config::getCityId
	 * @covers \Wikia\Search\Config::setCityID
	 * @todo fix
	 */
	public function testGetCityId() {return;
		$config = new Config;

		$mockCityId = 123;
		global $wgCityId;

		$config->setInterWiki( true );
		$this->assertEquals(
				0,
				$config->getCityId(),
				'City ID should be zero by default, but only when interwiki.'
		);

		$this->assertEquals(
				$wgCityId,
				$config->setIsInterWiki( false )->getCityId(),
				'City ID should default to wgCityId if the config is not interwiki.'
		);
		$this->assertEquals(
				456,
				$config->setCityID( 456 )->getCityId(),
				'If we set a different city ID, we should get a different city ID.'
		);
	}

	/**
	 * @covers \Wikia\Search\Config::getSearchProfiles
	 */
	public function testGetSearchProfiles() {
		$config 			= new Config;
		$searchEngineMock	= $this->getMock( 'SearchEngine', array( 'defaultNamespaces', 'searchableNamespaces', 'namespacesAsText' ), array() );

		$searchEngineMock
			->staticExpects	( $this->any() )
			->method		( 'searchableNamespaces' )
			->will			( $this->returnValue( array( NS_MAIN, NS_TALK, NS_CATEGORY, NS_FILE, NS_USER ) ) )
		;
		$searchEngineMock
			->staticExpects	( $this->any() )
			->method		( 'defaultNamespaces' )
			->will			( $this->returnValue( array( NS_FILE, NS_CATEGORY ) ) )
		;
		$searchEngineMock
			->staticExpects	( $this->any() )
			->method		( 'namespacesAsText' )
			->will			( $this->returnValue( 'Article', 'Category' ) )
		;

		$this->mockClass( 'SearchEngine', $searchEngineMock );
		$this->mockApp();

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
		$this->mockApp();
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
	 * @covers \Wikia\Search\Config::getRequestedFields
	 */
	public function testGetRequestedFields() {
		$config = new Config;

		$config->setRequestedFields( array( 'html' ) );

		$fields = $config->getRequestedFields();

		$this->assertContains(
				Utilities::field( 'html' ),
				$fields,
				'\Wikia\Search\Config::getRequestedFields() should perform language field transformation'
		);
		$this->assertContains(
				'id',
				$fields,
				'\Wikia\Search\Config::getRequestedFields() should always include an id'
		);
	}

	/**
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
	 * @covers \Wikia\Search\Config::setQueryField
	 */
	public function testSetQueryField() {
		$config = new \Wikia\Search\Config();
		$this->assertEquals(
				$config,
				$config->setQueryField( 'foo' )
		);
		$this->assertEquals(
				$config,
				$config->setQueryField( 'bar', 2 )
		);
		$queryFieldsToBoostsRefl = new ReflectionProperty( '\Wikia\Search\Config', 'queryFieldsToBoosts' );
		$queryFieldsToBoostsRefl->setAccessible( true );
		$fields = $queryFieldsToBoostsRefl->getValue( $config );
		$this->assertArrayHasKey(
				'foo',
				$fields
		);
		$this->assertArrayHasKey(
				'bar',
				$fields
		);
		$this->assertEquals(
				1,
				$fields['foo'],
				'\Wikia\Search\Config::setQueryField should set the boost value to 1 for a key by default'
		);
		$this->assertEquals(
				2,
				$fields['bar'],
				'\Wikia\Search\Config::setQueryField should set the boost value as passed in the second parameter'
		);
	}
	
	/**
	 * @covers \Wikia\Search\Config::setQueryFields
	 */
	public function testSetQueryFields() {
		$config = new \Wikia\Search\Config();
		$config->setQueryFields( array( 'foo', 'bar', 'baz' ) );
		$queryFieldsToBoostsRefl = new ReflectionProperty( '\Wikia\Search\Config', 'queryFieldsToBoosts' );
		$queryFieldsToBoostsRefl->setAccessible( true );
		$fields = $queryFieldsToBoostsRefl->getValue( $config );
		$this->assertEquals(
				array( 'foo' => 1, 'bar' => 1, 'baz' => 1 ),
				$fields,
				'If passed a flat array, \Wikia\Search\Config::addQueryFields should set the boost for each as 1'
		);
		$sentFields = array( 'foo' => 1, 'bar' => 2, 'baz' => 3 );
		$this->assertEquals(
				$config,
				$config->setQueryFields( $sentFields )
		);
		$fields = $queryFieldsToBoostsRefl->getValue( $config );
		$this->assertEquals(
				$sentFields,
				$fields,
				'If passed a flat array, \Wikia\Search\Config::addQueryFields should set the boost for each as 1'
		);
	}
	
	/**
	 * @covers \Wikia\Search\Config::addQueryFields
	 */
	public function testAddQueryFields() {
		$config = $this->config->setMethods( array( 'setQueryField' ) )->getMock();
		$config
		    ->expects( $this->at( 0 ) )
		    ->method ( 'setQueryField' )
		    ->with   ( 'foo', 1 )
		;
		$this->assertEquals(
				$config,
				$config->addQueryFields( array( 'foo' ) )
		);
		$config
		    ->expects( $this->at( 0 ) )
		    ->method ( 'setQueryField' )
		    ->with   ( 'foo', 5 )
		;
		$this->assertEquals(
				$config,
				$config->addQueryFields( array( 'foo' => 5 ) )
		); 
	}
	
	/**
	 * @covers \Wikia\Search\Config::getQueryFieldsToBoosts
	 */
	public function testGetQueryFieldsToBoosts() {
		$config = new \Wikia\Search\Config();
		$queryFieldsToBoostsRefl = new ReflectionProperty( '\Wikia\Search\Config', 'queryFieldsToBoosts' );
		$queryFieldsToBoostsRefl->setAccessible( true );
		$fields = $queryFieldsToBoostsRefl->getValue( $config );
		$this->assertEquals(
				$fields,
				$config->getQueryFieldsToBoosts(),
				'\Wikia\Search\Config::getQueryFieldsToBoosts should return the qf to boost array'
		);
	}
	
	/**
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
	 * @covers \Wikia\Search\Config::importQueryFieldBoosts
	 */
	public function testImportQueryFieldBoosts() {
		$config = $this->getMockBuilder( '\Wikia\Search\Config' )
		               ->disableOriginalConstructor()
		               ->setMethods( array( 'setQueryField' ) )
		               ->getMock();
		
		$service = $this->getMockBuilder( '\Wikia\Search\MediaWikiService' )
		                  ->disableOriginalConstructor()
		                  ->setMethods( array( 'getGlobalWithDefault' ) )
		                  ->getMock();
		
		$service
		    ->expects( $this->once() )
		    ->method ( 'getGlobalWithDefault' )
		    ->with   ( 'SearchBoostFor_title', 5 )
		    ->will   ( $this->returnValue( 5 ) ) // value doesn't matter -- that's why we test this method separately 
		;
		$config
		    ->expects( $this->once() )
		    ->method ( 'setQueryField' )
		    ->with   ( 'title', 5 )
		;
		
		$fieldsrefl = new ReflectionProperty( '\Wikia\Search\Config', 'queryFieldsToBoosts' );
		$fieldsrefl->setAccessible( true );
		$fieldsrefl->setValue( $config, array( 'title' => 5 ) );
		
		$servicerefl = new ReflectionProperty( '\Wikia\Search\Config', 'service' );
		$servicerefl->setAccessible(true );
		$servicerefl->setValue( $config, $service );
		
		$methodrefl = new ReflectionMethod( '\Wikia\Search\Config', 'importQueryFieldBoosts' );
		$methodrefl->setAccessible( true );
		$this->assertEquals(
				$config,
				$methodrefl->invoke( $config )
		);
	}
	
	/**
	 * @covers \Wikia\Search\Config::getQueryFields
	 */
	public function testGetQueryFields() {
		$config = new \Wikia\Search\Config();
		$fieldsToBoosts = $config->getQueryFieldsToBoosts();
		$this->assertEquals(
				array_keys( $fieldsToBoosts ),
				$config->getQueryFields()
		);
	}
	
	/**
	 * @covers \Wikia\Search\Config::setQuery
	 * @covers \Wikia\Search\Config::getQuery
	 */
	public function testQueryMethods() {
		$mockQuery = $this->getMock( 'Wikia\Search\Query\Select', [ 'getNamespaceId' ], [ 'foo' ] );
		$mockConfig = $this->getMock( 'Wikia\Search\Config', [ 'getNamespaces' ] );
		
		$this->proxyClass( 'Wikia\Search\Query\Select', $mockQuery );
		$this->mockApp();
		
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
		$this->assertInstanceOf(
				$mockConfig->getQuery()->_mockClassName, // mockproxy hack
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
}