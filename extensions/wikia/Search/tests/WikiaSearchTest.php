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
		$this->assertEquals( WikiaSearch::valueForField( 'foo', 'bar' ), '(foo:bar)', 
														'WikiaSearch::valueForField() did not construct field value as expected' );
		$this->assertEquals( WikiaSearch::valueForField( 'foo', 'bar', array( 'boost' => 5 ) ), '(foo:bar)^5',
														'WikiaSearch::valueForField() did not construct field value with boost as expected' );
		$this->assertEquals( WikiaSearch::valueForField( 'foo', 'bar', array( 'quote'=>"'" ) ), "(foo:'bar')",
		        										'WikiaSearch::valueForField() did not construct field value with quote as expected' );
		$this->assertEquals( WikiaSearch::valueForField( 'foo', 'bar', array( 'quote' => "'", 'boost' => 5 ) ), "(foo:'bar')^5",
		        										'WikiaSearch::valueForField() did not construct field value with quote and boost as expected' );
		
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
		
		$this->assertEquals( "(wid:{$mockCityId}) AND is_redirect:false", $method->invoke( $wikiaSearch, $searchConfig ),
							'The default behavior for on-wiki search should be to filter query for wiki ID and against redirects.' );
		
		$searchConfig->setIncludeRedirects( true );
		
		$this->assertEquals( "wid:{$mockCityId}", $method->invoke( $wikiaSearch, $searchConfig ),
							'If we have redirects configured to be included, we should not be filter against them in the filter query.' );
		
		$searchConfig->setIsInterWiki( true );
		
		$this->assertEquals( 'iscontent:true', $method->invoke( $wikiaSearch, $searchConfig), 
							'An interwiki search should filter for content pages only.' );
		
		$searchConfig->setHub( $mockHub );
		
		$this->assertEquals( 'iscontent:true hub:Games', $method->invoke( $wikiaSearch, $searchConfig ), 
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
		$this->assertEquals( $method->invoke( $wikiaSearch, $searchConfig ),
							'(html:\"foo bar\")^5 (title:\"foo bar\")^10', 
							'WikiaSearch::getBoostQueryString should boost exact-match in quotes for html and title field'
							);
		
		$searchConfig->setQuery('"foo bar"');
		$this->assertEquals( $method->invoke( $wikiaSearch, $searchConfig ),
					        '(html:\"foo bar\")^5 (title:\"foo bar\")^10',
					        'WikiaSearch::getBoostQueryString should strip quotes from original query'
							);

		$searchConfig->setQuery("'foo bar'");
		$this->assertEquals( $method->invoke( $wikiaSearch, $searchConfig ),
					        '(html:\"foo bar\")^5 (title:\"foo bar\")^10',
					        'WikiaSearch::getBoostQueryString should strip quotes from original query'
							);
		
		$searchConfig	->setQuery		('foo bar wiki')
						->setIsInterWiki(true)
		;
		$this->assertEquals( $method->invoke( $wikiaSearch, $searchConfig ),
					        '(html:\"foo bar\")^5 (title:\"foo bar\")^10 (wikititle:\"foo bar\")^15 -host:\"answers\"^10 -host:\"respuestas\"^10',
					        'WikiaSearch::getBoostQueryString should remove "wiki" from searches,, include wikititle, and remove answers wikis'
							);
		
		
	}
	
	
}