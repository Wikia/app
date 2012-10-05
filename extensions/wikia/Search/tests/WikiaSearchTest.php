<?php 

require_once( 'WikiaSearchBaseTest.php' );

class WikiaSearchTest extends WikiaSearchBaseTest {
	
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
		
		// A field that is dynamic unstored should have '_us' and the language code appended
		$dynamicUnstoredField			= 'first500';
		$dynamicUnstoredOutput			= WikiaSearch::field( $dynamicUnstoredField );
		$expectedDynamicUnstoredOutput	= 'first500_us_en';
		$this->assertEquals( $dynamicUnstoredOutput, $expectedDynamicUnstoredOutput, 
							'An unstored dynamic field did not have the appropriate suffixes appended during WikiaSearch::field()' );
		
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
		
		$this->assertEquals( "(wid:{$mockCityId}) AND (is_redirect:false)", $method->invoke( $wikiaSearch, $searchConfig ),
							'The default behavior for on-wiki search should be to filter query for wiki ID and against redirects.' );
		
		$searchConfig->setIncludeRedirects( true );
		
		$this->assertEquals( "(wid:{$mockCityId})", $method->invoke( $wikiaSearch, $searchConfig ),
							'If we have redirects configured to be included, we should not be filter against them in the filter query.' );
		
		$searchConfig->setVideoSearch( true );
		$searchConfig->setIncludeRedirects( false );
		
		$this->assertEquals( "((wid:{$mockCityId}) OR (wid:".WikiaSearch::VIDEO_WIKI_ID.")) AND (is_redirect:false)", $method->invoke( $wikiaSearch, $searchConfig ),
		'If we have redirects configured to be included, we should not be filter against them in the filter query.' );
		
		$searchConfig->setIsInterWiki( true );
		
		$this->assertEquals( '(iscontent:true) AND (is_redirect:false)', $method->invoke( $wikiaSearch, $searchConfig), 
							'An interwiki search should filter for content pages only.' );
		
		$searchConfig->setHub( $mockHub );
		
		$this->assertEquals( '(iscontent:true) AND (hub:Games) AND (is_redirect:false)', $method->invoke( $wikiaSearch, $searchConfig ), 
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
		$this->assertEquals( '(html:\"foo bar\")^5 (title:\"foo bar\")^10',
							$method->invoke( $wikiaSearch, $searchConfig ),
							'WikiaSearch::getBoostQueryString should boost exact-match in quotes for html and title field'
							);
		
		$searchConfig->setQuery('"foo bar"');
		$this->assertEquals( '(html:\"foo bar\")^5 (title:\"foo bar\")^10',
					        $method->invoke( $wikiaSearch, $searchConfig ),
					        'WikiaSearch::getBoostQueryString should strip quotes from original query'
							);

		$searchConfig->setQuery("'foo bar'");
		$this->assertEquals( '(html:\"foo bar\")^5 (title:\"foo bar\")^10',
							 $method->invoke( $wikiaSearch, $searchConfig ),
					        'WikiaSearch::getBoostQueryString should strip quotes from original query'
							);
		
		$searchConfig	->setQuery		('foo bar wiki')
						->setIsInterWiki(true)
		;
		$this->assertEquals( '(html:\"foo bar\")^5 (title:\"foo bar\")^10 (wikititle:\"foo bar\")^15 -(host:answers)^10 -(host:respuestas)^10',
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
		
		$method = new ReflectionMethod( 'WikiaSearch', 'getQueryClausesString' );
		$method->setAccessible( true );
		
		$searchConfig->setNamespaces( array(1, 2, 3) );
		
		$this->assertEquals( '((wid:123) AND ((ns:1) OR (ns:2) OR (ns:3)))', $method->invoke( $wikiaSearch, $searchConfig ),
							'WikiaSearch::getQueryClauses by default should query for namespaces and wiki ID.' );
		
		$searchConfig->setVideoSearch( true );
		
		$expectedWithVideo = '(((wid:123) OR (wid:'.WikiaSearch::VIDEO_WIKI_ID.')) AND (is_video:true) AND ((ns:'.NS_FILE.')))';
		$this->assertEquals( $expectedWithVideo, $method->invoke( $wikiaSearch, $searchConfig ),
							'WikiaSearch::getQueryClauses should search only for video namespaces in video search, and should only search for videos' );
		
		$searchConfig	->setVideoSearch	( false )
						->setIsInterWiki	( true );
		
		$expectedInterWiki = '((-(wid:123) AND -(wid:234)) AND (lang:en) AND (iscontent:true))';
		$this->assertEquals( $expectedInterWiki, $method->invoke( $wikiaSearch, $searchConfig ),
		        			'WikiaSearch::getQueryClauses should exclude bad wikis, require the language of the wiki, and require content' );
		
	}
	
	/**
	 * @covers WikiaSearch::getArticleMatch
	 */
	public function testGetArticleMatchHasMatch() {
		
		$wikiaSearch		= F::build( 'WikiaSearch' );
		$mockSearchConfig	= $this->getMock( 'WikiaSearchConfig', array( 'getQuery', 'hasArticleMatch', 'getArticleMatch' ) );
		$mockTitle			= $this->getMock( 'Title', array( 'getNamespace' ) );
		$mockArticle		= $this->getMock( 'Article', array(), array( $mockTitle ) );
		$mockArticleMatch	= $this->getMock( 'WikiaSearchArticleMatch', array(), array( $mockArticle ) );
		$mockTerm			= 'foo';
		
		// If there's already an article match set in the search config, return that
		$mockSearchConfig
			->expects	( $this->any() )
			->method	( 'getQuery' )
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
		$mockSearchConfig	= $this->getMock( 'WikiaSearchConfig', array( 'getQuery', 'hasArticleMatch', 'getArticleMatch' ) );
		$mockTitle			= $this->getMock( 'Title', array( 'getNamespace' ) );
		$mockArticle		= $this->getMock( 'Article', array(), array( $mockTitle ) );
		$mockArticleMatch	= $this->getMock( 'WikiaSearchArticleMatch', array(), array( $mockArticle ) );
		$mockSearchEngine	= $this->getMock( 'stdClass', array( 'getNearMatch' ) );
		$mockTerm			= 'foo';
		
		$mockSearchConfig
			->expects	( $this->any() )
			->method	( 'getQuery' )
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
		$mockSearchConfig	= $this->getMock( 'WikiaSearchConfig', array( 'getArticleMatch', 'setArticleMatch', 'getNamespaces', 'getQuery' ) );
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
			->method	( 'getQuery' )
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
	    $mockSearchConfig	= $this->getMock( 'WikiaSearchConfig', array( 'getQuery', 'getNamespaces', 'hasArticleMatch' ) );
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
		    ->method	( 'getQuery' )
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
		
		$mockClient			=	$this->getMock( 'Solarium_Client', array( 'setAdapter', 'createSelect', 'select' ) );
		$wikiaSearch		=	F::build( 'WikiaSearch', array( $mockClient ) ); 
		$searchConfig		=	F::build( 'WikiaSearchConfig' );
		$method				=	new ReflectionMethod( 'WikiaSearch', 'getSelectQuery' );
		
		$searchConfig->setQuery( 'foo' );
		$method->setAccessible( true );
		
		
		$query = $method->invoke( $wikiaSearch, $searchConfig ); /** @var Solarium_Query_Select $query **/ 
		
		$this->assertInstanceOf(
				'Solarium_Query_Select',
				$query,
				'WikiaSearch::getSelectQuery should return an instance of Solarium_Query_Select.'
		);
		$this->assertEquals(
				'WikiaSearchResult',
				$query->getDocumentClass(),
				'WikiaSearch::getSelectQuery should set the query\'s document class to WikiaSearchResult.'
		);
		$requested	= $searchConfig->getRequestedFields();
		$actual		= $query->getFields();
		sort($requested);
		sort($actual); 
		$this->assertEquals(
				$requested,
				$actual,
				'WikiaSearch::getSelectQuery should set the requested fields to be identical to those set in WikiaSearchConfig.'
		);
		$this->assertEquals(
				$searchConfig->getStart(),
				$query->getStart(),
				'WikiaSearch::getSelectQuery should set the start offset to be identical to that set in WikiaSearchConfig.'
		);
		$sort = $searchConfig->getSort();
		$this->assertEquals(
				array( $sort[0] => $sort[1] ),
				$query->getSorts(),
				'WikiaSearch::getSelectQuery should set the sort value to be identical to that set in WikiaSearchConfig via the rank key.'
		);
		$params = $query->getParams();
		$this->assertEquals(
				5000,
				$params['timeAllowed'],
				'WikiaSearch::getSelectQuery should set the sort value to be identical to that set in WikiaSearchConfig via the rank key.'
		);
		$highlighting = $query->getHighlighting();
		$this->assertEquals(
		        array( WikiaSearch::field( 'html' ) ),
		        array_keys( $highlighting->getFields() ),
		        'WikiaSearch::getSelectQuery should select the proper dynamic field for html to highlight.'
		);
		$this->assertEquals(
		        1,
		        $highlighting->getSnippets(),
		        'WikiaSearch::getSelectQuery should set the number of highlighting snippets to 1.'
		);
		$this->assertTrue(
		        $highlighting->getRequireFieldMatch(),
		        'WikiaSearch::getSelectQuery should require a field match to get highlighting snippets.'
		);
		$this->assertEquals(
		        WikiaSearch::HL_FRAG_SIZE,
		        $highlighting->getFragSize(),
		        'WikiaSearch::getSelectQuery should set the highlighting frag size according to its constant.'
		);
		$this->assertEquals(
		        WikiaSearch::HL_MATCH_PREFIX,
		        $highlighting->getSimplePrefix(),
		        'WikiaSearch::getSelectQuery should set the highlighting prefix according to its constant.'
		);
		$this->assertEquals(
		        WikiaSearch::HL_MATCH_POSTFIX,
		        $highlighting->getSimplePostfix(),
		        'WikiaSearch::getSelectQuery should set the highlighting postfix according to its constant.'
		);
		$this->assertEquals(
		        'html',
		        $highlighting->getAlternateField(),
		        'WikiaSearch::getSelectQuery should set the highlighting alternate field to be non-dynamic html.'
		);
		$this->assertEquals(
				300,
				$highlighting->getMaxAlternateFieldLength(),
				'WikiaSearch::getSelectQuery should set the highlighting alternate field length to 300 by default.'	
		);
		$this->assertInstanceOf(
				'Solarium_Query_Select_FilterQuery',
				$query->getFilterQuery('fq1'),
				'WikiaSearch::getSelectQuery should register filter query at key "fq1".'
		);
		
		$queryClausesStringMethod	= new ReflectionMethod( 'WikiaSearch', 'getQueryClausesString' );
		$getNestedQueryMethod		= new ReflectionMethod( 'WikiaSearch', 'getNestedQuery' );
		$queryClausesStringMethod->setAccessible( true );
		$getNestedQueryMethod->setAccessible( true );
		$constructedQuery 			= sprintf('%s AND (%s)%s', $queryClausesStringMethod->invoke( $wikiaSearch, $searchConfig ), $getNestedQueryMethod->invoke( $wikiaSearch, $searchConfig ), '');
		$this->assertEquals(
				$constructedQuery,
				$query->getQuery(),
				'WikiaSearch::getSelectQuery should return a query instance with a query string based on WikiaSearch::getQueryClausesString and WikiaSearch::getNestedQuery'
		);
		
		// now to test article match
		// now to test interwiki
	}
	
	/**
	 * @covers WikiaSearch::getNestedQuery
	 */
	public function testGetNestedQuery() {
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
	 * @covers WikiaSearch::getQueryFieldsString
	 */
	public function testGetQueryFieldsString() {

		$this->mockGlobalVariable( 'wgLanguageCode', 'en' );
		$this->mockApp();
		
		$mockClient			=	$this->getMock( 'Solarium_Client' );
		$wikiaSearch		=	F::build( 'WikiaSearch', array( $mockClient ) );
		$searchConfig		=	F::build( 'WikiaSearchConfig' ); /** @var WikiaSearchConfig $searchConfig  **/
		$method				=	new ReflectionMethod( 'WikiaSearch', 'getQueryFieldsString' );
		$defaultString		=	sprintf( '%s^5 %s %s^4', WikiaSearch::field( 'title' ), WikiaSearch::field( 'html' ), WikiaSearch::field( 'redirect_titles' ) );
		$interwikiString	=	$defaultString . sprintf( ' %s^7', WikiaSearch::field( 'wikititle' ) );
		
		$method->setAccessible( true );
		$searchConfig->setQuery( 'foo' );
		
		$this->assertEquals(
				$defaultString,
				$method->invoke( $wikiaSearch, $searchConfig ),
				'WikiaSearch should query against the dynamic title, html, and redirect titles fields by default.'
		);
		
		$searchConfig->setInterWiki( true );
		$this->assertEquals(
				$interwikiString,
				$method->invoke( $wikiaSearch, $searchConfig ),
				'WikiaSearch should add wikititle as a query field if we are performing an interwiki search.'
		);
		
		$searchConfig
			->setIsInterWiki	( false )
			->setVideoSearch	( true )
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
		
		$frVideoString		=	sprintf( '%s^5 %s %s^4 %s^5 %s %s^4',
						        WikiaSearch::field( 'title', 'fr' ),
						        WikiaSearch::field( 'html', 'fr' ),
						        WikiaSearch::field( 'redirect_titles', 'fr' ),
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
	
}