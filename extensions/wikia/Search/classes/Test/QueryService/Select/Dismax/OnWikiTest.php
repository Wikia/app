<?php
/**
 * Class definition for Wikia\Search\Test\QueryService\Select\Dismax\OnWiki
 */
namespace Wikia\Search\QueryService\Select\Dismax;
use Wikia, ReflectionProperty, ReflectionMethod;
/**
 * Tests on-wiki search functionality
 */
class OnWikiTest extends Wikia\Search\Test\BaseTest { 
	
	/**
	 * @group Slow
	 * @slowExecutionTime 0.1058 ms
	 * @covers Wikia\Search\QueryService\Select\Dismax\OnWiki::extractMatch
	 */
	public function testExtractMatch() {
		
		$mockService = $this->getMockBuilder( 'Wikia\Search\MediaWikiService' )
		                      ->disableOriginalConstructor()
		                      ->setMethods( array( 'getArticleMatchForTermAndNamespaces', 'getWikiMatchByHost', 'getGlobal' ) )
		                      ->getMock();
		
		$mockConfig = $this->getMockBuilder( 'Wikia\Search\Config' )
		                   ->setMethods( array( 'getQuery', 'getNamespaces', 'setArticleMatch', 'getMatch', 'setWikiMatch' ) )
		                   ->getMock();
		
		$mockQuery = $this->getMock( 'Wikia\Search\Query\Select', array( 'getSanitizedQuery' ), array( 'foo' ) );
		
		$mockSelect = $this->getMockBuilder( 'Wikia\Search\QueryService\Select\Dismax\OnWiki' )
		                   ->disableOriginalConstructor()
		                   ->setMethods(  [ 'extractWikiMatch', 'getConfig', 'getService' ] )
		                   ->getMock();
		
		$mockMatch = $this->getMockBuilder( 'Wikia\Search\Match\Article' )
		                  ->disableOriginalConstructor()
		                  ->getMock();
		
		$mockWikiMatch = $this->getMockBuilder( 'Wikia\Search\Match\Wiki' )
		                      ->disableOriginalConstructor()
		                      ->getMock();
		
		$mockSelect
		    ->expects( $this->once() )
		    ->method ( 'getConfig' )
		    ->will   ( $this->returnValue( $mockConfig ) )
		;
		$mockSelect
		    ->expects( $this->once() )
		    ->method ( 'getService' )
		    ->will   ( $this->returnValue( $mockService ) )
		;
		$mockConfig
		    ->expects( $this->once() )
		    ->method ( 'getQuery' )
		    ->will   ( $this->returnValue( $mockQuery ) )
	    ;
		$mockQuery
		    ->expects( $this->once() )
		    ->method ( 'getSanitizedQuery' )
		    ->will   ( $this->returnValue( 'star wars' ) )
		;
		$mockConfig
		    ->expects( $this->once() )
		    ->method ( 'getNamespaces' )
		    ->will   ( $this->returnValue( array( 0, 14 ) ) )
		;
		$mockService
		    ->expects( $this->once() )
		    ->method ( 'getArticleMatchForTermAndNamespaces' )
		    ->with   ( 'star wars', array( 0, 14 ) )
		    ->will   ( $this->returnValue( $mockMatch ) )
		;
		$mockConfig
		    ->expects( $this->once() )
		    ->method ( 'setArticleMatch' )
		    ->with   ( $mockMatch )
		;
		$mockService
		    ->expects( $this->once() )
		    ->method ( 'getGlobal' )
		    ->with   ( 'OnWikiSearchIncludesWikiMatch' )
		    ->will   ( $this->returnValue( true ) )
		;
		$mockSelect
		    ->expects( $this->once() )
		    ->method ( 'extractWikiMatch' )
		    ->will   ( $this->returnValue( $mockWikiMatch ) )
		;
		$mockConfig
		    ->expects( $this->once() )
		    ->method ( 'getMatch' )
		    ->will   ( $this->returnValue( $mockMatch ) )
		;
		$this->assertEquals(
				$mockMatch,
				$mockSelect->extractMatch()
		);
	}
	
	/**
	 * @group Slow
	 * @slowExecutionTime 0.09931 ms
	 * @covers Wikia\Search\QueryService\Select\Dismax\OnWiki::registerNonDismaxComponents
	 */
	public function testRegisterNonDismaxComponents() {
		$mockQuery = $this->getMockBuilder( '\Solarium_Query_Select' )
		                  ->disableOriginalConstructor()
		                  ->getMock();
		
		$selectMethods = array( 'registerHighlighting', 'registerFilterQueries', 'registerSpellcheck', 'registerDismax' );
		$mockSelect = $this->getMockBuilder( 'Wikia\Search\QueryService\Select\Dismax\OnWiki' )
		                   ->disableOriginalConstructor()
		                   ->setMethods( $selectMethods )
		                   ->getMock();
		
		$mockSelect
		    ->expects( $this->once() )
		    ->method ( 'registerHighlighting' )
		    ->with   ( $mockQuery )
		    ->will   ( $this->returnValue( $mockSelect ) )
		;
		$mockSelect
		    ->expects( $this->once() )
		    ->method ( 'registerFilterQueries' )
		    ->with   ( $mockQuery )
		    ->will   ( $this->returnValue( $mockSelect ) )
		;
		$mockSelect
		    ->expects( $this->once() )
		    ->method ( 'registerSpellcheck' )
		    ->with   ( $mockQuery )
		    ->will   ( $this->returnValue( $mockSelect ) )
		;
		$register = new ReflectionMethod( 'Wikia\Search\QueryService\Select\Dismax\OnWiki', 'registerNonDismaxComponents' );
		$register->setAccessible( true );
		$this->assertEquals(
				$mockSelect,
				$register->invoke( $mockSelect, $mockQuery )
		);
	}
	
	/**
	 * @group Slow
	 * @slowExecutionTime 0.10161 ms
	 * @covers Wikia\Search\QueryService\Select\Dismax\OnWiki::registerFilterQueryForMatch
	 */
	public function testRegisterFilterQueryForMatch() {
		$mockConfig = $this->getMock( 'Wikia\Search\Config', array( 'hasArticleMatch', 'getArticleMatch', 'setFilterQuery' ) );
		$mockMatch = $this->getMockBuilder( 'Wikia\Search\Match\Article' )
		                  ->disableOriginalConstructor()
		                  ->setMethods( array( 'getResult' ) )
		                  ->getMock();
		$mockResult = $this->getMockBuilder( 'Wikia\Search\Result' )
		                   ->setMethods( array( 'getVar' ) )
		                   ->getMock();
		
		$dc = new Wikia\Search\QueryService\DependencyContainer( array( 'config' => $mockConfig ) );
		$mockSelect = $this->getMockBuilder( 'Wikia\Search\QueryService\Select\Dismax\OnWiki' )
		                   ->setConstructorArgs( array( $dc ) )
		                   ->setMethods( null )
		                   ->getMock();
		
		$mockConfig
		    ->expects( $this->once() )
		    ->method ( 'hasArticleMatch' )
		    ->will   ( $this->returnValue( true ) )
		;
		$mockConfig
		    ->expects( $this->once() )
		    ->method ( 'getArticleMatch' )
		    ->will   ( $this->returnValue( $mockMatch ) )
		;
		$mockMatch
		    ->expects( $this->once() )
		    ->method ( 'getResult' )
		    ->will   ( $this->returnValue( $mockResult ) )
		;
		$mockResult
		    ->expects( $this->once() )
		    ->method ( 'getVar' )
		    ->with   ( 'id' )
		    ->will   ( $this->returnValue( 123 ) )
		;
		$mockConfig
		    ->expects( $this->once() )
		    ->method ( 'setFilterQuery' )
		    ->with   ( Wikia\Search\Utilities::valueForField( 'id', 123, array( 'negate' => true ) ), 'ptt' )
		;
		$register = new ReflectionMethod( 'Wikia\Search\QueryService\Select\Dismax\OnWiki', 'registerFilterQueryForMatch' );
		$register->setAccessible( true );
		$this->assertEquals(
				$mockSelect,
				$register->invoke( $mockSelect )
		);
	}
	
	/**
	 * @group Slow
	 * @slowExecutionTime 0.1173 ms
	 * @covers Wikia\Search\QueryService\Select\Dismax\OnWiki::registerSpellcheck
	 */
	public function testRegisterSpellcheck() {
		$mockQuery = $this->getMockBuilder( '\Solarium_Query_Select' )
		                  ->disableOriginalConstructor()
		                  ->setMethods( array( 'getSpellcheck' ) )
		                  ->getMock();
		$spellcheckMethods = array(
				'setQuery', 'setCollate', 'setCount', 'setMaxCollationTries', 'setMaxCollations',
				'setExtendedResults', 'setCollateParam', 'setOnlyMorePopular', 'setCollateExtendedResults'
				);
		$mockSpellcheck = $this->getMockBuilder( '\Solarium_Query_Select_Component_Spellcheck' )
		                       ->disableOriginalConstructor()
		                       ->setMethods( $spellcheckMethods )
		                       ->getMock();
		$mockService = $this->getMockBuilder( 'Wikia\Search\MediaWikiService' )
		                      ->disableOriginalConstructor()
		                      ->setMethods( array( 'getGlobal' ) )
		                      ->getMock();
		$mockConfig = $this->getMock( 'Wikia\Search\Config', array( 'getQuery', 'getCityId'  ) );
		$mockQueryWrapper = $this->getMock( 'Wikia\Search\Query\Select', array( 'getSanitizedQuery' ), array( 'foo' ) );
		
		$dc = new Wikia\Search\QueryService\DependencyContainer( array( 'service' => $mockService, 'config' => $mockConfig ) );
		$mockSelect = $this->getMockBuilder( 'Wikia\Search\QueryService\Select\Dismax\OnWiki' )
		                   ->setConstructorArgs( array( $dc ) )
		                   ->setMethods( null )
		                   ->getMock();
		
		$mockService
		    ->expects( $this->once() )
		    ->method ( 'getGlobal' )
		    ->with   ( 'WikiaSearchSpellcheckActivated' )
		    ->will   ( $this->returnValue( true ) )
		;
		$mockQuery
		    ->expects( $this->once() )
		    ->method ( 'getSpellcheck' )
		    ->will   ( $this->returnValue( $mockSpellcheck ) )
	    ;
		$mockConfig
		    ->expects( $this->once() )
		    ->method ( 'getQuery' )
		    ->will   ( $this->returnValue( $mockQueryWrapper ) )
	    ;
		$mockQueryWrapper
		    ->expects( $this->once() )
		    ->method ( 'getSanitizedQuery' )
		    ->will   ( $this->returnValue( 'foo' ) )
		;
		$mockSpellcheck
		    ->expects( $this->once() )
		    ->method ( 'setQuery' )
		    ->with   ( 'foo' )
		    ->will   ( $this->returnValue( $mockSpellcheck ) )
		;
		$mockSpellcheck
		    ->expects( $this->once() )
		    ->method ( 'setCollate' )
		    ->with   ( true )
		    ->will   ( $this->returnValue( $mockSpellcheck ) )
		;
		$mockSpellcheck
		    ->expects( $this->once() )
		    ->method ( 'setCount' )
		    ->with   ( Wikia\Search\QueryService\Select\Dismax\OnWiki::SPELLING_RESULT_COUNT )
		    ->will   ( $this->returnValue( $mockSpellcheck ) )
		;
		$mockSpellcheck
		    ->expects( $this->once() )
		    ->method ( 'setMaxCollationTries' )
		    ->with   ( Wikia\Search\QueryService\Select\Dismax\OnWiki::SPELLING_MAX_COLLATION_TRIES )
		    ->will   ( $this->returnValue( $mockSpellcheck ) )
		;
		$mockSpellcheck
		    ->expects( $this->once() )
		    ->method ( 'setMaxCollations' )
		    ->with   ( Wikia\Search\QueryService\Select\Dismax\OnWiki::SPELLING_MAX_COLLATIONS )
		    ->will   ( $this->returnValue( $mockSpellcheck ) )
		;
		$mockSpellcheck
		    ->expects( $this->once() )
		    ->method ( 'setExtendedResults' )
		    ->with   ( true )
		    ->will   ( $this->returnValue( $mockSpellcheck ) )
		;
		$mockConfig
		    ->expects( $this->once() )
		    ->method ( 'getCityId' )
		    ->will   ( $this->returnValue( 123 ) )
		;
		$mockSpellcheck
		    ->expects( $this->once() )
		    ->method ( 'setCollateParam' )
		    ->with   ( 'fq', 'is_content:true AND wid:123' )
		    ->will   ( $this->returnValue( $mockSpellcheck ) )
		;
		$mockSpellcheck
		    ->expects( $this->once() )
		    ->method ( 'setOnlyMorePopular' )
		    ->with   ( true )
		    ->will   ( $this->returnValue( $mockSpellcheck ) )
		;
		$mockSpellcheck
		    ->expects( $this->once() )
		    ->method ( 'setCollateExtendedResults' )
		    ->with   ( true )
		    ->will   ( $this->returnValue( $mockSpellcheck ) )
		;
		$register = new ReflectionMethod( 'Wikia\Search\QueryService\Select\Dismax\OnWiki', 'registerSpellcheck' );
		$register->setAccessible( true );
		$this->assertEquals(
				$mockSelect,
				$register->invoke( $mockSelect, $mockQuery )
		);
	}
	
	/**
	 * @group Slow
	 * @slowExecutionTime 0.10199 ms
	 * @covers Wikia\Search\QueryService\Select\Dismax\OnWiki::getQueryFieldsString
	 */
	public function testGetQueryFieldsString() {
		$mockConfig = $this->getMock( 'Wikia\Search\Config', array( 'getQueryFieldsToBoosts' ) );
		$dc = new Wikia\Search\QueryService\DependencyContainer( array( 'config' => $mockConfig ) );
		$mockSelect = $this->getMockBuilder( 'Wikia\Search\QueryService\Select\Dismax\OnWiki' )
		                   ->setConstructorArgs( array( $dc ) )
		                   ->setMethods( array() )
		                   ->getMock();
		
		$mockConfig
		    ->expects( $this->once() )
		    ->method ( 'getQueryFieldsToBoosts' )
		    ->will   ( $this->returnValue( array( 'foo' => 5, 'bar' => 10 ) ) )
		;
		$get = new ReflectionMethod( 'Wikia\Search\QueryService\Select\Dismax\OnWiki', 'getQueryFieldsString' );
		$get->setAccessible( true );
		$this->assertEquals(
				'foo^5 bar^10',
				$get->invoke( $mockSelect )
		);
	}
	
	/**
	 * @group Slow
	 * @slowExecutionTime 0.09878 ms
	 * @covers Wikia\Search\QueryService\Select\Dismax\OnWiki::getQueryClausesString
	 */
	public function testGetQueryClausesString() {
		$this->_testGetQueryClausesStringArgs( null );
		$this->_testGetQueryClausesStringArgs( true );
		$this->_testGetQueryClausesStringArgs( false );
	}

	protected function _testGetQueryClausesStringArgs( $mainPage ) {
		$mockConfig = $this->getMock( 'Wikia\Search\Config', array( 'getCityId', 'getNamespaces', 'getPageId', 'getMainPage' ) );
		$dc = new Wikia\Search\QueryService\DependencyContainer( array( 'config' => $mockConfig ) );
		$mockSelect = $this->getMockBuilder( 'Wikia\Search\QueryService\Select\Dismax\OnWiki' )
		                   ->setConstructorArgs( array( $dc ) )
		                   ->setMethods( null )
		                   ->getMock();
		
		$mockConfig
		    ->expects( $this->once() )
		    ->method ( 'getCityId' )
		    ->will   ( $this->returnValue( 123 ) )
		;
		$mockConfig
			->expects( $this->once() )
			->method ( 'getPageId' )
			->will   ( $this->returnValue( 88 ) )
		;
		$mockConfig
		    ->expects( $this->once() )
		    ->method ( 'getNamespaces' )
		    ->will   ( $this->returnValue( array( 0, 14 ) ) )
		;
		$mockConfig
			->expects( $this->once() )
			->method( 'getMainPage' )
			->will( $this->returnValue( $mainPage ) );

		$method = new ReflectionMethod( 'Wikia\Search\QueryService\Select\Dismax\OnWiki', 'getQueryClausesString' );
		$method->setAccessible( true );
		if ( $mainPage === null ) {
			$expected = '((wid:123) AND (pageid:88) AND ((ns:0) OR (ns:14)))';
		} elseif ( $mainPage == true ) {
			$expected = '((wid:123) AND (pageid:88) AND ((ns:0) OR (ns:14)) AND (+is_main_page:true))';
		} else {
			$expected = '((wid:123) AND (pageid:88) AND ((ns:0) OR (ns:14)) AND (+is_main_page:false))';
		}

		$this->assertEquals( $expected, $method->invoke( $mockSelect ) );
	}
	
	/**
	 * @group Slow
	 * @slowExecutionTime 0.09852 ms
	 * @covers Wikia\Search\QueryService\Select\Dismax\OnWiki::getFilterQueryString
	 */
	public function testGetFilterQueryString() {
		$mockConfig = $this->getMock( 'Wikia\Search\Config', array( 'getCityId', 'getNamespaces', 'getMinArticleQuality' ) );
		$dc = new \Wikia\Search\QueryService\DependencyContainer( array( 'config' => $mockConfig ) ); 
		$mockSelect = $this->getMockBuilder( '\Wikia\Search\QueryService\Select\Dismax\OnWiki' )
		                   ->setConstructorArgs( array( $dc ) )
		                   ->setMethods( array( null ) )
		                   ->getMockForAbstractClass();
		$mockConfig
		    ->expects( $this->once() )
		    ->method ( 'getCityId' )
		    ->will   ( $this->returnValue( 123 ) )
		;
		$mockConfig
		    ->expects( $this->once() )
		    ->method ( 'getNamespaces' )
		    ->will   ( $this->returnValue( [ 0, 14 ] ) )
		;
		$mockConfig
			->expects( $this->once() )
			->method ( 'getMinArticleQuality' )
			->will   ( $this->returnValue( 13 ) )
		;

		$reflspell = new ReflectionMethod( 'Wikia\Search\QueryService\Select\Dismax\OnWiki', 'getFilterQueryString' );
		$reflspell->setAccessible( true );
		$this->assertEquals(
				'((ns:0) OR (ns:14)) AND (wid:123) AND (article_quality_i:[13 TO *])',
				$reflspell->invoke( $mockSelect )
		);
	}
}
