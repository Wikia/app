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
		
		unset($config['valueThatDoesntExist']);
		
		$this->assertNull(
		        $config['valueThatDoesntExist'],
		        'Unsetting an array key for a value should result in it returning null in future access.'
		);
	}
	
	/**
	 * @covers WikiaSearchConfig::getSize
	 * @covers WikiaSearchConfig::getLength
	 * @covers WikiaSearchConfig::getLimit
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
	}
	
	/**
	 * @covers WikiaSearchConfig::setQuery
	 * @covers WikiaSearchConfig::getNamespaces
	 */
	public function testSetQueryAndGetNamespaces() {
		
		$config = F::build( 'WikiaSearchConfig' );
		$noNsQuery			= 'foo';
		$nsQuery			= 'File:foo';
		
		$searchEngineMock	= $this->getMock( 'stdClass', array( 'DefaultNamespaces' ), array(), 'SearchEngine' );
		$mwNamespaceMock	= $this->getMock( 'stdClass', array( 'getCanonicalIndex' ), array(), 'MWNamespace' );

		$expectedDefaultNamespaces = array( NS_MAIN );
		
		$searchEngineMock
			->expects	( $this->any() )
			->method	( 'DefaultNamespaces' )
			->will		( $this->returnValue( $expectedDefaultNamespaces ) )
		;
		$mwNamespaceMock
			->expects	( $this->at(0) )
			->method	( 'getCanonicalIndex' )
			->with		( $noNsQuery )
			->will		( $this->returnValue( null ) )
		;
		$mwNamespaceMock
			->expects	( $this->at(1) )
			->method	( 'getCanonicalIndex' )
			->with		( array_shift( explode( ':', strtolower($nsQuery ) ) ) )
			->will		( $this->returnValue( NS_FILE ) )
		;
		
		$this->mockClass( 'SearchEngine',	$searchEngineMock );
		$this->mockClass( 'MWNamespace',	$mwNamespaceMock );
		$this->mockApp();
		F::setInstance	( 'MWNamespace', 	$mwNamespaceMock );
		
		$originalNamespaces = $config->getNamespaces();
		$this->assertEquals(
				$expectedDefaultNamespaces,
				$originalNamespaces,
				'WikiaSearchConfig::getNamespaces should return SearchEngine::DefaultNamespaces if namespaces are not initialized.'
		);
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
}