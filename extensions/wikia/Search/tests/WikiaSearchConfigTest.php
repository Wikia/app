<?php 

require_once( 'WikiaSearchBaseTest.php' );

class WikiaSearchConfigTest extends WikiaSearchBaseTest {
	
	/**
	 * @covers WikiaSearchConfig::__construct
	 */
	public function testConstructor() {
		
		$newParams	= array( 'rank'	=>	'newest');
		$config		= F::build( 'WikiaSearchConfig', array( $newParams ) );
		
		$this->assertEquals(
				'newest',
				$config->getRank(), 
				'Parameters passed during construction with a key equal to a default parameter should be overwritten.'
		);
	}
	
	/**
	 * @covers WikiaSearchConfig::__call
	 */
	public function testMagicMethods() {
		
		$config = F::build( 'WikiaSearchConfig' );
		
		$this->assertNull( 
				$config->getValueThatDoesntExist(), 
				'An accessor method value that has not been set should return null.' 
		);
		$this->assertInstanceOf(
				'WikiaSearchConfig',
				$config->setValueThatDoesntExist( true ), 
				'A dynamic mutator method should provide a fluent interface.'
		);
		$this->assertTrue(
				$config->getValueThatDoesntExist(),
				'A dynamic accessor method that has had its value set should return that value.'
		);
		$this->assertEquals(
				$config->getValueThatDoesntExist(),
				$config['valueThatDoesntExist'],
				'Any value set in WikiaSearchConfig should be exposed via array access.'
		);
		
		$exception = false;
		try {
			$config->thisIsAMethodIJustMadeUp();
		} catch ( Exception $exception ) { }
		
		$this->assertInstanceOf(
				'BadMethodCallException',
				$exception
		);
	}
	
	/**
	 * @covers WikiaSearchConfig::offsetExists
	 * @covers WikiaSearchConfig::offsetGet
	 * @covers WikiaSearchConfig::offsetSet
	 * @covers WikiaSearchConfig::offsetUnset
	 */
	public function testArrayAccessMethods() {
		
		$config = F::build( 'WikiaSearchConfig' );
		
		$this->assertNull(
		        $config['valueThatDoesntExist'],
		        'Array access for an unknown key should return null.'
		);
		
		$config['valueThatDoesntExist'] = true;
		
		$this->assertTrue(
				$config['valueThatDoesntExist'],
				'Array access value setting should result in future array access returning the assigned value.'
		);
		
		if ( isset( $config['valueThatDoesntExist'] ) ) {
			unset($config['valueThatDoesntExist']);
		}
		
		$this->assertNull(
		        $config['valueThatDoesntExist'],
		        'Unsetting an array key for a value should result in it returning null in future access.'
		);
	}
	
	/**
	 * @covers WikiaSearchConfig::getSize
	 * @covers WikiaSearchConfig::getLength
	 * @covers WikiaSearchConfig::getLimit
	 * @covers WikiaSearchConfig::setLimit
	 */
	public function testGetSize() {
		
		$config = F::build( 'WikiaSearchConfig' );

		$this->assertEquals(
		        WikiaSearchConfig::RESULTS_PER_PAGE,
		        $config->getLength(),
		        'WikiaSearchConfig getLength should default to constant WikiaSearchConfig::RESULTS_PER_PAGE.'
		);
		$this->assertEquals(
				$config->getSize(),
				$config->getLength(),
				'WikiaSearchConfig getSize and getLength methods should be synonymous.'
		);
		$this->assertEquals(
				$config->getSize(),
				$config->getLimit(),
				'WikiaSearchConfig getSize and getLimit methods should be synonymous without an article match.'	
		);
		
		$mockTitle			= $this->getMock( 'Title' );
		$mockArticle		= $this->getMock( 'Article', array(), array( $mockTitle ) );
		$mockArticleMatch	= $this->getMock( 'WikiaSearchArticleMatch', array(), array( $mockArticle ) );
		
		$limit = $config->getLimit();
		
		$config	->setArticleMatch	( $mockArticleMatch )
				->setStart			( 0 );
		
		$this->assertEquals(
				WikiaSearchConfig::RESULTS_PER_PAGE - 1,
				$config->getLength(),
				'A stored article match in WikiaSearchConfig should result in reducing the length value by 1 if start=0.'
		);
		$this->assertEquals(
				$limit,
				$config->getLimit(),
				'The return value of WikiaSearchConfig::getLimit should not mutate regardless of article match if start=0.'
		);
		$this->assertEquals(
		        $config->getSize(),
		        $config->getLength(),
		        'WikiaSearchConfig getSize and getLength methods should be synonymous, even with article match at start=0.'
		);
		$this->assertNotEquals(
				$config->getLimit(),
				$config->getLength(),
				'WikiaSearchConfig::getLimit and WikiaSearchConfig::getLength should not be equal if we have an article match at start=0.'
		);
		
		$config->setStart( 10 );
		
		$this->assertEquals(
		        WikiaSearchConfig::RESULTS_PER_PAGE,
		        $config->getLength(),
		        'A stored article match in WikiaSearchConfig should not result in reducing the length value by 1 if start != 0.'
		);
		$this->assertEquals(
		        $limit,
		        $config->getLimit(),
		        'The return value of WikiaSearchConfig::getLimit should not mutate regardless of article match or start.'
		);
		$this->assertEquals(
		        $config->getSize(),
		        $config->getLength(),
		        'WikiaSearchConfig getSize and getLength methods should be synonymous, even with article match, regardless of start.'
		);
		$this->assertEquals(
		        $config->getLimit(),
		        $config->getLength(),
		        'WikiaSearchConfig::getLimit and WikiaSearchConfig::getLength should be equal if we have an article match at start > 0.'
		);
		$newLimit = 20;
		$this->assertEquals(
				$config,
				$config->setLimit( $newLimit ),
				'WikiaSearchConfig::setLimit should provide fluent interface.'
		);
		$this->assertEquals(
				$newLimit,
				$config->getLimit(),
				'Setting a limit should return that value when calling getLimit.'
		);
		$this->assertEquals(
				$newLimit,
				$config->getLength(),
				'Setting a limit should set the same key used by size and length methods.'
		);
	}
	
	/**
	 * @covers WikiaSearchConfig::setQuery
	 * @covers WikiaSearchConfig::getQuery
	 * @covers WikiaSearchConfig::getNamespaces
	 * @covers WikiaSearchConfig::getQueryNoQuotes
	 */
	public function testQueryAndNamespaceMethods() {

		$config = F::build( 'WikiaSearchConfig' );
		$noNsQuery			= 'foo';
		$nsQuery			= 'File:foo';
		
		$searchEngineMock	= $this->getMock( 'SearchEngine', array( 'DefaultNamespaces' ), array() );

		$expectedDefaultNamespaces = array( NS_MAIN );
		
		$searchEngineMock
			->staticExpects	( $this->any() )
			->method		( 'DefaultNamespaces' )
			->will			( $this->returnValue( $expectedDefaultNamespaces ) )
		;
		
		$this->mockClass( 'SearchEngine',	$searchEngineMock );
		$this->mockApp();
		F::setInstance( 'SearchEngine', $searchEngineMock );
		
		$originalNamespaces = $config->getNamespaces();
		$this->assertEquals(
				$expectedDefaultNamespaces,
				$originalNamespaces,
				'WikiaSearchConfig::getNamespaces should return SearchEngine::DefaultNamespaces if namespaces are not initialized.'
		);
		$this->assertFalse( $config->getQuery(), 'WikiaSearchConfig::getQuery should return false if the query has not been set.');
		$this->assertEquals(
				$config,
				$config->setQuery( $noNsQuery ),
				'WikiaSearchConfig::setQuery should provide a fluent interface'
		);
		$this->assertEquals(
				$noNsQuery,
				$config->getQuery(),
				'Calling setQuery for a basic query should store the query value, accessible using getQuery.'
		);
		$this->assertEquals(
				$config->getQuery(),
				$config->getOriginalQuery(),
				'The original query and the actual query should match for non-namespaced queries.'
		);
		$this->assertEquals(
				$originalNamespaces,
				$config->getNamespaces(),
				'A query without a valid namespace prefix should not mutate the namespaces stored in the search config.'
		);
		$this->assertEquals(
				$config,
				$config->setQuery( $nsQuery ),
				'WikiaSearchConfig::setQuery should provide a fluent interface'
		);
		$this->assertEquals(
		        $nsQuery,
		        $config->getOriginalQuery(),
		        'The original query should be stored under the "originalQuery" key regardless of prefix.'
		);
		$this->assertEquals(
				$noNsQuery,
				$config->getQuery(),
				'The namespace prefix for a query should be stripped from the main query value.'
		);
		$this->assertNotEquals(
		        $config->getQuery(),
		        $config->getOriginalQuery(),
		        'The actual query and the original query should not be equivalent when passed a valid namespace prefix query.'
		);
		$this->assertEquals(
		        array_merge( $originalNamespaces, array( NS_FILE ) ),
		        $config->getNamespaces(),
		        'Setting a namespace-prefixed query should result in the appropriate namespace being appended.'
		);
		$tildeQuery = 'foo~';
		$this->assertEquals(
				'foo\~',
				$config->setQuery( $tildeQuery )->getQuery(),
				'A query with a tilde should be escaped in getQuery.'
		);
		$quoteQuery = '"foo bar"';
		$this->assertEquals(
				'\"foo bar\"',
				$config->setQuery( $quoteQuery )->getQuery(),
				'A query with quotes should have the quotes escaped by default in getQuery.'
		);
		$this->assertEquals(
		        '"foo bar"',
		        $config->setQuery( $quoteQuery )->getQuery( true ),
		        'A query with quotes should have its quotes left alone if the first parameter of getQuery is passed as true.'
		);
		$this->assertEquals(
				'foo bar',
				$config->setQuery( $quoteQuery )->getQueryNoQuotes(),
				'A query with double quotes should have its quotes stripped in the default versoin of getQueryNoQuotes.'
		);
		$this->assertEquals(
		        'foo bar\~',
		        $config->setQuery( $quoteQuery.'~' )->getQueryNoQuotes(),
		        'Tildes should be escaped in the default versoin of getQueryNoQuotes.'
		);
		$this->assertEquals(
		        'foo bar~',
		        $config->setQuery( $quoteQuery.'~' )->getQueryNoQuotes( true ),
		        'Tildes should not be escaped in the raw versoin of getQueryNoQuotes.'
		);
		
		$xssQuery = "foo'<script type='javascript'>alert('xss');</script>";
		$this->assertEquals(
				"foo'alert\\('xss'\\);",
				$config->setQuery( $xssQuery )->getQuery(),
				'Setting a query should result in the sanitization and html entity decoding of that query.'
		);
		$this->assertEquals(
				"foo alert\\(xss\\);",
				$config->getQueryNoQuotes(),
				"Queries with quotes or apostrophes between two letters should be replaced with spaces with getQueryNoQuotes."
		);

		$htmlEntityQuery = "'foo & bar &amp; baz' &quot;";
		$this->assertEquals(
				"'foo & bar & baz' \\\"",
				$config->setQuery( $htmlEntityQuery )->getQuery(),
				"HTML entities in queries should be decoded when being set."
		);
		$this->assertEquals(
		        $config->setQuery( $htmlEntityQuery )->getQuery( WikiaSearchConfig::QUERY_DEFAULT ),
		        $config->setQuery( $htmlEntityQuery )->getQuery(),
		        "The default behavior of the getQuery method should be identical to passing the WikiaSearchConfig::QUERY_DEFAULT constant."
		);
		
		$this->assertEquals(
		        "'foo & bar & baz' \"",
		        $config->setQuery( $htmlEntityQuery )->getQuery( WikiaSearchConfig::QUERY_RAW ),
		        "HTML entities in queries should be decoded when being set. Raw-strategy queries shouldn't escape anything."
		);
		$this->assertEquals(
		        "'foo &amp; bar &amp; baz' &quot;",
		        $config->setQuery( $htmlEntityQuery )->getQuery( WikiaSearchConfig::QUERY_ENCODED ),
		        "HTML entities in queries should be decoded when being set. HTML-decoded queries should properly HTML-encode all entities on access if using encoded strategy."
		);
		
		$utf8Query = '"аВатаР"';
		$this->assertEquals(
				'\"аВатаР\"',
				$config->setQuery( $utf8Query )->getQuery( WikiaSearchConfig::QUERY_DEFAULT ),
				'WikiaSearch::setQuery should not unnecessarily mutate UTF-8 characters. Retrieving them should return those characters, properly encoded.'
		);
		$this->assertEquals(
				'"аВатаР"',
				$config->setQuery( $utf8Query )->getQuery( WikiaSearchConfig::QUERY_RAW ),
				'WikiaSearch::getQuery() should not unnecessarily mutate UTF-8 characters, and should not escape quotes when asking for raw query.'
		);
		$this->assertEquals(
		        htmlentities( '"аВатаР"', ENT_COMPAT, 'UTF-8' ),
		        $config->setQuery( $utf8Query )->getQuery( WikiaSearchConfig::QUERY_ENCODED ),
		        'WikiaSearch::getQuery() should properly HTML-encode UTF-8 characters when using the encoded query strategy.'
		);
		
		$config->setQuery( 'foo bar wiki' );
		$config->setIsInterWiki( true );
		
		$this->assertEquals(
				'foo bar',
				$config->getQuery(),
				'WikiaSearch::getQuery() should strip the term "wiki" from the set query if the search is interwiki'
		);
		
	}
	
	/**
	 * @covers WikiaSearchConfig::getSort
	 */
	public function testGetSort() {
		$config = F::build( 'WikiaSearchConfig' );
		
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
	}
	
	/**
	 * @covers WikiaSearchConfig::hasArticleMatch
	 * @covers WikiaSearchConfig::setArticleMatch
	 * @covers WikiaSearchConfig::getArticleMatch
	 */
	public function testArticleMatching() {
		$mockTitle			= $this->getMock( 'Title' );
		$mockArticle		= $this->getMock( 'Article', array(), array( $mockTitle ) );
		$mockArticleMatch	= $this->getMock( 'WikiaSearchArticleMatch', array(), array( $mockArticle ) );
		$config				= F::build( 'WikiaSearchConfig' );
		
		$this->assertFalse(
				$config->hasArticleMatch(),
				'WikiaSearchConfig should not have an article match by default.'
		);
		$this->assertNull(
				$config->getArticleMatch(),
				'WikiaSearchConfig should return null when getting an uninitialized article match'
		);
		$this->assertEquals(
				$config,
				$config->setArticleMatch( $mockArticleMatch ),
				'WikiaSearchConfig::setArticleMatch should provide a fluent interface.'
		);
		$this->assertEquals(
				$mockArticleMatch,
				$config->getArticleMatch(),
				'WikiaSearchConfig::getArticleMatch should return the appropriate article match once set.'
		);
	}
	
	/**
	 * @covers WikiaSearchConfig::isInterWiki
	 * @covers WikiaSearchConfig::setIsInterWiki
	 * @covers WikiaSearchConfig::getIsInterWiki
	 */
	public function testInterWiki() {
		$config	= F::build( 'WikiaSearchConfig' );
		
		$this->assertFalse(
				$config->getIsInterWiki() || $config->getInterWiki() || $config->getIsInterWiki(),
				'Interwiki accessor methods should be false by default.'
		);
		$this->assertEquals(
				$config,
				$config->setIsInterWiki( true ),
				'WikiaSearch::setIsInterWiki should provide fluent interface.'
		);
		$this->assertTrue(
				$config->getIsInterWiki() && $config->getInterWiki() && $config->isInterWiki(),
				'Interwiki accessor methods should always have the same value, regardless of previous mutated state.'
		);
	}
	
	/**
	 * @covers WikiaSearchconfig::getTruncatedResultsNum
	 */
	public function testTruncatedResultsNum() {
		$config	= F::build( 'WikiaSearchConfig' );
		
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
	}
	
	/**
	 * @covers WikiaSearchConfig::getNumPages
	 */
	public function testGetNumPages() {
		$config = F::build( 'WikiaSearchConfig' );
		
		$this->assertEquals(
				0,
				$config->getNumPages(),
				'Number of pages should default to zero.'
		);
		
		$numFound = 50;
		$config->setResultsFound( $numFound );
		
		$this->assertEquals(
				ceil( $numFound / WikiaSearchConfig::RESULTS_PER_PAGE ),
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
	 * @covers WikiaSearchConfig::getCityId
	 * @covers WikiaSearchConfig::setCityID
	 */
	public function testGetCityId() {
		$config = F::build( 'WikiaSearchConfig' );
		
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
	
}