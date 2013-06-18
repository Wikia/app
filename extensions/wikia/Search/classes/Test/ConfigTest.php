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

		$mockWikiMatch
			->expects( $this->exactly( 2 ) )
			->method( 'getId' )
			->will( $this->returnValue( 0 ) )
		;
		$wikiService = $this->getMock( 'Wikia\Search\MediaWikiService', [ 'getGlobalForWiki' ] );

		$wikiService
			->expects( $this->exactly( 2 ) )
			->method( 'getGlobalForWiki' )
			->with( 'wgLanguageCode', 0 )
			->will( $this->returnValue( 'en' ) )
		;

		$config = $this->getMockBuilder( 'Wikia\Search\Config' )
			->disableOriginalConstructor()
			->setMethods( [ 'getService' ] )
			->getMock()
		;
		$config
			->expects( $this->exactly( 2 ) )
			->method( 'getService' )
			->will( $this->returnValue( $wikiService ) )
		;

		$this->assertFalse(
				$config->hasWikiMatch(),
				'\Wikia\Search\Config should not have an wiki match by default.'
		);
		$this->assertNull(
				$config->getWikiMatch(),
				'\Wikia\Search\Config should return null when getting an uninitialized wiki match'
		);

		$config->setLanguageCode( 'pl' );
		$config->setWikiMatch( $mockWikiMatch );
		$this->assertNull(
				$config->getWikiMatch(),
				'\Wikia\Search\Config::setWikiMatch should not set match if lang is not correct'
		);

		$config->setLanguageCode( 'en' );

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
		$config = $this->getMockBuilder( 'Wikia\Search\Config' )
		               ->disableOriginalConstructor()
		               ->setMethods( [ 'bootstrapQueryService' ] )
		               ->getMock();
		
		$config
		    ->expects( $this->once() )
		    ->method ( 'bootstrapQueryService' )
		    ->will   ( $this->returnValue( 'Select\\OnWiki' ) )
		;
		$this->assertFalse(
				$config->getInterWiki()
		);
		$this->assertEquals(
				$config,
				$config->setInterWiki( true )
		);
		$this->assertTrue(
				$config->getInterWiki()
		);
		$this->assertAttributeEquals(
				'Select\\InterWiki',
				'queryService',
				$config
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
	 * @covers \Wikia\Search\Config::getRequestedFields
	 */
	public function testGetRequestedFieldsWithVideo() {
		$mockConfig = $this->getMock( 'Wikia\Search\Config', [ 'getQueryService' ] );
		$mockConfig->setRequestedFields( [ 'id' ] );
		$this->assertAttributeEquals(
				[ 'id' ],
				'requestedFields',
				$mockConfig
		);
		$mockConfig
		    ->expects( $this->once() )
		    ->method ( 'getQueryService' )
		    ->will   ( $this->returnValue( '\\Wikia\Search\\QueryService\\Select\\Video' ) )
		;
		$this->assertContains(
				'title_en',
				$mockConfig->getRequestedFields(),
				'A video search should always include title_en as a requested field'
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
		$config = $this->getMockBuilder( 'Wikia\Search\Config' )
		               ->disableOriginalConstructor()
		               ->setMethods( [ 'importQueryFieldBoosts' ] )
		               ->getMock();
		
		$fields = [ 'html' => 100 ];
		
		$reflAttr = new \ReflectionProperty( 'Wikia\Search\Config', 'queryFieldsToBoosts' );
		$reflAttr->setAccessible( true );
		$reflAttr->setValue( $config, $fields ); 
		
		$config
		    ->expects( $this->once() )
		    ->method ( 'importQueryFieldBoosts' )
		;
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
	public function testImportQueryFieldBoostsFirstTime() {
		$config = $this->getMockBuilder( '\Wikia\Search\Config' )
		               ->disableOriginalConstructor()
		               ->setMethods( array( 'getTestProfile' ) )
		               ->getMock();
		
		$testProfile = $this->getMockbuilder( 'Wikia\Search\TestProfile\Base' )
		                    ->disableOriginalConstructor()
		                    ->setMethods( [ 'getQueryFieldsToBoosts' ] )
		                    ->getMock();
		$fields = [ 'html' => 100 ];
		$config
		    ->expects( $this->once() )
		    ->method ( 'getTestProfile' )
		    ->will   ( $this->returnValue( $testProfile ) )
		;
		$testProfile
		    ->expects( $this->once() )
		    ->method ( "getQueryFieldsToBoosts" )
		    ->will   ( $this->returnValue( $fields ) )
		;
		
		$methodrefl = new ReflectionMethod( '\Wikia\Search\Config', 'importQueryFieldBoosts' );
		$methodrefl->setAccessible( true );
		$this->assertEquals(
				$config,
				$methodrefl->invoke( $config )
		);
		$this->assertAttributeEquals(
				$fields,
				'queryFieldsToBoosts',
				$config
		);
		$this->assertAttributeEquals(
				true,
				'queryFieldsWereImported',
				$config
		);
	}
	
	/**
	 * @covers \Wikia\Search\Config::importQueryFieldBoosts
	 */
	public function testImportQueryFieldBoostsConsecutiveTimes() {
		$config = $this->getMockBuilder( '\Wikia\Search\Config' )
		               ->disableOriginalConstructor()
		               ->setMethods( array( 'getTestProfile' ) )
		               ->getMock();
		
		$testProfile = $this->getMockbuilder( 'Wikia\Search\TestProfile\Base' )
		                    ->disableOriginalConstructor()
		                    ->setMethods( [ 'getQueryFieldsToBoosts' ] )
		                    ->getMock();
		$prop = new ReflectionProperty( 'Wikia\Search\Config', 'queryFieldsWereImported' );
		$prop->setAccessible( true );
		$prop->setValue( $config, true );
		$config
		    ->expects( $this->never() )
		    ->method ( 'getTestProfile' )
		;
		$testProfile
		    ->expects( $this->never() )
		    ->method ( "getQueryFieldsToBoosts" )
		;
		
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

	/**
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
	 * @covers Wikia\Search\Config
	 */
	public function testSetGetABTestGroup() {
		$config = new Config;
		$this->assertAttributeEmpty(
				'ABTestGroup',
				$config
		);
		$this->assertEquals(
				$config,
				$config->setABTestGroup( 'A' )
		);
		$this->assertAttributeEquals(
				'A',
				'ABTestGroup',
				$config
		);
		$this->assertEquals(
				'A',
				$config->getABTestGroup()
		);
	}
	
	/**
	 * @covers Wikia\Search\Config::getTestProfile
	 * @covers Wikia\Search\Config::initiateTestProfile
	 */
	public function testGetTestProfileNotSet() {
		$config = new Config;
		$this->assertAttributeEmpty(
				'ABTestGroup',
				$config
		);
		$this->assertInstanceOf(
				'Wikia\Search\TestProfile\Base',
				$config->getTestProfile(),
				'The default test group should be Base'
		);
	}
	
	/**
	 * @covers Wikia\Search\Config::getTestProfile
	 * @covers Wikia\Search\Config::initiateTestProfile
	 */
	public function testGetTestProfileExplicitBase() {
		$config = new Config;
		$config->setABTestGroup( 'Base' );
		$this->assertInstanceOf(
				'Wikia\Search\TestProfile\Base',
				$config->getTestProfile(),
				'We should support explicitly setting "Base" as the test group.'
		);
		// note that this is really just a logic hack -- we're using the backoff tested below for now
	}

	/**
	 * @covers Wikia\Search\Config::getTestProfile
	 * @covers Wikia\Search\Config::initiateTestProfile
	 */
	public function testGetTestProfileWithTestGroup() {
		$config = new Config;
		$config->setABTestGroup( 'A' );
		$this->assertInstanceOf(
				'Wikia\Search\TestProfile\GroupA',
				$config->getTestProfile(),
				'We should be able to access the correct test profile when given a letter value'
		);
	}

	/**
	 * @covers Wikia\Search\Config::getTestProfile
	 * @covers Wikia\Search\Config::initiateTestProfile
	 */
	public function testGetTestProfileNonexistentTestGroup() {
		$config = new Config;
		$config->setABTestGroup( 'THIS_AINT_NO_TEST_GROUP' );
		$this->assertInstanceOf(
				'Wikia\Search\TestProfile\Base',
				$config->getTestProfile(),
				'A non-existent test group should back off to base'
		);
	}
	
	/**
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
	 * @covers Wikia\Search\Config::getLength
	 */
	public function testGetLengthWithMatch() {
		$config = $this->getMockBuilder( 'Wikia\Search\Config' )
		               ->disableOriginalConstructor()
		               ->setMethods( [ 'hasMatch', 'getStart' ] )
		               ->getMock();
		
		$config
		    ->expects( $this->once() )
		    ->method ( 'hasMatch' )
		    ->will   ( $this->returnValue( true ) )
		;
		$config
		    ->expects( $this->once() )
		    ->method ( "getStart" )
		    ->will   ( $this->returnValue( 0 ) )
		;
		$this->assertAttributeEquals(
				$config->getLength() + 1,
				'limit',
				$config,
				'Wikia\Search\Config::getLength should be limit -1 if we have a match'
		);
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
				$meth->invoke( $config, 'Select\\OnWiki', true )
		);
		$this->assertAttributeEquals(
				'Select\\OnWiki',
				'queryService',
				$config
		);
		$meth->invoke( $config, 'Select\\Video', false );
		$this->assertAttributeEquals(
				'Select\\OnWiki',
				'queryService',
				$config,
				'We should be able to vacuously "unapply" unregistered query services'
		);
		$meth->invoke( $config, 'Select\\OnWiki', false );
		$this->assertAttributeEquals(
				null,
				'queryService',
				$config,
				'Apply as false means we now have no query service registered'
		);
	}
	
	/**
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
				'Select\\OnWiki',
				$bs->invoke( $config )
		);
	}
	
	/**
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
		    ->will   ( $this->returnValue( \Wikia\Search\QueryService\Select\Video::VIDEO_WIKI_ID ) )
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
				'Select\\Video',
				$bs->invoke( $config )
		);
	}
	
	/**
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
				'Select\\InterWiki',
				$bs->invoke( $config )
		);
	}
	
	/**
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
		    ->will   ( $this->returnValue( 'Select\\OnWiki' ) )
		;
		$this->assertEquals(
				'\\Wikia\\Search\\QueryService\\Select\\OnWiki',
				$config->getQueryService()
		);
		$this->assertEquals(
				'\\Wikia\\Search\\QueryService\\Select\\OnWiki',
				$config->getQueryService(),
				"Run a second time to ensure we only call bootstrapQueryService once"
		);
	}
	
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
}