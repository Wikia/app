<?php

require_once( 'WikiaSearchBaseTest.php' );

class WikiaSearchTest extends WikiaSearchBaseTest {

	// bugid: 64199 -- reset language code
	public function setUp() {
		parent::setUp();
		global $wgLanguageCode;
		$this->defaultLanguageCode = $wgLanguageCode;
		$wgLanguageCode = 'en';
	}
	public function tearDown() {
		global $wgLanguageCode;
		$wgLanguageCode = $this->defaultLanguageCode;
		parent::tearDown();
	}

	/**
	 * Tests our support for dynamic fields
	 * @covers WikiaSearch::field
	 * @covers WikiaSearch::valueForField
	 */
	public function testFieldMethods() {

		// this is a supported language code
		$supportedLanguageCode = 'en';
		$this->mockGlobalVariable( 'wgLanguageCode', 					$supportedLanguageCode );
		$this->mockGlobalVariable( 'wgWikiaSearchSupportedLanguages',	array( 'en' ) );

		// The following rules apply only to supported languages

		// A field that is not dynamic should default to its field name
		$nonDynamicField	= 'backlinks'; // integer value of number of backlinks
		$nonDynamicOutput	= WikiaSearch::field( $nonDynamicField );
		$this->assertEquals( $nonDynamicField, $nonDynamicOutput,
							'A non-dynamic field was mutated during WikiaSearch::field()' );

		// A field that is dynamic should have the language code appended
		$dynamicField			= 'html';
		$dynamicOutput			= WikiaSearch::field( $dynamicField );
		$expectedDynamicOutput	= 'html_en';
		$this->assertEquals( $dynamicOutput, $expectedDynamicOutput,
							'A basic dynamic field did not have its language code appended during WikiaSearch::field()' );

		// You should be able to overwrite the default language by passing the field parameter
		$dynamicField			= 'html';
		$dynamicOutput			= WikiaSearch::field( $dynamicField, 'fr' );
		$expectedDynamicOutput	= 'html_fr';
		$this->assertEquals( $dynamicOutput, $expectedDynamicOutput,
		        'Providing a supported alternate language field did not correctly change a supported field during WikiaSearch::field()' );

		// But that language still needs to be supported
		$dynamicField			= 'html';
		$dynamicOutput			= WikiaSearch::field( $dynamicField, 'zz' );
		$expectedDynamicOutput	= 'html';
		$this->assertEquals( $dynamicOutput, $expectedDynamicOutput,
		        'An unsupported language field parameter should result in the default field name during WikiaSearch::field()' );

		// A field that is dynamic and multivalued should have '_mv' and the language code appended
		$dynamicMultiValuedField			= 'categories';
		$dynamicMultiValuedOutput			= WikiaSearch::field( $dynamicMultiValuedField );
		$expectedDynamicMultiValuedOutput	= 'categories_mv_en';
		$this->assertEquals( $dynamicMultiValuedOutput, $expectedDynamicMultiValuedOutput,
		        			'An dynamic multivalued field did not have the appropriate suffixes appended during WikiaSearch::field()' );

		// A field that is dynamic, unstored, and multivalued should have '_us_mv' and the language code appended
		$dynamicMultiValuedUnstoredField			= 'headings';
		$dynamicMultiValuedUnstoredOutput			= WikiaSearch::field( $dynamicMultiValuedUnstoredField );
		$expectedDynamicMultiValuedUnstoredOutput	= 'headings_us_mv_en';
		$this->assertEquals( $dynamicMultiValuedOutput, $expectedDynamicMultiValuedOutput,
		        			'An dynamic unstored multivalued field did not have the appropriate suffixes appended during WikiaSearch::field()' );

		// I just made this language code up.
		global $wgLanguageCode;
		$wgLanguageCode = 'zz';
		// When a language isn't supported, all of the above cases should return the actual name of the field
		foreach ( array( 'backlinks', 'html', 'first500', 'categories', 'headings') as $field ) {
			$this->assertEquals( $field, WikiaSearch::field( $field ), 'An unsupported language returned mutated fields from WikiaSearch::field()' );
		}

		// tests to make sure the valueForField method works as advertised (ignoring WikiaSearch::field() dependency since all tests passed)
		$this->assertEquals(
				'(foo:bar)',
				WikiaSearch::valueForField( 'foo', 'bar' ),
				'WikiaSearch::valueForField() should return Lucene query field wrapped in parens.'
		);
		$this->assertEquals(
				'(foo:bar)^5',
				WikiaSearch::valueForField( 'foo', 'bar', array( 'boost' => 5 ) ),
				'WikiaSearch::valueForField() should add Lucene query style boost with boost array param.'
		);
		$this->assertEquals(
				"(foo:'bar')",
				WikiaSearch::valueForField( 'foo', 'bar', array( 'quote'=>"'" ) ),
				'WikiaSearch::valueForField() should add wrap a search term in quotes with the provided quote param.'
		);
		$this->assertEquals(
				"(foo:'bar')^5",
				WikiaSearch::valueForField( 'foo', 'bar', array( 'quote' => "'", 'boost' => 5 ) ),
        		'WikiaSearch::valueForField() should be able to handle both quotes and boosts at the same time.'
		);
		$this->assertEquals(
				"-(foo:bar)",
				WikiaSearch::valueForField( 'foo', 'bar', array( 'negate' => true ) ),
				'WikiaSearch::valueForField() should add the Lucene negation operator if array param "negate" is set to true.'
		);
		$this->assertEquals(
				'(foo:bar\:\"baz\~\")',
				WikiaSearch::valueForField( 'foo', 'bar:"baz~"' ),
				'WikiaSearch::valueForField should sanitize the field value.'
		);
	}

	/**
	 * @covers WikiaSearch::getFilterQueryString
	 */
	public function testGetFilterQueryString()
	{
		$this->mockApp();
		$this->mockClass( 'Solarium_Client', $this->getMock( 'Solarium_Client', array('setAdapter') ) );

		$mockCityId 	= 123;
		$mockHub		= 'Games';
		$wikiaSearch	= F::build( 'WikiaSearch' );
		$searchConfig	= F::build( 'WikiaSearchConfig' );
		$searchConfig	->setCityId( $mockCityId );


		$method = new ReflectionMethod( 'WikiaSearch', 'getFilterQueryString' );
		$method->setAccessible( true );

		$this->assertEquals( "(wid:{$mockCityId})", $method->invoke( $wikiaSearch, $searchConfig ),
							'The default behavior for on-wiki search should be to filter query for wiki ID and against redirects.' );

		$searchConfig->setIncludeRedirects( true );

		$this->assertEquals( "(wid:{$mockCityId})", $method->invoke( $wikiaSearch, $searchConfig ),
							'If we have redirects configured to be included, we should not be filter against them in the filter query.' );

		$searchConfig->setVideoSearch( true );
		$searchConfig->setIncludeRedirects( false );
		$searchConfig->setIsInterWiki( true );

		$this->assertEquals( '(iscontent:true)', $method->invoke( $wikiaSearch, $searchConfig),
							'An interwiki search should filter for content pages only.' );

		$searchConfig->setHub( $mockHub );

		$this->assertEquals( '(iscontent:true) AND (hub:Games)', $method->invoke( $wikiaSearch, $searchConfig ),
							'An interwiki search with a hub should include the hub in the filter query.' );

	}

	/**
	 * @covers WikiaSearch::getBoostQueryString
	 */
	public function testGetBoostQueryString() {
		$this->mockApp();
		$this->mockClass( 'Solarium_Client', $this->getMock( 'Solarium_Client', array('setAdapter') ) );

		$wikiaSearch	= F::build( 'WikiaSearch' );
		$searchConfig	= F::build( 'WikiaSearchConfig' );

		$method = new ReflectionMethod( 'WikiaSearch', 'getBoostQueryString' );
		$method->setAccessible( true );

		$searchConfig->setQuery('foo bar');
		$this->assertEquals( '(html_en:\"foo bar\")^5 (title_en:\"foo bar\")^10',
							$method->invoke( $wikiaSearch, $searchConfig ),
							'WikiaSearch::getBoostQueryString should boost exact-match in quotes for html and title field'
							);

		$searchConfig->setQuery('"foo bar"');
		$this->assertEquals( '(html_en:\"foo bar\")^5 (title_en:\"foo bar\")^10',
					        $method->invoke( $wikiaSearch, $searchConfig ),
					        'WikiaSearch::getBoostQueryString should strip quotes from original query'
							);

		$searchConfig->setQuery("'foo bar'");
		$this->assertEquals( '(html_en:\"foo bar\")^5 (title_en:\"foo bar\")^10',
							 $method->invoke( $wikiaSearch, $searchConfig ),
					        'WikiaSearch::getBoostQueryString should strip quotes from original query'
							);

		$searchConfig	->setQuery		('foo bar wiki')
						->setIsInterWiki(true)
		;
		$this->assertEquals( '(html_en:\"foo bar\")^5 (title_en:\"foo bar\")^10 (wikititle_en:\"foo bar\")^15 -(host:answers)^10 -(host:respuestas)^10',
					        $method->invoke( $wikiaSearch, $searchConfig ),
					        'WikiaSearch::getBoostQueryString should remove "wiki" from searches,, include wikititle, and remove answers wikis'
							);
	}

	/**
	 * @covers WikiaSearch::sanitizeQuery
	 */
	public function testSanitizeQuery() {
		$this->mockApp();
		$this->mockClass( 'Solarium_Client', $this->getMock( 'Solarium_Client', array('setAdapter') ) );

		$wikiaSearch	= F::build( 'WikiaSearch' );

		$method = new ReflectionMethod( 'WikiaSearch', 'sanitizeQuery' );
		$method->setAccessible( true );

		$this->assertEquals( '123 foo', $method->invoke( $wikiaSearch, '123foo' ),
							 'WikiaSearch::sanitizeQuery should split numbers and letters.'
							);

		$this->assertEquals( '\\+\\-\\&&\\||\\!\\(\\)\\{\\}\\[\\]\\^\\"\\~\\*\\?\\:\\\\',
							$method->invoke( $wikiaSearch, '+-&&||!(){}[]^"~*?:\\' ),
							'WikiaSearch::sanitizeQuery should escape lucene special characters.'
							);

		$this->assertEquals( '\"fame & glory\"',
							$method->invoke( $wikiaSearch, '&quot;fame &amp; glory&quot;' ),
							'WikiaSearch::sanitizeQuery shoudl decode HTML entities and escape any entities that are also Lucene special characters.'
							);
	}

	/**
	 * @covers WikiaSearch::getQueryClausesString
	 * @covers WikiaSearch::getInterWikiSearchExcludedWikis
	 */
	public function testGetQueryClausesString() {
		$expectedLanguageCode	= 'en';
		$mockContLang 			= new stdClass();
		$mockContLang->mCode	= $expectedLanguageCode;
		$mockPrivateWiki		= new stdClass();
		$mockPrivateWiki->cv_id	= 0;
		$mockCityId				= 123;

		$memcacheMock = $this->getMock( 'stdClass', array( 'get', 'set' ) );
		$memcacheMock
			->expects	( $this->any() )
			->method	( 'get' )
			->will		( $this->returnValue( null ) )
		;
		$memcacheMock
			->expects	( $this->any() )
			->method	( 'set' )
			->will		( $this->returnValue( null ) )
		;

		$wikiFactoryMock = $this->getMock( 'WikiFactory', array('getCityIDsFromVarValue', 'getVarByName' ) );
		$wikiFactoryMock
			->expects	( $this->any() )
			->method	( 'getCityIDsFromVarValue' )
			->will		( $this->returnValue( null ) )
		;
		$wikiFactoryMock
			->expects	( $this->any() )
			->method	( 'getVarByName' )
			->will		( $this->returnValue( $mockPrivateWiki ) )
		;

		$this->mockGlobalVariable	( 'wgContLang',							$mockContLang );
		$this->mockGlobalVariable	( 'wgIsPrivateWiki',					false );
		$this->mockGlobalVariable	( 'wgCrossWikiaSearchExcludedWikis',	array( 123, 234 ) );
		$this->mockGlobalVariable	( 'wgCityId',							$mockCityId );
		$this->mockGlobalVariable	( 'wgMemc',								$memcacheMock );
		$this->mockClass			( 'Solarium_Client',					$this->getMock( 'Solarium_Client', array('setAdapter') ) );
		$this->mockClass			( 'WikiFactory',						$wikiFactoryMock );
		$this->mockApp();


		$wikiaSearch	= F::build( 'WikiaSearch' );
		$searchConfig	= F::build( 'WikiaSearchConfig' );
		$searchConfig->setCityId( $mockCityId ); // some wonkiness with mediawikiinterface

		$method = new ReflectionMethod( 'WikiaSearch', 'getQueryClausesString' );
		$method->setAccessible( true );

		$searchConfig->setNamespaces( array(1, 2, 3) );

		$this->assertEquals(
				'((wid:123) AND ((ns:1) OR (ns:2) OR (ns:3)))',
				$method->invoke( $wikiaSearch, $searchConfig ),
				'WikiaSearch::getQueryClauses by default should query for namespaces and wiki ID.'
		);

		$searchConfig->setVideoSearch( true );

		$expectedWithVideo = '(((wid:123) OR (wid:'.WikiaSearch::VIDEO_WIKI_ID.')) AND (is_video:true) AND ((ns:'.NS_FILE.')))';
		$this->assertEquals(
				$expectedWithVideo,
				$method->invoke( $wikiaSearch, $searchConfig ),
				'WikiaSearch::getQueryClauses should search only for video namespaces in video search, and should only search for videos'
		);

		$searchConfig	->setVideoSearch	( false )
						->setIsInterWiki	( true );

		$this->assertEquals(
				'(-(wid:123) AND -(wid:234) AND (lang:en) AND (iscontent:true))',
				$method->invoke( $wikiaSearch, $searchConfig ),
        		'WikiaSearch::getQueryClauses should exclude bad wikis, require the language of the wiki, and require content'
		);

		$searchConfig->setHub( 'Entertainment' );

		$this->assertEquals(
				'(-(wid:123) AND -(wid:234) AND (lang:en) AND (iscontent:true) AND (hub:Entertainment))',
				$method->invoke( $wikiaSearch, $searchConfig ),
				'WikiaSearch::getQueryClauses by default should query for namespaces and wiki ID.'
		);

	}

	/**
	 * @covers WikiaSearch::getArticleMatch
	 */
	public function testGetArticleMatchHasMatch() {

		$wikiaSearch		= F::build( 'WikiaSearch' );
		$mockSearchConfig	= $this->getMock( 'WikiaSearchConfig', array( 'getOriginalQuery', 'hasArticleMatch', 'getArticleMatch' ) );
		$mockTitle			= $this->getMock( 'Title', array( 'getNamespace' ) );
		$mockArticle		= $this->getMock( 'Article', array(), array( $mockTitle ) );
		$mockArticleMatch	= $this->getMock( 'WikiaSearchArticleMatch', array(), array( $mockArticle ) );
		$mockTerm			= 'foo';

		// If there's already an article match set in the search config, return that
		$mockSearchConfig
			->expects	( $this->any() )
			->method	( 'getOriginalQuery' )
			->will		( $this->returnValue( $mockTerm ) )
		;
		$mockSearchConfig
			->expects	( $this->any() )
			->method	( 'hasArticleMatch' )
			->will		( $this->returnValue( true ) )
		;
		$mockSearchConfig
			->expects	( $this->any() )
			->method	( 'getArticleMatch' )
			->will		( $this->returnValue( $mockArticleMatch ) )
		;
		$this->assertInstanceOf( 'WikiaSearchArticleMatch', $wikiaSearch->getArticleMatch( $mockSearchConfig ),
								'A searchconfig with an article match should return its article match during WikiaSearch::getArticleMatch()' );
	}

	/**
	 * @covers WikiaSearch::getArticleMatch
	 */
	public function testGetArticleMatchWithNoMatch() {
		$wikiaSearch		= F::build( 'WikiaSearch' );
		$mockSearchConfig	= $this->getMock( 'WikiaSearchConfig', array( 'getOriginalQuery', 'hasArticleMatch', 'getArticleMatch' ) );
		$mockTitle			= $this->getMock( 'Title', array( 'getNamespace' ) );
		$mockArticle		= $this->getMock( 'Article', array(), array( $mockTitle ) );
		$mockArticleMatch	= $this->getMock( 'WikiaSearchArticleMatch', array(), array( $mockArticle ) );
		$mockSearchEngine	= $this->getMock( 'stdClass', array( 'getNearMatch' ) );
		$mockTerm			= 'foo';

		$mockSearchConfig
			->expects	( $this->any() )
			->method	( 'getOriginalQuery' )
			->will		( $this->returnValue( $mockTerm ) )
		;
		$mockSearchConfig
			->expects	( $this->any() )
			->method	( 'hasArticleMatch' )
			->will		( $this->returnValue( false ) )
		;
		$mockSearchConfig
			->expects	( $this->any() )
			->method	( 'getArticleMatch' )
			->will		( $this->returnValue( null ) )
		;
		$mockSearchEngine
			->expects	( $this->any() )
			->method	( 'getNearMatch' )
			->with		( $mockTerm )
			->will		( $this->returnValue( null ) )
		;

		$this->mockClass( 'Title',				$mockTitle );
		$this->mockClass( 'Article',			$mockArticle );
		$this->mockClass( 'ArticleMatch',		$mockArticleMatch );
		$this->mockClass( 'SearchEngine',		$mockSearchEngine );

		$this->assertNull( $wikiaSearch->getArticleMatch( $mockSearchConfig ),
		        			'A query term that does not produce a near title match should return null from WikiaSearch::getArticleMatch' );
	}

	/**
	 * @covers WikiaSearch::getArticleMatch
	 */
	public function testGetArticleMatchWithMatchFirstCall() {
		$wikiaSearch		= F::build( 'WikiaSearch' );
		$mockSearchConfig	= $this->getMock( 'WikiaSearchConfig', array( 'getArticleMatch', 'setArticleMatch', 'getNamespaces', 'getOriginalQuery' ) );
		$mockTitle			= $this->getMock( 'Title', array( 'getNamespace' ) );
		$mockArticle		= $this->getMock( 'Article', array(), array( $mockTitle ) );
		$mockArticleMatch	= $this->getMock( 'WikiaSearchArticleMatch', array(), array( $mockArticle ) );
		$mockSearchEngine	= $this->getMock( 'stdClass', array( 'getNearMatch' ) );
		$mockTerm			= 'foo';

		$mockSearchEngine
			->expects	( $this->any() )
			->method	( 'getNearMatch' )
			->with		( $mockTerm )
			->will		( $this->returnValue( $mockTitle ) )
		;
		$mockTitle
			->expects	( $this->any() )
			->method	( 'getNamespace' )
			->will		( $this->returnValue( 1 ) )
		;
		$mockSearchConfig
			->expects	( $this->any() )
			->method	( 'getOriginalQuery' )
			->will		( $this->returnValue( $mockTerm ) )
		;
		$mockSearchConfig
			->expects	( $this->any() )
			->method	( 'setArticleMatch' )
			->will		( $this->returnValue( $mockSearchConfig ) )
		;
		$mockSearchConfig
			->expects	( $this->any() )
			->method	( 'getNamespaces' )
			->will		( $this->returnValue( array( 1 ) ) )
		;
		$mockArticle
			->expects	( $this->any() )
			->method	( 'newFromTitle' )
			->will		( $this->returnValue( $mockArticle ) )
		;

		$this->mockClass( 'Title',				$mockTitle );
		$this->mockClass( 'Article',			$mockArticle );
		$this->mockClass( 'ArticleMatch',		$mockArticleMatch );
		$this->mockClass( 'SearchEngine',		$mockSearchEngine );
		$this->mockApp();
		F::setInstance( 'Article', $mockArticle );

		$this->assertInstanceOf( 'WikiaSearchArticleMatch', $wikiaSearch->getArticleMatch( $mockSearchConfig ),
		        				'A query term that is a near title match should result in the creation, storage, and return of an instance of WikiaArticleMatch' );

	}

	/**
	 * @covers WikiaSearch::getArticleMatch
	 */
	public function testGetArticleMatchWithMatchFirstCallMismatchedNamespace() {
	    $wikiaSearch		= F::build( 'WikiaSearch' );
	    $mockSearchConfig	= $this->getMock( 'WikiaSearchConfig', array( 'getOriginalQuery', 'getNamespaces', 'hasArticleMatch' ) );
		$mockTitle			= $this->getMock( 'Title', array( 'getNamespace' ) );
		$mockArticle		= $this->getMock( 'Article', array(), array( $mockTitle ) );
		$mockArticleMatch	= $this->getMock( 'WikiaSearchArticleMatch', array(), array( $mockArticle ) );
	    $mockSearchEngine	= $this->getMock( 'stdClass', array( 'getNearMatch' ) );
	    $mockTerm			= 'foo';

	    $mockSearchEngine
		    ->expects	( $this->any() )
		    ->method	( 'getNearMatch' )
		    ->with		( $mockTerm )
		    ->will		( $this->returnValue( $mockTitle ) )
	    ;
	    $mockTitle
		    ->expects	( $this->any() )
		    ->method	( 'getNamespace' )
		    ->will		( $this->returnValue( 1 ) )
	    ;
	    $mockSearchConfig
	    	->expects	( $this->any() )
	    	->method	( 'hasArticleMatch' )
	    	->will		( $this->returnValue( false ) )
    	;
	    $mockSearchConfig
		    ->expects	( $this->any() )
		    ->method	( 'getOriginalQuery' )
		    ->will		( $this->returnValue( $mockTerm ) )
	    ;
	    $mockSearchConfig
		    ->expects	( $this->any() )
		    ->method	( 'getNamespaces' )
		    ->will		( $this->returnValue( array( 0 ) ) )
	    ;

	    $this->mockClass( 'Title',				$mockTitle );
	    $this->mockClass( 'Article',			$mockArticle );
	    $this->mockClass( 'ArticleMatch',		$mockArticleMatch );
	    $this->mockClass( 'SearchEngine',		$mockSearchEngine );

	    $this->assertNull( $wikiaSearch->getArticleMatch( $mockSearchConfig ),
	            			'A query term that is a near title match should still return null if it is not in the searched-for namespaces' );

	}

	/**
	 * @covers WikiaSearch::getSelectQuery
	 */
	public function testGetSelectQuery() {
		$expectedMethods = array(
				'registerQueryParams', 'registerHighlighting', 
				'registerFilterQueries', 'registerGrouping', 
				'registerSpellcheck', 'getQueryClausesString',
				'getNestedQuery'
				);
		$mockClient = $this->getMock( 'Solarium_Client', array( 'setAdapter', 'createSelect' ) );
		$mockSearch = $this->getMockBuilder( 'WikiaSearch' )
		                   ->setConstructorArgs( array( $mockClient ) )
		                   ->setMethods( $expectedMethods )
		                   ->getMock();
		
		$mockQuery = $this->getMockBuilder( 'Solarium_Query_Select' )
		                  ->disableOriginalConstructor()
		                  ->setMethods( array( 'setDocumentClass', 'setQuery' ) )
		                  ->getMock();
		
		$getSelectQuery = new ReflectionMethod( 'WikiaSearch', 'getSelectQuery' );
		$getSelectQuery->setAccessible( true );
		
		$mockSearchConfig = $this->getMock( 'WikiaSearchConfig' );
		
		$mockQueryClausesString = 'foo:bar';
		$mockNestedQuery = '{!baz qux}';
		
		$mockClient
		    ->expects( $this->at( 0 ) )
		    ->method ( 'createSelect' )
		    ->will   ( $this->returNValue( $mockQuery ) )
		;
		$mockQuery
		    ->expects( $this->at( 0 ) )
		    ->method ( 'setDocumentClass' )
		    ->with   ( 'WikiaSearchResult' )
		;
		$mockSearch
		    ->expects( $this->at( 0 ) )
		    ->method ( 'registerQueryParams' )
		    ->with   ( $mockQuery, $mockSearchConfig )
		    ->will   ( $this->returnValue( $mockSearch ) )
		;
		$mockSearch
		    ->expects( $this->at( 1 ) )
		    ->method ( 'registerHighlighting' )
		    ->with   ( $mockQuery, $mockSearchConfig )
		    ->will   ( $this->returnValue( $mockSearch ) )
		;
		$mockSearch
		    ->expects( $this->at( 2 ) )
		    ->method ( 'registerFilterQueries' )
		    ->with   ( $mockQuery, $mockSearchConfig )
		    ->will   ( $this->returnValue( $mockSearch ) )
		;
		$mockSearch
		    ->expects( $this->at( 3 ) )
		    ->method ( 'registerGrouping' )
		    ->with   ( $mockQuery, $mockSearchConfig )
		    ->will   ( $this->returnValue( $mockSearch ) )
		;
		$mockSearch
		    ->expects( $this->at( 4 ) )
		    ->method ( 'registerSpellcheck' )
		    ->with   ( $mockQuery, $mockSearchConfig )
		    ->will   ( $this->returnValue( $mockSearch ) )
		;
		$mockSearch
		    ->expects( $this->once() )
		    ->method ( 'getNestedQuery' )
		    ->with   ( $mockSearchConfig )
		    ->will   ( $this->returnValue( $mockNestedQuery ) )
		;
		$mockSearch
		    ->expects( $this->once() )
		    ->method ( 'getQueryClausesString' )
		    ->with   ( $mockSearchConfig )
		    ->will   ( $this->returnValue( $mockQueryClausesString ) )
		;
		$mockQuery
		    ->expects( $this->once() )
		    ->method ( 'setQuery' )
		    ->with   ( sprintf('%s AND (%s)', $mockQueryClausesString, $mockNestedQuery ) )
		;
	    $this->assertEquals(
	    		$mockQuery,
	    		$getSelectQuery->invoke( $mockSearch, $mockSearchConfig )
		);
	}
	
	/**
	 * @covers WikiaSearch::registerQueryParams
	 */
	public function testRegisterQueryparams() {
		
		$mockSearch = $this->getMockBuilder( 'WikiaSearch' )
		                   ->disableOriginalConstructor()
		                   ->setMethods( null )
		                   ->getMock();
		
		$mockQuery = $this->getMockBuilder( 'Solarium_Query_Select' )
		                  ->disableOriginalConstructor()
		                  ->setMethods( array( 'addFields', 'removeField', 'setStart', 'setRows', 'addSort', 'addParam' ) )
		                  ->getMock();
		
		$registerQueryParams = new ReflectionMethod( 'WikiaSearch', 'registerQueryParams' );
		$registerQueryParams->setAccessible( true );
		
		$mockSearchConfig = $this->getMock( 'WikiaSearchConfig', array( 'getSort', 'getRequestedFields', 'getStart', 'getLength', 'isInterWiki' ) );
		
		$reqFields = array( 'field one', 'field two' );
		$start = 0;
		$length = 10;
		$sort = array( 'whatever', 'asc' );
		
		$mockSearchConfig
		    ->expects( $this->once() )
		    ->method ( 'getSort' )
		    ->will   ( $this->returnValue( $sort ) )
		;
		$mockSearchConfig
		    ->expects( $this->once() )
		    ->method ( 'getRequestedFields' )
		    ->will   ( $this->returnValue( $reqFields ) )
		;
		$mockQuery
		    ->expects( $this->once() )
		    ->method ( 'addFields' )
		    ->with   ( $reqFields )
		    ->will   ( $this->returnValue( $mockQuery ) )
		;
		$mockQuery
		    ->expects( $this->once() )
		    ->method ( 'removeField' )
		    ->with   ( '*' )
		    ->will   ( $this->returnValue( $mockQuery ) )
		;
		$mockSearchConfig
		    ->expects( $this->once() )
		    ->method ( 'getStart' )
		    ->will   ( $this->returnValue( $start ) )
		;
		$mockQuery
		    ->expects( $this->once() )
		    ->method ( 'setStart' )
		    ->with   ( $start )
		    ->will   ( $this->returnValue( $mockQuery ) )
		;
		$mockSearchConfig
		    ->expects( $this->once() )
		    ->method ( 'getLength' )
		    ->will   ( $this->returnValue( $length ) )
		;
		$mockQuery
		    ->expects( $this->once() )
		    ->method ( 'setRows' )
		    ->with   ( $length )
		    ->will   ( $this->returnValue( $mockQuery ) )
		;
		$mockQuery
		    ->expects( $this->once() )
		    ->method ( 'addSort' )
		    ->with   ( $sort[0], $sort[1] )
		    ->will   ( $this->ReturnValue( $mockQuery ) )
		;
		$mockSearchConfig
		    ->expects( $this->once() )
		    ->method ( 'isInterWiki' )
		    ->will   ( $this->returnValue( false) )
		;
		$mockQuery
		    ->expects( $this->once() )
		    ->method ( 'addParam' )
		    ->with   ( 'timeAllowed', 5000 )
		    ->will   ( $this->returnValue( $mockQuery ) )
		;
		$this->assertEquals(
				$mockSearch,
				$registerQueryParams->invoke( $mockSearch, $mockQuery, $mockSearchConfig )
		);
	}
	
	/**
	 * @covers WikiaSearch::registerGrouping
	 */
	public function testRegisterGroupingInterWiki() {
		$mockSearch = $this->getMockBuilder( 'WikiaSearch' )
		                   ->disableOriginalConstructor()
		                   ->setMethods( null )
		                   ->getMock();
		
		$mockQuery = $this->getMockBuilder( 'Solarium_Query_Select' )
		                  ->disableOriginalConstructor()
		                  ->setMethods( array( 'getGrouping' ) )
		                  ->getMock();
		
		$mockGrouping = $this->getMockBuilder( 'Solarium_Query_Select_Component_Grouping' )
		                     ->disableOriginalConstructor()
		                     ->setMethods( array( 'setLimit', 'setOffset', 'setFields' ) )
		                     ->getMock();
		
		$registerGrouping = new ReflectionMethod( 'WikiaSearch', 'registerGrouping' );
		$registerGrouping->setAccessible( true );
		
		$mockSearchConfig = $this->getMock( 'WikiaSearchConfig', array( 'getStart', 'isInterWiki' ) );
		
		$start = 0;

		$mockSearchConfig
		    ->expects( $this->once() )
		    ->method ( 'isInterWiki' )
		    ->will   ( $this->returnValue( true ) )
		;
		$mockQuery
		    ->expects( $this->once() )
		    ->method ( 'getGrouping' )
		    ->will   ( $this->returnValue( $mockGrouping ) )
		;
		$mockGrouping
		    ->expects( $this->once() )
		    ->method ( 'setLimit' )
		    ->with   ( WikiaSearch::GROUP_RESULTS_GROUPING_ROW_LIMIT )
		    ->will   ( $this->returnValue( $mockGrouping ) )
		;
		$mockSearchConfig
		    ->expects( $this->once() )
		    ->method ( 'getStart' )
		    ->will   ( $this->returnValue( $start ) )
		;
		$mockGrouping
		    ->expects( $this->once() )
		    ->method ( 'setOffset' )
		    ->with   ( $start )
		    ->will   ( $this->returnValue( $mockGrouping ) )
		;
		$mockGrouping
		    ->expects( $this->once() )
		    ->method ( 'setFields' )
		    ->with   ( array( WikiaSearch::GROUP_RESULTS_GROUPING_FIELD ) )
		;
		$this->assertEquals(
				$mockSearch,
				$registerGrouping->invoke( $mockSearch, $mockQuery, $mockSearchConfig )
		);
	}
	
	/**
	 * @covers WikiaSearch::registerGrouping
	 */
	public function testRegisterGroupingNonInterWiki() {
		$mockSearch = $this->getMockBuilder( 'WikiaSearch' )
		                   ->disableOriginalConstructor()
		                   ->setMethods( null )
		                   ->getMock();
		
		$mockQuery = $this->getMockBuilder( 'Solarium_Query_Select' )
		                  ->disableOriginalConstructor()
		                  ->setMethods( array( 'getGrouping' ) )
		                  ->getMock();
		
		$mockGrouping = $this->getMockBuilder( 'Solarium_Query_Select_Component_Grouping' )
		                     ->disableOriginalConstructor()
		                     ->setMethods( array( 'setLimit', 'setOffset', 'setFields' ) )
		                     ->getMock();
		
		$registerGrouping = new ReflectionMethod( 'WikiaSearch', 'registerGrouping' );
		$registerGrouping->setAccessible( true );
		
		$mockSearchConfig = $this->getMock( 'WikiaSearchConfig', array( 'getStart', 'isInterWiki' ) );
		
		$start = 0;
		
		$mockSearchConfig
		    ->expects( $this->once() )
		    ->method ( 'isInterWiki' )
		    ->will   ( $this->returnValue( false ) )
		;
		$mockQuery
		    ->expects( $this->never() )
		    ->method ( 'getGrouping' )
		;
		$this->assertEquals(
				$mockSearch,
				$registerGrouping->invoke( $mockSearch, $mockQuery, $mockSearchConfig )
		);
	}
	
	/**
	 * @covers WikiaSearch::registerFilterQueries
	 */
	public function testRegisterFilterQueriesWithArticleMatch() {
		$mockSearch = $this->getMockBuilder( 'WikiaSearch' )
		                   ->disableOriginalConstructor()
		                   ->setMethods( array( 'getFilterQueryString' ) )
		                   ->getMock();
		
		$mockQuery = $this->getMockBuilder( 'Solarium_Query_Select' )
		                  ->disableOriginalConstructor()
		                  ->setMethods( array( 'addFilterQueries' ) )
		                  ->getMock();
		
		$mockArticleMatch = $this->getMockBuilder( 'WikiaSearchArticleMatch' )
		                         ->disableOriginalConstructor()
		                         ->setMethods( array( 'getArticle' ) )
		                         ->getMock();
		
		$mockArticle = $this->getMockBuilder( 'Article' )
		                    ->setMethods( array( 'getID' ) )
		                    ->disableOriginalConstructor()
		                    ->getMock();
		
		$mockSearchConfig = $this->getMock( 'WikiaSearchConfig', array( 'hasArticleMatch', 'getArticleMatch', 'setFilterQuery', 'getCityId', 'getFilterQueries' ) );
		
		$registerFilterQueries = new ReflectionMethod( 'WikiaSearch', 'registerFilterQueries' );
		$registerFilterQueries->setAccessible( true );
		
		$filterQueryString = 'filterquery';
		$articleId = '321';
		$cityId = '123';
		$noPtt = WikiaSearch::valueForField( 'id', sprintf( '%s_%s', $cityId, $articleId ), array( 'negate' => true ) ) ;
		$filterQueries = array( 'fq1' => $filterQueryString, 'ptt' => $noPtt );
		
		$mockSearch
		    ->expects( $this->once() )
		    ->method ( 'getFilterQueryString' )
		    ->with   ( $mockSearchConfig )
		    ->will   ( $this->returnValue( $filterQueryString ) )
		;
		$mockSearchConfig
		    ->expects( $this->at( 0 ) )
		    ->method ( 'setFilterQuery' )
		    ->with   ( $filterQueryString )
		;
		$mockSearchConfig
		    ->expects( $this->at( 1 ) )
		    ->method ( 'hasArticleMatch' )
		    ->will   ( $this->returnValue( true ) )
		;
		$mockSearchConfig
		    ->expects( $this->at( 2 ) )
		    ->method ( 'getArticleMatch' )
		    ->will   ( $this->returnValue( $mockArticleMatch ) )
		;
		$mockArticleMatch
		    ->expects( $this->once() )
		    ->method ( 'getArticle' )
		    ->will   ( $this->returnValue( $mockArticle ) )
		;
		$mockArticle
		    ->expects( $this->once() )
		    ->method ( 'getID' )
		    ->will   ( $this->returnValue( $articleId ) )
		;
		$mockSearchConfig
		    ->expects( $this->at( 3 ) )
		    ->method ( 'getCityId' )
		    ->will   ( $this->returnValue( $cityId ) )
		;
		$mockSearchConfig
		    ->expects( $this->at( 4 )  )
		    ->method ( 'setFilterQuery' )
		    ->will   ( $this->returnValue( $noPtt, 'ptt' ) )
		;
		$mockSearchConfig
		    ->expects( $this->once() )
		    ->method ( 'getFilterQueries' )
		    ->will   ( $this->returnValue( $filterQueries ) )
		;
		$mockQuery
		    ->expects( $this->once() )
		    ->method ( 'addFilterQueries' )
		    ->with   ( $filterQueries )
		;
		$this->assertEquals(
				$mockSearch,
				$registerFilterQueries->invoke( $mockSearch, $mockQuery, $mockSearchConfig )
		);
	}
	
    /**
	 * @covers WikiaSearch::registerFilterQueries
	 */
	public function testRegisterFilterQueriesWithWikiMatch() {
		$mockSearch = $this->getMockBuilder( 'WikiaSearch' )
		                   ->disableOriginalConstructor()
		                   ->setMethods( array( 'getFilterQueryString' ) )
		                   ->getMock();
		
		$mockQuery = $this->getMockBuilder( 'Solarium_Query_Select' )
		                  ->disableOriginalConstructor()
		                  ->setMethods( array( 'addFilterQueries' ) )
		                  ->getMock();
		
		$mockWikiMatch = $this->getMockBuilder( 'WikiaSearchWikiMatch' )
		                      ->disableOriginalConstructor()
		                      ->setMethods( array( 'getId' ) )
		                      ->getMock();
		
		$mockSearchConfig = $this->getMock( 'WikiaSearchConfig', array( 'setFilterQuery', 'addFilterQueries', 'hasArticleMatch', 'hasWikiMatch', 'getFilterQueries', 'getWikiMatch' ) );
		
		$registerFilterQueries = new ReflectionMethod( 'WikiaSearch', 'registerFilterQueries' );
		$registerFilterQueries->setAccessible( true );
		
		$filterQueryString = 'filterquery';
		$cityId = '123';
		$noPtt = WikiaSearch::valueForField( 'wid', $cityId, array( 'negate' => true ) ) ;
		$filterQueries = array( 'fq1' => $filterQueryString, 'wikiptt' => $noPtt );
		
		$mockSearch
		    ->expects( $this->once() )
		    ->method ( 'getFilterQueryString' )
		    ->with   ( $mockSearchConfig )
		    ->will   ( $this->returnValue( $filterQueryString ) )
		;
		$mockSearchConfig
		    ->expects( $this->at( 0 ) )
		    ->method ( 'setFilterQuery' )
		    ->with   ( $filterQueryString )
		;
		$mockSearchConfig
		    ->expects( $this->at( 1 ) )
		    ->method ( 'hasArticleMatch' )
		    ->will   ( $this->returnValue( false ) )
		;
		$mockSearchConfig
		    ->expects( $this->at( 2 ) )
		    ->method ( 'hasWikiMatch' )
		    ->will   ( $this->returnValue( true ) )
		;
		$mockSearchConfig
		    ->expects( $this->at( 3 ) )
		    ->method ( 'getWikiMatch' )
		    ->will   ( $this->returnValue( $mockWikiMatch ) )
		;
		$mockWikiMatch
		    ->expects( $this->at( 0 ) )
		    ->method ( 'getId' )
		    ->will   ( $this->returnValue( $cityId ) )
		;
		$mockSearchConfig
		    ->expects( $this->at( 4 )  )
		    ->method ( 'setFilterQuery' )
		    ->will   ( $this->returnValue( $noPtt, 'wikiptt' ) )
		;
		$mockSearchConfig
		    ->expects( $this->once() )
		    ->method ( 'getFilterQueries' )
		    ->will   ( $this->returnValue( $filterQueries ) )
		;
		$mockQuery
		    ->expects( $this->once() )
		    ->method ( 'addFilterQueries' )
		    ->with   ( $filterQueries )
		;
		$this->assertEquals(
				$mockSearch,
				$registerFilterQueries->invoke( $mockSearch, $mockQuery, $mockSearchConfig )
		);
	}

	/**
	 * @covers WikiaSearch::getNestedQuery
	 */
	public function testGetNestedQuery() {

		$this->mockGlobalVariable( 'wgSharedExternalDB', 'whatever' );
		$this->mockApp();

		$mockClient			=	$this->getMock( 'Solarium_Client' );
		$wikiaSearch		=	F::build( 'WikiaSearch', array( $mockClient ) );
		$searchConfig		=	F::build( 'WikiaSearchConfig' ); /** @var WikiaSearchConfig $searchConfig **/
		$method				=	new ReflectionMethod( 'WikiaSearch', 'getNestedQuery' );

		$searchConfig->setQuery( 'foo' );
		$method->setAccessible( true );

		$nestedQuery = $method->invoke( $wikiaSearch, $searchConfig ); /** @var Solarium_Query_Select $nestedQuery **/

		$this->assertInstanceOf(
				'Solarium_Query_Select',
				$nestedQuery,
				'WikiaSearch::getNestedQuery should return an instance of Solarium_Query_Select.'
		);
		$this->assertEquals(
				$searchConfig->getMinimumMatch(),
				$nestedQuery->getDismax()->getMinimumMatch(),
				'WikiaSearch::getNestedQuery should set the query\'s MM value based on search config.'
		);
		$this->assertEquals(
				'edismax',
				$nestedQuery->getDismax()->getQueryParser(),
				'WikiaSearch::getNestedQuery should set the query\'s parser to extended dismax.'
		);
		$this->assertEquals(
		        3,
		        $nestedQuery->getDismax()->getPhraseSlop(),
		        'WikiaSearch::getNestedQuery should set the query\'s phrase slop to 3.'
		);
		$this->assertEquals(
		        0.01,
		        $nestedQuery->getDismax()->getTie(),
		        'WikiaSearch::getNestedQuery should set the query\'s tie value to 0.01.'
		);
		$this->assertAttributeEquals(
				explode( ' ', $nestedQuery->getDismax()->getBoostFunctions() ),
				'onWikiBoostFunctions',
				$wikiaSearch,
				'By default, WikiaSearch::getNestedQuery should set boost functions according to WikiaSearch::onWikiBoostFunctions.'
		);


		$bqMethod = new ReflectionMethod( 'WikiaSearch', 'getBoostQueryString' );
		$qfMethod = new ReflectionMethod( 'WikiaSearch', 'getQueryFieldsString' );
		$bqMethod->setAccessible( true );
		$qfMethod->setAccessible( true );

		$this->assertEquals(
				$bqMethod->invoke( $wikiaSearch, $searchConfig ),
				$nestedQuery->getDismax()->getBoostQuery(),
				'WikiaSearch::getNestedQuery should have a boostquery set by WikiaSearch::getBoostQueryString.'
		);
		$this->assertEquals(
		        $qfMethod->invoke( $wikiaSearch, $searchConfig ),
		        $nestedQuery->getDismax()->getQueryFields(),
		        'WikiaSearch::getNestedQuery should have query fields set by WikiaSearch::getQueryFieldsString.'
		);
		$this->assertEquals(
		        $qfMethod->invoke( $wikiaSearch, $searchConfig ),
		        $nestedQuery->getDismax()->getPhraseFields(),
		        'WikiaSearch::getNestedQuery should have phrase fields set by WikiaSearch::getQueryFieldsString.'
		);

		$searchConfig->setInterWiki( true );
		$nestedQueryIW = $method->invoke( $wikiaSearch, $searchConfig ); /** @var Solarium_Query_Select $nestedQueryIW **/
		$this->assertAttributeEquals(
		        explode( ' ', $nestedQueryIW->getDismax()->getBoostFunctions() ),
		        'interWikiBoostFunctions',
		        $wikiaSearch,
		        'WikiaSearch::getNestedQuery should set boost functions according to WikiaSearch::interWikiBoostFunctions when interWiki is set to true in WikiaSearchConfig.'
		);

		$searchConfig
			->setInterWiki			( false )
			->setSkipBoostFunctions	( true )
		;
		$nestedQueryNBF = $method->invoke( $wikiaSearch, $searchConfig ); /** @var Solarium_Query_Select $nestedQueryNBF **/
		$this->assertEmpty(
				$nestedQueryNBF->getDismax()->getBoostFunctions(),
				'WikiaSearch::getNestedQuery should not have boost functions set if WikiaSearchConfig has had skipBoostFunctions set to true.'
		);
	}
	
	/**
	 * @covers WikiaSearch::registerHighlighting
	 */
	public function testRegisterHighlighting() {
		$mockSearch = $this->getMockBuilder( 'WikiaSearch' )
		                   ->disableOriginalConstructor()
		                   ->setMethods( null )
		                   ->getMock();
		
		$hlMethods = array( 
				'addField', 'setSnippets', 'setRequireFieldMatch', 
				'setFragSize', 'setSimplePrefix', 'setSimplePostfix', 
				'setAlternateField', 'setMaxAlternateFieldLength' 
				);
		
		$mockQuery = $this->getMockBuilder( 'Solarium_Query_Select' )
		                  ->disableOriginalConstructor()
		                  ->setMethods( array( 'getHighlighting' ) )
		                  ->getMock();
		
		$mockHl = $this->getMockBuilder( 'Solarium_Query_Select_Component_Highlighting' )
		               ->disableOriginalConstructor()
		               ->setMethods( $hlMethods )
		               ->getMock();
		
		$mockSearchConfig = $this->getMock( 'WikiaSearchConfig' );
		
		$registerHighlighting = new ReflectionMethod( 'WikiaSearch', 'registerHighlighting' );
		$registerHighlighting->setAccessible( true );
		
		$mockQuery
		    ->expects( $this->once() )
		    ->method ( 'getHighlighting' )
		    ->will   ( $this->returnValue( $mockHl ) )
		;
		$mockHl
		    ->expects( $this->once() )
		    ->method ( 'addField' )
		    ->with   ( WikiaSearch::field( 'html' ) )
		    ->will   ( $this->returnValue( $mockHl ) )
		;
		$mockHl
		    ->expects( $this->once() )
		    ->method ( 'setSnippets' )
		    ->with   ( 1 )
		    ->will   ( $this->returnValue( $mockHl ) )
		;
		$mockHl
		    ->expects( $this->once() )
		    ->method ( 'setRequireFieldMatch' )
		    ->with   ( true )
		    ->will   ( $this->returnValue( $mockHl ) )
		;
		$mockHl
		    ->expects( $this->once() )
		    ->method ( 'setFragSize' )
		    ->with   ( WikiaSearch::HL_FRAG_SIZE )
		    ->will   ( $this->returnValue( $mockHl ) )
		;
		$mockHl
		    ->expects( $this->once() )
		    ->method ( 'setSimplePrefix' )
		    ->with   ( WikiaSearch::HL_MATCH_PREFIX )
		    ->will   ( $this->returnValue( $mockHl ) )
		;
		$mockHl
		    ->expects( $this->once() )
		    ->method ( 'setSimplePostfix' )
		    ->with   ( WikiaSearch::HL_MATCH_POSTFIX )
		    ->will   ( $this->returnValue( $mockHl ) )
		;
		$mockHl
		    ->expects( $this->once() )
		    ->method ( 'setAlternateField' )
		    ->with   ( 'nolang_txt' )
		    ->will   ( $this->returnValue( $mockHl ) )
		;
		$mockHl
		    ->expects( $this->once() )
		    ->method ( 'setMaxAlternateFieldLength' )
		    ->with   ( 100 )
		    ->will   ( $this->returnValue( $mockHl ) )
		;
		$this->assertEquals(
				$mockSearch,
				$registerHighlighting->invoke( $mockSearch, $mockQuery, $mockSearchConfig )
		);
	}

	/**
	 * @covers WikiaSearch::getQueryFieldsString
	 */
	public function testGetQueryFieldsString() {

		$this->mockGlobalVariable( 'wgLanguageCode', 'en' );
		$this->mockApp();

		$mockClient			=	$this->getMock( 'Solarium_Client' );
		$wikiaSearch		=	F::build( 'WikiaSearch', array( $mockClient ) );
		$searchConfig		=	F::build( 'WikiaSearchConfig' ); /** @var WikiaSearchConfig $searchConfig  **/
		$method				=	new ReflectionMethod( 'WikiaSearch', 'getQueryFieldsString' );
		$defaultString		=	sprintf( '%s^5 %s^1.5 %s^4 %s^1 %s^7', WikiaSearch::field( 'title' ), WikiaSearch::field( 'html' ), WikiaSearch::field( 'redirect_titles' ), WikiaSearch::field( 'categories' ), WikiaSearch::field( 'nolang_txt' ) );
		$interwikiString	=	$defaultString . sprintf( ' %s^7', WikiaSearch::field( 'wikititle' ) );

		$method->setAccessible( true );
		$searchConfig->setQuery( 'foo' );

		$this->assertEquals(
				$defaultString,
				$method->invoke( $wikiaSearch, $searchConfig ),
				'WikiaSearch should query against the dynamic title, html, and redirect titles fields by default.'
		);

		$oldQueryFields = $searchConfig->getQueryFieldsToBoosts();
		
		$searchConfig->setInterWiki( true );
		$this->assertEquals(
				$interwikiString,
				$method->invoke( $wikiaSearch, $searchConfig ),
				'WikiaSearch should add wikititle as a query field if we are performing an interwiki search.'
		);
		$searchConfig
			->setIsInterWiki	( false )
			->setVideoSearch	( true )
			->setQueryFields	( $oldQueryFields )
		;
		$this->assertEquals(
		        $defaultString,
		        $method->invoke( $wikiaSearch, $searchConfig ),
		        'WikiaSearch should use the default query fields if the global language code is english.'
		);

		$this->mockGlobalVariable( 'wgLanguageCode', 'fr' );
		$this->mockApp();
		global $wgLanguageCode;
		$wgLanguageCode = 'fr';

		$frVideoString		=	sprintf( '%s^5 %s^1.5 %s^4 %s^1 %s^7 %s^5 %s^1.5 %s^4',
						        WikiaSearch::field( 'title', 'fr' ),
						        WikiaSearch::field( 'html', 'fr' ),
						        WikiaSearch::field( 'redirect_titles', 'fr' ),
								WikiaSearch::field( 'categories', 'fr' ),
								WikiaSearch::field( 'nolang_txt' ),
						        WikiaSearch::field( 'title', 'en' ),
						        WikiaSearch::field( 'html', 'en' ),
						        WikiaSearch::field( 'redirect_titles', 'en' )
		);

		$this->assertEquals(
		        $frVideoString,
		        $method->invoke( $wikiaSearch, $searchConfig ),
		        'WikiaSearch should append english query fields if the global language is not english and we\'re doing premium video search.'
		);
	}

	public function testMoreLikeThis() {
		$mockClient			=	$this->getMock( 'Solarium_Client', array( 'createMoreLikeThis', 'moreLikeThis' ) );
		$defaultMltMethods	=	array(
				'setMltFields',
				'setFields',
				'addParam',
				'setStart',
				'setRows',
				'setDocumentClass'
		);
		$addtlMltMethods	=	array(
				'setInterestingTerms',
				'addFilterQuery',
				'setQuery',
				'addParam',
				'setMinimumDocumentFrequency'
		);

		$mockMoreLikeThis	=	$this->getMock( 'Solarium_Query_MoreLikeThis', $defaultMltMethods + $addtlMltMethods );
		$mockResponse		=	$this->getMock( 'Solarium_Client_Response', array(), array( '', array() ) );
		$mockMltResult		=	$this->getMock( 'Solarium_Result_MoreLikeThis', array(), array( $mockClient, $mockMoreLikeThis, $mockResponse ) );
		$wikiaSearch		=	F::build( 'WikiaSearch', array( $mockClient ) );
		$searchConfig		=	F::build( 'WikiaSearchConfig' );
		$mockResultSet		=	$this->getMockBuilder( 'WikiaSearchResultSet' )
									->disableOriginalConstructor()
									->getMock();
		$method				=	new ReflectionMethod( 'WikiaSearch', 'moreLikeThis' );

		$method->setAccessible( true );

		$searchConfig->setMltFields( array( 'title', 'html' ) );

		$e = null;
		try {
			$method->invoke( $wikiaSearch, $searchConfig );
		} catch ( Exception $e ) {  }

		$this->assertNotNull( $e, 'WikiaSearch::moreLikeThis should throw an exception if a query, stream body, or stream url has not been set.' );

		$mockClient
			->expects	( $this->any() )
			->method	( 'createMoreLikeThis' )
			->will		( $this->returnValue( $mockMoreLikeThis ) )
		;

		foreach ($defaultMltMethods as $mltMethod ) {
			$mockMoreLikeThis
				->expects	( $this->any() )
				->method	( $mltMethod )
				->will		( $this->returnValue( $mockMoreLikeThis ) )
			;
		}

		$this->mockClass( 'Solarium_Query_MoreLikeThis',		$mockMoreLikeThis);
		$this->mockClass( 'WikiaSearchResultSet',				$mockResultSet );
		$this->mockClass( 'Solarium_Client_Response',			$mockResponse );
		$this->mockClass( 'Solarium_Result_MoreLikeThis',		$mockMltResult );
		$this->mockApp();
		F::setInstance( 'WikiaSearchResultSet', $mockResultSet );
		F::setInstance( 'Solarium_Client', $mockClient );
		F::addClassConstructor( 'WikiaSearch', array( 'client' => $mockClient ) );
		$wikiaSearch = F::build( 'WikiaSearch' );

		$searchConfig['query'] = false;

		$searchConfig
			->setStreamBody			( 'foo' )
			->setInterestingTerms	( 'list' )
		;

		$this->assertInstanceOf(
				'WikiaSearchResultSet',
				$method->invoke( $wikiaSearch, $searchConfig ),
				'WikiaSearch::moreLikeThis should return an instance of WikiaSearchResultSet'
		);

		$searchConfig
			->setStreamBody			( false )
			->setQuery				( 'foo' )
			->setInterestingTerms	( false )
		;

		$this->assertInstanceOf(
		        'WikiaSearchResultSet',
		        $method->invoke( $wikiaSearch, $searchConfig ),
		        'WikiaSearch::moreLikeThis should return an instance of WikiaSearchResultSet, even if the client throws an exception.'
		);

		$searchConfig
			->setStreamUrl		( 'http://foo.com' )
			->setFilterQuery	( 'foo:bar', 'mlt' )
		;

		$searchConfig['query'] = false;

		$this->assertInstanceOf(
		        'WikiaSearchResultSet',
		        $method->invoke( $wikiaSearch, $searchConfig ),
		        'WikiaSearch::moreLikeThis should return an instance of WikiaSearchResultSet, even if the client throws an exception.'
		);

		$searchConfig->setFilterQueries( array() );
		$searchConfig->setMindf( 20 );

		$exceptionMock = $this->getMock( 'Solarium_Exception', array() );

		$mockClient
			->expects	( $this->any() )
			->method	( 'moreLikeThis' )
			->will		( $this->throwException( $exceptionMock ) )
		;

		$mockWikia = $this->getMock( 'Wikia', array( 'log' ) );

		$mockWikia
			->staticExpects	( $this->any() )
			->method		( 'log' )
		;

		$this->mockClass( 'Wikia', $mockWikia );
		$this->mockApp();

		$this->assertInstanceOf(
		        'WikiaSearchResultSet',
		        $method->invoke( $wikiaSearch, $searchConfig ),
		        'WikiaSearch::moreLikeThis should return an instance of WikiaSearchResultSet, even if the client throws an exception.'
		);
	}

	/**
	 * @covers WikiaSearch::onGetPreferences
	 */
	public function testOnGetPreferences() {
		$mockUser		= $this->getMock( 'User' );
		$wikiaSearch	= F::build( 'WikiaSearch' );

		$defaultPreferences = array(
				'searchlimit' => array(),
				'contextlines' => array(),
				'contextchars' => array(),
				'disablesuggest' => array(),
				'searcheverything' => array(),
				'searchnamespaces' => array(),
				);

		$oldPrefs = $defaultPreferences;

		$this->assertTrue(
				$wikiaSearch->onGetPreferences( $mockUser, $defaultPreferences )
		);

		foreach ( $oldPrefs as $key => $whocares ) {
			$this->assertArrayNotHasKey(
					$key,
					$defaultPreferences
			);
		}
	}

	/**
	 * @covers WikiaSearch::getSimilarPages
	 */
	public function testGetSimilarPagesForStream() {
		$searchConfigMethods = array(
				'getQuery', 'getStreamUrl', 'getStreamBody', 'setFilterQuery', 'setMltBoost', 'setMltFields'
				);
		$mockConfig =	$this->getMock( 'WikiaSearchConfig', $searchConfigMethods );
		$mockClient	=	$this->getMock( 'Solarium_Client', array() );
		$mockSearch =	$this->getMockBuilder( 'WikiaSearch' )
							->disableOriginalConstructor()
							->setMethods( array( 'moreLikeThis', 'getQueryClausesString' ) )
							->getMock();
		$mockConfig
			->expects	( $this->any() )
			->method	( 'getQuery' )
			->will		( $this->returnValue( false ) )
		;
		$mockConfig
			->expects	( $this->once() )
			->method	( 'getStreamUrl' )
			->will		( $this->returnValue( false ) )
		;
		$mockConfig
			->expects	( $this->once() )
			->method	( 'getStreamBody' )
			->will		( $this->returnValue( 'stream' ) )
		;
		$mockSearch
			->expects	( $this->once() )
			->method	( 'getQueryClausesString' )
			->with		( $mockConfig )
			->will		( $this->returnValue( 'queryClausesString' ) )
		;
		$mockConfig
			->expects	( $this->once() )
			->method	( 'setFilterQuery' )
			->with		( 'queryClausesString' )
			->will		( $this->returnValue( $mockConfig ) )
		;
		$mockConfig
			->expects	( $this->once() )
			->method	( 'setMltBoost' )
			->with		( true )
			->will		( $this->returnValue( $mockConfig ) )
		;
		$mockConfig
			->expects	( $this->once() )
			->method	( 'setMltFields' )
			->will		( $this->returnValue( $mockConfig ) )
		;
		$mockSearch
			->expects	( $this->any() )
			->method	( 'moreLikeThis' )
			->with		( $mockConfig )
			->will		( $this->returnValue( array() ) )
		;

		$mockSearch->getSimilarPages( $mockConfig );
	}

	/**
	 * @covers WikiaSearch::getSimilarPages
	 */
	public function testGetSimilarPagesForUrl() {
		$searchConfigMethods = array(
				'getQuery', 'getStreamUrl', 'getStreamBody', 'setFilterQuery', 'setMltBoost', 'setMltFields'
				);
		$mockConfig =	$this->getMock( 'WikiaSearchConfig', $searchConfigMethods );
		$mockClient	=	$this->getMock( 'Solarium_Client', array() );
		$mockSearch =	$this->getMockBuilder( 'WikiaSearch' )
							->disableOriginalConstructor()
							->setMethods( array( 'moreLikeThis', 'getQueryClausesString' ) )
							->getMock();
		$mockConfig
			->expects	( $this->any() )
			->method	( 'getQuery' )
			->will		( $this->returnValue( false ) )
		;
		$mockConfig
			->expects	( $this->once() )
			->method	( 'getStreamUrl' )
			->will		( $this->returnValue( 'http://www.theonion.com/' ) )
		;
		$mockConfig
			->expects	( $this->never() )
			->method	( 'getStreamBody' )
		;
		$mockSearch
			->expects	( $this->once() )
			->method	( 'getQueryClausesString' )
			->with		( $mockConfig )
			->will		( $this->returnValue( 'queryClausesString' ) )
		;
		$mockConfig
			->expects	( $this->once() )
			->method	( 'setFilterQuery' )
			->with		( 'queryClausesString' )
			->will		( $this->returnValue( $mockConfig ) )
		;
		$mockConfig
			->expects	( $this->once() )
			->method	( 'setMltBoost' )
			->with		( true )
			->will		( $this->returnValue( $mockConfig ) )
		;
		$mockConfig
			->expects	( $this->once() )
			->method	( 'setMltFields' )
			->will		( $this->returnValue( $mockConfig ) )
		;
		$mockSearch
			->expects	( $this->any() )
			->method	( 'moreLikeThis' )
			->with		( $mockConfig )
			->will		( $this->returnValue( array() ) )
		;

		$mockSearch->getSimilarPages( $mockConfig );
	}

	/**
	 * @covers WikiaSearch::getSimilarPages
	 */
	public function testGetSimilarPagesWithQuery() {
		$searchConfigMethods = array(
				'getQuery', 'getStreamUrl', 'getStreamBody', 'setFilterQuery', 'setMltBoost', 'setMltFields'
				);
		$mockConfig		=	$this->getMock( 'WikiaSearchConfig', $searchConfigMethods );
		$mockSearch 	=	$this->getMockBuilder( 'WikiaSearch' )
								->disableOriginalConstructor()
								->setMethods( array( 'moreLikeThis', 'getQueryClausesString' ) )
								->getMock();

		$mockConfig
			->expects	( $this->any() )
			->method	( 'getQuery' )
			->will		( $this->returnValue( 'query fo sho' ) )
		;
		$mockConfig
			->expects	( $this->never() )
			->method	( 'getStreamUrl' )
		;
		$mockConfig
			->expects	( $this->never() )
			->method	( 'getStreamBody' )
		;
		$mockSearch
			->expects	( $this->never() )
			->method	( 'getQueryClausesString' )
		;
		$mockConfig
			->expects	( $this->never() )
			->method	( 'setFilterQuery' )
		;
		$mockConfig
			->expects	( $this->once() )
			->method	( 'setMltBoost' )
			->with		( true )
			->will		( $this->returnValue( $mockConfig ) )
		;
		$mockConfig
			->expects	( $this->once() )
			->method	( 'setMltFields' )
			->will		( $this->returnValue( $mockConfig ) )
		;
		$mockSearch
			->expects	( $this->any() )
			->method	( 'moreLikeThis' )
			->with		( $mockConfig )
			->will		( $this->returnValue( array( array( 'wid' => 123, 'pageid' => 321, 'junk' => 'foo', 'url' => 'http://www.memepool.com' ) ) ) )
		;

		$this->assertEquals(
				array( 'http://www.memepool.com' => array( 'wid' => 123, 'pageid' => 321 ) ),
				$mockSearch->getSimilarPages( $mockConfig ),
				'WikiaSearch::getSimilarPages should return associative array keyed by the URL of each result, with a value containing the wid and page id of that result'
		);
	}

	/**
	 * @covers WikiaSearch::getRelatedVideos
	 */
	public function testGetRelatedVideosWithPageId() {
		$searchConfigMethods = array(
				'getCityId', 'getPageId', 'setMindf', 'setQuery', 'setFilterQuery', 'setMltFields'
				);
		$mockConfig		=	$this->getMock( 'WikiaSearchConfig', $searchConfigMethods );
		$mockSearch 	=	$this->getMockBuilder( 'WikiaSearch' )
								->disableOriginalConstructor()
								->setMethods( array( 'moreLikeThis' ) )
								->getMock();

		$mockResults	=	$this->getMockBuilder( 'WikiaSearchResultSet' )
								->disableOriginalConstructor()
								->getMock();

		$filterQuery = sprintf( '%s AND %s AND %s',
	    							WikiaSearch::valueForField( 'wid', 123 ),
	    							WikiaSearch::valueForField( 'is_video', 'true' ),
	    							WikiaSearch::valueForField( 'ns',			NS_FILE )
	    							);

		$mockConfig
			->expects	( $this->any() )
			->method	( 'getPageId' )
			->will		( $this->returnValue( 234 ) )
		;
		$mockConfig
			->expects	( $this->any() )
			->method	( 'getCityId' )
			->will		( $this->returnValue( 123 ) )
		;
		$mockConfig
			->expects	( $this->once() )
			->method	( 'setQuery' )
			->with		( '(wid:123) AND (pageid:234)' )
			->will		( $this->returnValue( $mockConfig ) )
		;
		$mockConfig
			->expects	( $this->once() )
			->method	( 'setFilterQuery' )
			->with		( $filterQuery )
			->will		( $this->returnValue( $mockConfig ) )
		;
		$mockConfig
			->expects	( $this->once() )
			->method	( 'setMltFields' )
			->with		( array( WikiaSearch::field( 'title' ), WikiaSearch::field( 'html' ), 'title' ) )
			->will		( $this->returnValue( $mockConfig ) )
		;
		$mockSearch
			->expects	( $this->once() )
			->method	( 'moreLikeThis' )
			->with		( $mockConfig )
			->will		( $this->returnValue( $mockResults ) )
		;

		$mockSearch->getRelatedVideos( $mockConfig );
	}

	/**
	 * @covers WikiaSearch::getRelatedVideos
	 */
	public function testGetRelatedVideosWithoutPageId() {
		$searchConfigMethods = array(
				'getCityId', 'getPageId', 'setMindf', 'setQuery', 'setFilterQuery', 'setMltFields'
				);
		$mockConfig		=	$this->getMock( 'WikiaSearchConfig', $searchConfigMethods );
		$mockSearch 	=	$this->getMockBuilder( 'WikiaSearch' )
								->disableOriginalConstructor()
								->setMethods( array( 'moreLikeThis' ) )
								->getMock();

		$mockResults	=	$this->getMockBuilder( 'WikiaSearchResultSet' )
								->disableOriginalConstructor()
								->getMock();

		$mockApiService	=	$this->getMock( 'ApiService', array( 'call' ) );

		$params = array('action'	=> 'query',
		                'prop'		=> 'info|categories',
		                'inprop'	=> 'url|created|views|revcount',
		                'meta'		=> 'siteinfo',
		                'siprop'	=> 'statistics|wikidesc|variables|namespaces|category'
               			);

		$mockServiceResult = array(
				'query'	=>	array(
								'statistics' => array( 'articles' => 100 )
							)
		);

		$mockApiService
			->staticExpects	( $this->once() )
			->method		( 'call' )
			->with			( $params )
			->will			( $this->returnValue( $mockServiceResult ) )
		;

		$filterQuery = sprintf( '%s AND %s AND %s',
	    							WikiaSearch::valueForField( 'wid', 123 ),
	    							WikiaSearch::valueForField( 'is_video', 'true' ),
	    							WikiaSearch::valueForField( 'ns',			NS_FILE )
	    							);

		$mockConfig
			->expects	( $this->any() )
			->method	( 'getPageId' )
			->will		( $this->returnValue( false ) )
		;
		$mockConfig
			->expects	( $this->any() )
			->method	( 'getCityId' )
			->will		( $this->returnValue( 123 ) )
		;
		$mockConfig
			->expects	( $this->once() )
			->method	( 'setQuery' )
			->with		( '(wid:123) AND (iscontent:true)' )
			->will		( $this->returnValue( $mockConfig ) )
		;
		$mockConfig
			->expects	( $this->once() )
			->method	( 'setFilterQuery' )
			->with		( $filterQuery )
			->will		( $this->returnValue( $mockConfig ) )
		;
		$mockConfig
			->expects	( $this->once() )
			->method	( 'setMltFields' )
			->with		( array( WikiaSearch::field( 'title' ), WikiaSearch::field( 'html' ), 'title' ) )
			->will		( $this->returnValue( $mockConfig ) )
		;
		$mockSearch
			->expects	( $this->once() )
			->method	( 'moreLikeThis' )
			->with		( $mockConfig )
			->will		( $this->returnValue( $mockResults ) )
		;

		$this->mockClass( 'ApiService', $mockApiService );
		$this->mockApp();

		$mockSearch->getRelatedVideos( $mockConfig );
	}

	/**
	 * @covers WikiaSearch::getKeywords
	 */
	public function testGetKeywords() {
		$searchConfigMethods = array(
				'getCityId', 'getPageId', 'setQuery', 'setMltFields'
				);
		$mockConfig		=	$this->getMock( 'WikiaSearchConfig', $searchConfigMethods );
		$mockSearch 	=	$this->getMockBuilder( 'WikiaSearch' )
								->disableOriginalConstructor()
								->setMethods( array( 'getInterestingTerms' ) )
								->getMock();

		$noPageQuery = '(wid:123) AND (is_main_page:1)';
		$withPageQuery = '(wid:123) AND (pageid:234)';

		$mockConfig
			->expects	( $this->at( 0 ) )
			->method	( 'getCityId' )
			->will		( $this->returnValue( '123' ) )
		;
		$mockConfig
			->expects	( $this->at( 1 ) )
			->method	( 'getPageId' )
			->will		( $this->returnValue( false ) )
		;
		$mockConfig
			->expects	( $this->at( 2 ) )
			->method	( 'setQuery' )
			->with		( $noPageQuery )
			->will		( $this->returnValue( $mockConfig ) )
		;
		$mockConfig
			->expects	( $this->at( 3 ) )
			->method	( 'setMltFields' )
			->with		( array( WikiaSearch::field( 'title' ), WikiaSearch::field( 'html' ), 'title' ) )
			->will		( $this->returnValue( $mockConfig ) )
		;
		$interestingTerms = array( 'interesting', 'terms' );
		$mockSearch
			->expects	( $this->any() )
			->method	( 'getInterestingTerms' )
			->with		( $mockConfig )
			->will		( $this->returnValue( $interestingTerms ) )
		;
		$mockConfig
			->expects	( $this->at( 4 ) )
			->method	( 'getCityId' )
			->will		( $this->returnValue( '123' ) )
		;
		$mockConfig
			->expects	( $this->at( 5 ) )
			->method	( 'getPageId' )
			->will		( $this->returnValue( '234' ) )
		;
		$mockConfig
			->expects	( $this->at( 6 ) )
			->method	( 'getPageId' )
			->will		( $this->returnValue( '234' ) )
		;
		$mockConfig
			->expects	( $this->at( 7 ) )
			->method	( 'setQuery' )
			->with		( $withPageQuery )
			->will		( $this->returnValue( $mockConfig ) )
		;
		$mockConfig
			->expects	( $this->at( 8 ) )
			->method	( 'setMltFields' )
			->with		( array( WikiaSearch::field( 'title' ), WikiaSearch::field( 'html' ), 'title' ) )
			->will		( $this->returnValue( $mockConfig ) )
		;

		//without pageid
		$this->assertEquals(
				$interestingTerms,
				$mockSearch->getKeywords( $mockConfig ),
				'WikiaSearch::getKeywords should return an array of interesting terms'
		);

		//with pageid
		$this->assertEquals(
				$interestingTerms,
				$mockSearch->getKeywords( $mockConfig ),
				'WikiaSearch::getKeywords should return an array of interesting terms'
		);
	}

	/**
	 * @covers WikiaSearch::getInterestingTerms
	 */
	public function testGetInterestingTerms() {
		$searchConfigMethods = array(
				'setInterestingTerms', 'setMltFields', 'setMltBoost'
				);
		$mockConfig		=	$this->getMock( 'WikiaSearchConfig', $searchConfigMethods );
		$mockSearch 	=	$this->getMockBuilder( 'WikiaSearch' )
								->disableOriginalConstructor()
								->setMethods( array( 'moreLikeThis' ) )
								->getMock();

		$mockResultSet	=	$this->getMockBuilder( 'WikiaSearchResultSet' )
								->disableOriginalConstructor()
								->setMethods( array( 'getInterestingTerms' ) )
								->getMock();

		$mockTerms = array( 'mock', 'terms' );

		$mockConfig
			->expects	( $this->once() )
			->method	( 'setInterestingTerms' )
			->with		( 'list' )
			->will		( $this->returnValue( $mockConfig ) )
		;
		$mockConfig
			->expects	( $this->once() )
			->method	( 'setMltFields' )
			->with		( array( $mockSearch->field( 'title' ), $mockSearch->field( 'html' ), 'title' ) )
			->will		( $this->returnValue( $mockConfig ) )
		;
		$mockConfig
			->expects	( $this->once() )
			->method	( 'setMltBoost' )
			->with		( true )
			->will		( $this->returnValue( $mockConfig ) )
		;
		$mockSearch
			->expects	( $this->once() )
			->method	( 'moreLikeThis' )
			->with		( $mockConfig )
			->will		( $this->returnValue( $mockResultSet ) )
		;
		$mockResultSet
			->expects	( $this->once() )
			->method	( 'getInterestingTerms' )
			->will		( $this->returnValue( $mockTerms ) )
		;

		$this->assertEquals(
				$mockTerms,
				$mockSearch->getInterestingTerms( $mockConfig ),
				'WikiaSearch::getInterestingTerms should perform a moreLikeThis call and return the interesting terms of the result set in an array'
		);
	}
	
	/**
	 * @covers WikiaSearch::doSearch
	 */
	public function testDoSearch() {
		$mockConfig		=	$this->getMock( 'WikiaSearchConfig', array( 'getResults' ) );
		$mockResultSet	=	$this->getMockBuilder( 'WikiaSearchResultSet' )
								->disableOriginalConstructor()
								->getMock();
		
		$mockSearch		=	$this->getMockBuilder( 'WikiaSearch' )
								->disableOriginalConstructor()
								->setMethods( array( 'preSearch', 'search', 'postSearch' ) )
								->getMock();
		
		$mockResult		=	$this->getMockBuilder( 'Solarium_Result_Select' )
								->disableOriginalConstructor()
								->getMock();
		
		$mockSearch
			->expects	( $this->at( 0 ) )
			->method	( 'preSearch' )
			->with		( $mockConfig )
		;
		$mockSearch
			->expects	( $this->at( 1 ) )
			->method	( 'search' )
			->with		( $mockConfig )
			->will		( $this->returnValue( $mockResult ) )
		;
		$mockSearch
			->expects	( $this->at( 2 ) )
			->method	( 'postSearch' )
			->with		( $mockConfig, $mockResult )
		;
		$mockConfig
			->expects	( $this->at( 0 ) )
			->method	( 'getResults' )
			->will		( $this->returnValue( $mockResultSet ) )
		;
		$this->assertEquals(
				$mockResultSet,
				$mockSearch->doSearch( $mockConfig ),
				'WikiaSearch::doSearch should always return an instance of WikiaSearchResultSet'
		);
	}
	
	/**
	 * @covers WikiaSearch::preSearch 
	 */
	public function testPreSearchInterWiki() {
		$mockConfig		=	$this->getMock( 'WikiaSearchConfig', array( 'getGroupResults', 'setLength', 'setIsInterWiki', 'getPage' ) );
		
		$mockSearch 	=	$this->getMockBuilder( 'WikiaSearch' )
								->disableOriginalConstructor()
								->getMock();
		
		$mockConfig
			->expects	( $this->at( 0 ) )
			->method	( 'getGroupResults' )
			->will		( $this->returnValue( true ) )
		;
		$mockConfig
			->expects	( $this->at( 1 ) )
			->method	( 'setLength' )
			->with		( WikiaSearch::GROUP_RESULTS_GROUPINGS_LIMIT )
			->will		( $this->returnValue( $mockConfig ) )
		;
		$mockConfig
			->expects	( $this->at( 2 ) )
			->method	( 'setIsInterWiki' )
			->with		( true )
		;
		$mockConfig
			->expects	( $this->at( 3 ) )
			->method	( 'getPage' )
			->will		( $this->returnValue( 1 ) )
		;
		$mockConfig
			->expects	( $this->never() )
			->method	( 'setStart' )
		;
		
		$preSearch = new ReflectionMethod( 'WikiaSearch', 'preSearch' );
		$preSearch->setAccessible( true );
		$preSearch->invoke( $mockSearch, $mockConfig );
	}
	
	/**
	 * @covers WikiaSearch::preSearch 
	 */
	public function testPreSearchPaginated() {
		$mockConfig		=	$this->getMock( 'WikiaSearchConfig', array( 'getGroupResults', 'getPage', 'getLength', 'setStart' ) );
		
		$mockSearch 	=	$this->getMockBuilder( 'WikiaSearch' )
								->disableOriginalConstructor()
								->getMock();
		
		$mockConfig
			->expects	( $this->at( 0 ) )
			->method	( 'getGroupResults' )
			->will		( $this->returnValue( false ) )
		;
		$mockConfig
			->expects	( $this->at( 1 ) )
			->method	( 'getPage' )
			->will		( $this->returnValue( 2 ) )
		;
		$mockConfig
			->expects	( $this->at( 2 ) )
			->method	( 'getPage' )
			->will		( $this->returnValue( 3 ) )
		;
		$mockConfig
			->expects	( $this->at( 3 ) )
			->method	( 'getLength' )
			->will		( $this->returnValue( 10 ) )
		;
		$mockConfig
			->expects	( $this->at( 4 ) )
			->method	( 'setStart' )
			->with		( 20 )
		;
		
		$preSearch = new ReflectionMethod( 'WikiaSearch', 'preSearch' );
		$preSearch->setAccessible( true );
		$preSearch->invoke( $mockSearch, $mockConfig );
	}

	/**
	 * @covers WikiaSearch::postSearch
	 */
	public function testPostSearchWithoutSpellcheckOrTracking() {
		$mockConfig = $this->getMockBuilder( 'WikiaSearchConfig' )
							->setMethods( array( 'setresults', 'setResultsFound', 'getPage' ) )
							->getMock();
		
		$mockResults = $this->getMockBuilder( 'WikiaSearchResultSet' )
							->disableOriginalConstructor()
							->setMethods( array( 'getResultsFound' ) )
							->getMock();
		
		$mockSearch = $this->getMockBuilder( 'WikiaSearch' )
							->disableOriginalConstructor()
							->getMock();
		
		$mockResult = $this->getMockBuilder( 'Solarium_Result_Select' )
							->disableOriginalConstructor()
							->getMock();
		
		$found = 100;
		
		$mockResults
			->expects	( $this->at( 0 ) )
			->method	( 'getResultsFound' )
			->will		( $this->returnValue( $found ) )
		;
		$mockConfig
			->expects	( $this->at( 0 ) )
			->method	( 'setResults' )
			->with		( $mockResults )
			->will		( $this->returnValue( $mockConfig ) )
		;
		$mockConfig
			->expects	( $this->at( 1 ) )
			->method	( 'setResultsFound' )
			->with		( $found )
			->will		( $this->returnValue( $mockConfig ) )
		;
		$mockConfig
			->expects	( $this->at( 2 ) )
			->method	( 'getPage' )
			->will		( $this->returnValue( 2 ) )
		;
		
		$this->mockClass( 'WikiaSearchResultSet', $mockResults );
		$this->mockApp();
		
		$wg = new ReflectionProperty( 'WikiaSearch', 'wg' );
		$wg->setAccessible( true );
		$wg->setValue( $mockSearch, (object) array( 'WikiaSearchSpellcheckActivated' => false ) );
		
		$postSearch = new ReflectionMethod( 'WikiaSearch', 'postSearch' );
		$postSearch->setAccessible( true );
		$postSearch->invoke( $mockSearch, $mockConfig, $mockResult );
	}
	
	/**
	 * @covers WikiaSearch::postSearch
	 */
	public function testPostSearchWithSpellcheck() {
		$mockConfig = $this->getMockBuilder( 'WikiaSearchConfig' )
							->setMethods( array( 'setresults', 'setResultsFound', 'hasArticleMatch', 'setQuery', 'getPage' ) )
							->getMock();
		
		$mockResults = $this->getMockBuilder( 'WikiaSearchResultSet' )
							->disableOriginalConstructor()
							->setMethods( array( 'getResultsFound' ) )
							->getMock();
		
		$mockSearch = $this->getMockBuilder( 'WikiaSearch' )
							->disableOriginalConstructor()
							->setMethods( array( 'search' ) )
							->getMock();
		
		$mockSpellcheck = $this->getMockBuilder( 'Solarium_Result_Select_Spellcheck' )
								->disableOriginalConstructor()
								->setMethods( array( 'getCollation' ) )
								->getMock();
		
		$mockCollation = $this->getMockBuilder( 'Solarium_Result_Select_Spellcheck_Collation' )
								->disableOriginalConstructor()
								->setMethods( array( 'getQuery' ) )
								->getMock();
		
		$mockResult = $this->getMockBuilder( 'Solarium_Result_Select' )
							->disableOriginalConstructor()
							->setMethods( array( 'getNumFound', 'getSpellcheck' ) )
							->getMock();
		
		$found = 0;
		
		$mockResult
			->expects	( $this->at( 0 ) )
			->method	( 'getNumFound' )
			->will		( $this->returnValue( 0 ) )
		;
		$mockConfig
			->expects	( $this->at( 0 ) )
			->method	( 'hasArticleMatch' )
			->will		( $this->returnValue( false ) )
		;
		$mockResult
			->expects	( $this->at( 1 ) )
			->method	( 'getSpellcheck' )
			->will		( $this->returnValue( $mockSpellcheck ) )
		;
		$mockSpellcheck
			->expects	( $this->at( 0 ) )
			->method	( 'getCollation' )
			->will		( $this->returnValue( $mockCollation ) )
		;
		$mockCollation
			->expects	( $this->at( 0 ) )
			->method	( 'getQuery' )
			->will		( $this->returnValue( 'foo' ) )
		;
		$mockConfig
			->expects	( $this->at( 1 ) )
			->method	( 'setQuery' )
			->with		( 'foo' )
		;
		$mockSearch
			->expects	( $this->at( 0 ) )
			->method	( 'search' )
			->will		( $this->returnValue( $mockResult ) )
		;
		$mockResults
			->expects	( $this->at( 0 ) )
			->method	( 'getResultsFound' )
			->will		( $this->returnValue( $found ) )
		;
		$mockConfig
			->expects	( $this->at( 2 ) )
			->method	( 'setResults' )
			->with		( $mockResults )
			->will		( $this->returnValue( $mockConfig ) )
		;
		$mockConfig
			->expects	( $this->at( 3 ) )
			->method	( 'setResultsFound' )
			->with		( $found )
			->will		( $this->returnValue( $mockConfig ) )
		;
		$mockConfig
			->expects	( $this->at( 4 ) )
			->method	( 'getPage' )
			->will		( $this->returnValue( 2 ) )
		;
		
		$this->mockClass( 'WikiaSearchResultSet', $mockResults );
		$this->mockApp();
		
		$wg = new ReflectionProperty( 'WikiaSearch', 'wg' );
		$wg->setAccessible( true );
		$wg->setValue( $mockSearch, (object) array( 'WikiaSearchSpellcheckActivated' => true ) );
		
		$postSearch = new ReflectionMethod( 'WikiaSearch', 'postSearch' );
		$postSearch->setAccessible( true );
		$postSearch->invoke( $mockSearch, $mockConfig, $mockResult );
	}
	
	/**
	 * @covers WikiaSearch::postSearch
	 */
	public function testPostSearchWithTracking() {
		$mockConfig = $this->getMockBuilder( 'WikiaSearchConfig' )
							->setMethods( array( 'setresults', 'setResultsFound', 'getQuery', 'getIsInterWiki', 'getPage' ) )
							->getMock();
		
		$mockResult = $this->getMockBuilder( 'Solarium_Result_Select' )
							->disableOriginalConstructor()
							->getMock();
		
		$mockResults = $this->getMockBuilder( 'WikiaSearchResultSet' )
							->disableOriginalConstructor()
							->setMethods( array( 'getResultsFound' ) )
							->getMock();
		
		$mockSearch = $this->getMockBuilder( 'WikiaSearch' )
							->disableOriginalConstructor()
							->getMock();
		
		$mockTrack = $this->getMockBuilder( 'Track' )
						->disableOriginalConstructor()
						->setMethods( array( 'event' ) )
						->getMock();
		
		$found = 100;

		$mockResults
			->expects	( $this->at( 0 ) )
			->method	( 'getResultsFound' )
			->will		( $this->returnValue( $found ) )
		;
		$mockConfig
			->expects	( $this->at( 0 ) )
			->method	( 'setResults' )
			->with		( $mockResults )
			->will		( $this->returnValue( $mockConfig ) )
		;
		$mockConfig
			->expects	( $this->at( 1 ) )
			->method	( 'setResultsFound' )
			->with		( $found )
			->will		( $this->returnValue( $mockConfig ) )
		;
		$mockConfig
			->expects	( $this->at( 2 ) )
			->method	( 'getPage' )
			->will		( $this->returnValue( 1 ) )
		;
		$mockConfig
			->expects	( $this->at( 3 ) )
			->method	( 'getQuery' )
			->will		( $this->returnValue( 'foo' ) )
		;
		$mockConfig
			->expects	( $this->at( 4 ) )
			->method	( 'getIsInterWiki' )
			->will		( $this->returnValue( false ) )
		;
		$mockTrack
			->staticExpects	( $this->at( 0 ) )
			->method		( 'event' )
			->with			( 'search_start', array( 'sterm' => 'foo', 'rver' => WikiaSearch::RELEVANCY_FUNCTION_ID, 'stype' => 'intra' ) )
		;
		
		$this->mockClass( 'Track', $mockTrack );
		$this->mockClass( 'WikiaSearchResultSet', $mockResults );
		$this->mockApp();
		
		$wg = new ReflectionProperty( 'WikiaSearch', 'wg' );
		$wg->setAccessible( true );
		$wg->setValue( $mockSearch, (object) array( 'WikiaSearchSpellcheckActivated' => false ) );
		
		$postSearch = new ReflectionMethod( 'WikiaSearch', 'postSearch' );
		$postSearch->setAccessible( true );
		$postSearch->invoke( $mockSearch, $mockConfig, $mockResult );
	}

	/**
	 * @covers WikiaSearch::searchByLuceneQuery
	 */
	public function testSearchByLuceneQueryWorks() {
		$searchConfigMethods = array(
				'getGroupResults', 'setLength', 'setIsInterWiki', 'getPage', 'setResults', 'getRequestedFields',
				'setResultsFound', 'getQuery', 'getIsInterWiki', 'getLength', 'setStart', 'getSort', 'getStart'
				);
		$mockConfig		=	$this->getMock( 'WikiaSearchConfig', $searchConfigMethods );
		$mockClient		=	$this->getMockBuilder( 'Solarium_Client' )
								->disableOriginalConstructor()
								->setMethods( array( 'select', 'setAdapter', 'createSelect' ) )
								->getMock();

		$mockResultSet	=	$this->getMockBuilder( 'WikiaSearchResultSet' )
								->disableOriginalConstructor()
								->setMethods( array( 'getResultsFound' ) )
								->getMock();

		$mockSolResult	=	$this->getMockBuilder( 'Solarium_Result' )
								->disableOriginalConstructor()
								->getMock();

		$queryMethods	=	array( 'setDocumentClass', 'addFields', 'removeField', 'setStart', 'setRows', 'addSort', 'addParam', 'setQuery' );

		$mockQuery		=	$this->getMockBuilder( 'Solarium_Query_Select' )
								->disableOriginalConstructor()
								->setMethods( $queryMethods )
								->getMock();

		$mockWikia = $this->getMock( 'Wikia', array( 'log' ) );

		$mockClient
			->expects	( $this->once() )
			->method	( 'setAdapter' )
			->with		( 'Solarium_Client_Adapter_Curl' )
		;
		$mockClient
			->expects	( $this->once() )
			->method	( 'createSelect' )
			->will		( $this->returnValue( $mockQuery ) )
		;
		$mockQuery
			->expects	( $this->once() )
			->method	( 'setDocumentClass' )
			->with		( 'WikiaSearchResult' )
		;
		$mockConfig
			->expects	( $this->once() )
			->method	( 'getSort' )
			->will		( $this->returnValue( array( 'created', 'desc' ) ) )
		;
		$mockConfig
			->expects	( $this->once() )
			->method	( 'getRequestedFields' )
			->will		( $this->returnValue( array( 'title_en', 'url', 'id' ) ) )
		;
		$mockQuery
			->expects	( $this->once() )
			->method	( 'addFields' )
			->with		( array( 'title_en', 'url', 'id' ) )
			->will		( $this->returnValue( $mockQuery ) )
		;
		$mockQuery
			->expects	( $this->once() )
			->method	( 'removeField' )
			->with		( '*' )
			->will		( $this->returnValue( $mockQuery ) )
		;
		$mockConfig
			->expects	( $this->once() )
			->method	( 'getStart' )
			->will		( $this->returnValue( 0 ) )
		;
		$mockQuery
			->expects	( $this->once() )
			->method	( 'setStart' )
			->with		( 0 )
			->will		( $this->returnValue( $mockQuery ) )
		;
		$mockConfig
			->expects	( $this->once() )
			->method	( 'getLength' )
			->will		( $this->returnValue( 20 ) )
		;
		$mockQuery
			->expects	( $this->once() )
			->method	( 'setRows' )
			->with		( 20 )
			->will		( $this->returnValue( $mockQuery ) )
		;
		$mockQuery
			->expects	( $this->once() )
			->method	( 'addSort' )
			->with		( 'created', 'desc' )
			->will		( $this->returnValue( $mockQuery ) )
		;
		$mockQuery
			->expects	( $this->once() )
			->method	( 'addParam' )
			->with		( 'timeAllowed', 5000 )
			->will		( $this->returnValue( $mockQuery ) )
		;
		$mockConfig
			->expects	( $this->once() )
			->method	( 'getQuery' )
			->with		( WikiaSearchConfig::QUERY_RAW )
			->will		( $this->returnValue( 'hub:Entertainment' ) )
		;
		$mockQuery
			->expects	( $this->once() )
			->method	( 'setQuery' )
			->with		( 'hub:Entertainment' )
		;
		$mockClient
			->expects	( $this->once() )
			->method	( 'select' )
			->will		( $this->returnValue( $mockSolResult ) )
		;
		$mockConfig
			->expects	( $this->once() )
			->method	( 'setResults' )
			->with		( $mockResultSet )
			->will		( $this->returnValue( $mockConfig ) )
		;
		$mockResultSet
			->expects	( $this->once() )
			->method	( 'getResultsFound' )
			->will		( $this->returnValue( 200 ) )
		;
		$mockConfig
			->expects	( $this->once() )
			->method	( 'setResultsFound' )
			->with		( 200 )
		;

		$this->mockClass( 'WikiaSearchResultSet', $mockResultSet );
		$this->mockClass( 'Wikia', $mockWikia );
		$this->mockClass( 'Solarium_Client', $mockClient );
		$this->mockApp();

		$search = $this->getMockBuilder( 'WikiaSearch' )
						->setConstructorArgs( array( $mockClient ) )
						->setMethods( array() )
						->getMock();
		$search = F::build( 'WikiaSearch', array( $mockClient ) );

		$reflectionProperty = new ReflectionProperty( 'WikiaSearch', 'client' );
		$reflectionProperty->setAccessible( true );
		$reflectionProperty->setValue( $search, $mockClient );

		$results = $search->searchByLuceneQuery( $mockConfig );

		$this->assertEquals(
				$mockResultSet,
				$results,
				'WikiaSearchConfig::searchByLuceneQuery should return an instance of WikiaSearchResultSet, no matter what'
		);
	}

	/**
	 * @covers WikiaSearch::search
	 */
	public function testSearchWorksFirst() {
		$mockSearch = $this->getMockBuilder( 'WikiaSearch' )
							->disableOriginalConstructor()
							->setMethods( array( 'getSelectQuery' ) )
							->getMock();
		
		$mockClient = $this->getMockBuilder( 'Solarium_Client' )
							->disableOriginalConstructor()
							->setMethods( array( 'select' ) )
							->getMock();
		
		$mockConfig = $this->getMockBuilder( 'WikiaSearchConfig' )
							->disableOriginalConstructor()
							->setMethods( array() )
							->getMock();
		
		$mockResult = $this->getMockBuilder( 'Solarium_Result_Select' )
							->disableOriginalConstructor()
							->getMock();
		
		$mockQuery = $this->getMockBuilder( 'Solarium_Query_Select' )
							->disableOriginalConstructor()
							->getMock();
		
		$mockSearch
			->expects	( $this->at( 0 ) )
			->method	( 'getSelectQuery' )
			->with		( $mockConfig )
			->will		( $this->returnValue( $mockQuery ) )
		;
		$mockClient
			->expects	( $this->at( 0 ) )
			->method	( 'select' )
			->with		( $mockQuery )
			->will		( $this->returnValue( $mockResult ) )
		;
		
		$reflClient = new ReflectionProperty( 'WikiaSearch', 'client' );
		$reflClient->setAccessible( true );
		$reflClient->setValue( $mockSearch, $mockClient );
		
		$reflSearch = new ReflectionMethod( 'WikiaSearch', 'search' );
		$reflSearch->setAccessible( true );
		$this->assertEquals(
				$mockResult,
				$reflSearch->invoke( $mockSearch, $mockConfig ),
				'WikiaSearch::search should accept an instance of WikiaSearchConfig and return an instance of Solarium_Result_Select'
		);
	}
	
	/**
	 * @covers WikiaSearch::search
	 */
	public function testSearchWithoutBoost() {
		$mockSearch = $this->getMockBuilder( 'WikiaSearch' )
							->disableOriginalConstructor()
							->setMethods( array( 'getSelectQuery', 'search' ) )
							->getMock();
		
		$mockClient = $this->getMockBuilder( 'Solarium_Client' )
							->disableOriginalConstructor()
							->setMethods( array( 'select' ) )
							->getMock();
		
		$mockConfig = $this->getMockBuilder( 'WikiaSearchConfig' )
							->disableOriginalConstructor()
							->setMethods( array( 'getError', 'setError', 'setSkipBoostFunctions' ) )
							->getMock();
		
		$mockResult = $this->getMockBuilder( 'Solarium_Result_Select' )
							->disableOriginalConstructor()
							->getMock();
		
		$mockQuery = $this->getMockBuilder( 'Solarium_Query_Select' )
							->disableOriginalConstructor()
							->getMock();
		
		$mockException = $this->getMockBuilder( 'Exception' )
							->disableOriginalConstructor()
							->getMock();
		
		$mockWikia = $this->getMock( 'Wikia', array( 'log' ) );
		
		$mockSearch
			->expects	( $this->at( 0 ) )
			->method	( 'getSelectQuery' )
			->with		( $mockConfig )
			->will		( $this->returnValue( $mockQuery ) )
		;
		$mockClient
			->expects	( $this->at( 0 ) )
			->method	( 'select' )
			->with		( $mockQuery )
			->will		( $this->throwException( $mockException ) )
		;
		$mockConfig
			->expects	( $this->at( 0 ) )
			->method	( 'getError' )
			->will		( $this->returnValue( null ) )
		;
		$mockConfig
			->expects	( $this->at( 1 ) )
			->method	( 'setSkipBoostFunctions' )
			->with		( true )
			->will		( $this->returnValue( $mockConfig ) )
		;
		$mockConfig
			->expects	( $this->at( 2 ) )
			->method	( 'setError' )
			->with		( $mockException )
			->will		( $this->returnValue( $mockConfig ) )
		;
		$mockSearch
			->expects	( $this->at( 1 ) )
			->method	( 'search' )
			->with		( $mockConfig )
			->will		( $this->returnValue( $mockResult ) )
		;
		
		$this->mockClass( 'Wikia', $mockWikia );
		$this->mockApp();
		
		$reflClient = new ReflectionProperty( 'WikiaSearch', 'client' );
		$reflClient->setAccessible( true );
		$reflClient->setValue( $mockSearch, $mockClient );
		
		$reflSearch = new ReflectionMethod( 'WikiaSearch', 'search' );
		$reflSearch->setAccessible( true );
		$this->assertEquals(
				$mockResult,
				$reflSearch->invoke( $mockSearch, $mockConfig ),
				'WikiaSearch::search should accept an instance of WikiaSearchConfig and return an instance of Solarium_Result_Select'
		);
	}
	
	/**
	 * @covers WikiaSearch::search
	 */
	public function testSearchGivesUp() {
		$mockSearch = $this->getMockBuilder( 'WikiaSearch' )
							->disableOriginalConstructor()
							->setMethods( array( 'getSelectQuery', 'search' ) )
							->getMock();
		
		$mockClient = $this->getMockBuilder( 'Solarium_Client' )
							->disableOriginalConstructor()
							->setMethods( array( 'select' ) )
							->getMock();
		
		$mockConfig = $this->getMockBuilder( 'WikiaSearchConfig' )
							->disableOriginalConstructor()
							->setMethods( array( 'getError', 'setError', 'setSkipBoostFunctions' ) )
							->getMock();
		
		$mockResult = $this->getMockBuilder( 'Solarium_Result_Select' )
							->disableOriginalConstructor()
							->getMock();
		
		$mockQuery = $this->getMockBuilder( 'Solarium_Query_Select' )
							->disableOriginalConstructor()
							->getMock();
		
		$mockException = $this->getMockBuilder( 'Exception' )
							->disableOriginalConstructor()
							->getMock();
		
		$mockWikia = $this->getMock( 'Wikia', array( 'log' ) );
		
		$mockSearch
			->expects	( $this->at( 0 ) )
			->method	( 'getSelectQuery' )
			->with		( $mockConfig )
			->will		( $this->returnValue( $mockQuery ) )
		;
		$mockClient
			->expects	( $this->at( 0 ) )
			->method	( 'select' )
			->with		( $mockQuery )
			->will		( $this->throwException( $mockException ) )
		;
		$mockConfig
			->expects	( $this->at( 0 ) )
			->method	( 'getError' )
			->will		( $this->returnValue( $mockException ) )
		;
		$mockConfig
			->expects	( $this->at( 1 ) )
			->method	( 'setError' )
			->with		( $mockException )
		;
		
		$this->mockClass( 'Wikia', $mockWikia );
		$this->mockApp();
		
		$reflClient = new ReflectionProperty( 'WikiaSearch', 'client' );
		$reflClient->setAccessible( true );
		$reflClient->setValue( $mockSearch, $mockClient );
		
		$reflSearch = new ReflectionMethod( 'WikiaSearch', 'search' );
		$reflSearch->setAccessible( true );
		$this->assertInstanceOf(
				'Solarium_Result_Select_Empty',
				$reflSearch->invoke( $mockSearch, $mockConfig ),
				'WikiaSearch::search should accept an instance of WikiaSearchConfig and return an instance of Solarium_Result_Select_Empty if a retry does not work'
		);
	}
	
	/**
	 * @covers WikiaSearch::registerSpellcheck
	 */
	public function testRegisterSpellcheck() {
		$mockSearch = $this->getMockBuilder( 'WikiaSearch' )
							->disableOriginalConstructor()
							->getMock();
		
		$mockConfig = $this->getMockBuilder( 'WikiaSearchConfig' )
							->disableOriginalConstructor()
							->setMethods( array( 'getQueryNoQuotes', 'getCityId' ) )
							->getMock();
		
		$mockQuery = $this->getMockBuilder( 'Solarium_Query_Select' )
							->disableOriginalConstructor()
							->setMethods( array( 'getSpellcheck' ) )
							->getMock();
		
		$spellcheckMethods = array( 'setQuery', 'setCollate', 'setCount', 'setMaxCollationTries', 'setMaxCollations', 'setExtendedResults', 
									'setCollateParam', 'setOnlyMorePopular', 'setDictionary', 'setCollateExtendedResults' );
		
		$mockSpellcheck = $this->getMockBuilder( 'Solarium_Query_Select_Component_Spellcheck' )
								->disableOriginalConstructor()
								->setMethods( $spellcheckMethods )
								->getMock();
		
		$query = 'foo';
		
		$mockQuery
			->expects	( $this->at( 0 ) )
			->method	( 'getSpellcheck' )
			->will		( $this->returnValue( $mockSpellcheck ) )
		;
		$mockConfig
			->expects	( $this->at( 0 ) )
			->method	( 'getQueryNoQuotes' )
			->with		( true )
			->will		( $this->returnValue( $query ) )			
		;
		$mockSpellcheck
			->expects	( $this->at( 0 ) )
			->method	( 'setQuery' )
			->with		( $query )
			->will		( $this->returnValue( $mockSpellcheck ) )
		;
		$mockSpellcheck
			->expects	( $this->at( 1 ) )
			->method	( 'setCollate' )
			->with		( true )
			->will		( $this->returnValue( $mockSpellcheck ) )
		;
		$mockSpellcheck
			->expects	( $this->at( 2 ) )
			->method	( 'setCount' )
			->with		( WikiaSearch::SPELLING_RESULT_COUNT )
			->will		( $this->returnValue( $mockSpellcheck ) )
		;
		$mockSpellcheck
			->expects	( $this->at( 3 ) )
			->method	( 'setMaxCollationTries' )
			->with		( WikiaSearch::SPELLING_MAX_COLLATION_TRIES )
			->will		( $this->returnValue( $mockSpellcheck ) )
		;
		$mockSpellcheck
			->expects	( $this->at( 4 ) )
			->method	( 'setMaxCollations' )
			->with		( WikiaSearch::SPELLING_MAX_COLLATIONS )
			->will		( $this->returnValue( $mockSpellcheck ) )
		;
		$mockSpellcheck
			->expects	( $this->at( 5 ) )
			->method	( 'setExtendedResults' )
			->with		( true )
			->will		( $this->returnValue( $mockSpellcheck ) )
		;
		$mockConfig
			->expects	( $this->at( 1 ) )
			->method	( 'getCityId' )
			->will		( $this->returnValue( '123' ) )			
		;
		$mockSpellcheck
			->expects	( $this->at( 6 ) )
			->method	( 'setCollateParam' )
			->with		( 'fq', 'is_content:true AND wid:123' )
			->will		( $this->returnValue( $mockSpellcheck ) )
		;
		$mockSpellcheck
			->expects	( $this->at( 7 ) )
			->method	( 'setOnlyMorePopular' )
			->with		( true )
			->will		( $this->returnValue( $mockSpellcheck ) )
		;
		$mockSpellcheck
			->expects	( $this->at( 8 ) )
			->method	( 'setDictionary' )
			->with		( 'en' )
			->will		( $this->returnValue( $mockSpellcheck ) )
		;
		$mockSpellcheck
			->expects	( $this->at( 9 ) )
			->method	( 'setCollateExtendedResults' )
			->with		( true )
			->will		( $this->returnValue( $mockSpellcheck ) )
		;
		
		$wg = new ReflectionProperty( 'WikiaSearch', 'wg' );
		$wg->setAccessible( true );
		$wg->setValue( $mockSearch, (object) array( 'WikiaSearchSpellcheckActivated' => true, 'LanguageCode' => 'en', 'WikiaSearchSupportedLanguages' => array( 'en' ) ) );
		
		$handle = new ReflectionMethod( 'WikiaSearch', 'registerSpellcheck' );
		$handle->setAccessible( true );
		$this->assertEquals(
				$mockSearch,
				$handle->invoke( $mockSearch, $mockQuery, $mockConfig )
		);
	}
	

	/**
	 * @covers WikiaSearch::searchByLuceneQuery
	 */
	public function testSearchByLuceneQueryBreaksGracefully() {
		$searchConfigMethods = array(
				'getGroupResults', 'setLength', 'setIsInterWiki', 'getPage', 'setResults', 'getRequestedFields',
				'setResultsFound', 'getQuery', 'getIsInterWiki', 'getLength', 'setStart', 'getSort', 'getStart'
				);
		$mockConfig		=	$this->getMock( 'WikiaSearchConfig', $searchConfigMethods );
		$mockClient		=	$this->getMockBuilder( 'Solarium_Client' )
								->disableOriginalConstructor()
								->setMethods( array( 'select', 'setAdapter', 'createSelect' ) )
								->getMock();

		$mockResultSet	=	$this->getMockBuilder( 'WikiaSearchResultSet' )
								->disableOriginalConstructor()
								->setMethods( array( 'getResultsFound' ) )
								->getMock();

		$mockSolResult	=	$this->getMockBuilder( 'Solarium_Result' )
								->disableOriginalConstructor()
								->getMock();

		$mockException	=	$this->getMock( 'Exception' );

		$queryMethods	=	array( 'setDocumentClass', 'addFields', 'removeField', 'setStart', 'setRows', 'addSort', 'addParam', 'setQuery' );

		$mockQuery		=	$this->getMockBuilder( 'Solarium_Query_Select' )
								->disableOriginalConstructor()
								->setMethods( $queryMethods )
								->getMock();

		$mockWikia = $this->getMock( 'Wikia', array( 'log' ) );

		$mockClient
			->expects	( $this->once() )
			->method	( 'setAdapter' )
			->with		( 'Solarium_Client_Adapter_Curl' )
		;
		$mockClient
			->expects	( $this->once() )
			->method	( 'createSelect' )
			->will		( $this->returnValue( $mockQuery ) )
		;
		$mockQuery
			->expects	( $this->once() )
			->method	( 'setDocumentClass' )
			->with		( 'WikiaSearchResult' )
		;
		$mockConfig
			->expects	( $this->once() )
			->method	( 'getSort' )
			->will		( $this->returnValue( array( 'created', 'desc' ) ) )
		;
		$mockConfig
			->expects	( $this->once() )
			->method	( 'getRequestedFields' )
			->will		( $this->returnValue( array( 'title_en', 'url', 'id' ) ) )
		;
		$mockQuery
			->expects	( $this->once() )
			->method	( 'addFields' )
			->with		( array( 'title_en', 'url', 'id' ) )
			->will		( $this->returnValue( $mockQuery ) )
		;
		$mockQuery
			->expects	( $this->once() )
			->method	( 'removeField' )
			->with		( '*' )
			->will		( $this->returnValue( $mockQuery ) )
		;
		$mockConfig
			->expects	( $this->once() )
			->method	( 'getStart' )
			->will		( $this->returnValue( 0 ) )
		;
		$mockQuery
			->expects	( $this->once() )
			->method	( 'setStart' )
			->with		( 0 )
			->will		( $this->returnValue( $mockQuery ) )
		;
		$mockConfig
			->expects	( $this->once() )
			->method	( 'getLength' )
			->will		( $this->returnValue( 20 ) )
		;
		$mockQuery
			->expects	( $this->once() )
			->method	( 'setRows' )
			->with		( 20 )
			->will		( $this->returnValue( $mockQuery ) )
		;
		$mockQuery
			->expects	( $this->once() )
			->method	( 'addSort' )
			->with		( 'created', 'desc' )
			->will		( $this->returnValue( $mockQuery ) )
		;
		$mockQuery
			->expects	( $this->once() )
			->method	( 'addParam' )
			->with		( 'timeAllowed', 5000 )
			->will		( $this->returnValue( $mockQuery ) )
		;
		$mockConfig
			->expects	( $this->once() )
			->method	( 'getQuery' )
			->with		( WikiaSearchConfig::QUERY_RAW )
			->will		( $this->returnValue( 'hub:Entertainment' ) )
		;
		$mockQuery
			->expects	( $this->once() )
			->method	( 'setQuery' )
			->with		( 'hub:Entertainment' )
		;
		$mockClient
			->expects	( $this->once() )
			->method	( 'select' )
			->will		( $this->throwException( $mockException ) )
		;
		$mockConfig
			->expects	( $this->once() )
			->method	( 'setResults' )
			->with		( $mockResultSet )
			->will		( $this->returnValue( $mockConfig ) )
		;
		$mockResultSet
			->expects	( $this->once() )
			->method	( 'getResultsFound' )
			->will		( $this->returnValue( 200 ) )
		;
		$mockConfig
			->expects	( $this->once() )
			->method	( 'setResultsFound' )
			->with		( 200 )
		;

		$this->mockClass( 'WikiaSearchResultSet', $mockResultSet );
		$this->mockClass( 'Wikia', $mockWikia );
		$this->mockClass( 'Solarium_Client', $mockClient );
		$this->mockApp();

		$search = $this->getMockBuilder( 'WikiaSearch' )
						->setConstructorArgs( array( $mockClient ) )
						->setMethods( array() )
						->getMock();
		$search = F::build( 'WikiaSearch', array( $mockClient ) );

		$reflectionProperty = new ReflectionProperty( 'WikiaSearch', 'client' );
		$reflectionProperty->setAccessible( true );
		$reflectionProperty->setValue( $search, $mockClient );

		$results = $search->searchByLuceneQuery( $mockConfig );

		$this->assertEquals(
				$mockResultSet,
				$results,
				'WikiaSearchConfig::searchByLuceneQuery should return an instance of WikiaSearchResultSet, no matter what'
		);
	}
}