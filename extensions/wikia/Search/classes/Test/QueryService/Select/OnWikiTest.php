<?php
/**
 * Class definition for Wikia\Search\Test\QueryService\Select\OnWiki
 */
namespace Wikia\Search\QueryService\Select;
use Wikia, ReflectionProperty, ReflectionMethod;
/**
 * Tests on-wiki search functionality
 */
class OnWikiTest extends Wikia\Search\Test\BaseTest {
	
	/**
	 * @covers Wikia\Search\QueryService\Select\OnWiki::extractMatch
	 */
	public function testExtractMatch() {
		
		$mockService = $this->getMockBuilder( 'Wikia\Search\MediaWikiService' )
		                      ->disableOriginalConstructor()
		                      ->setMethods( array( 'getArticleMatchForTermAndNamespaces' ) )
		                      ->getMock();
		
		$mockConfig = $this->getMockBuilder( 'Wikia\Search\Config' )
		                   ->setMethods( array( 'getOriginalQuery', 'getNamespaces', 'setArticleMatch', 'getMatch' ) )
		                   ->getMock();
		
		$dc = new Wikia\Search\QueryService\DependencyContainer( array( 'service' => $mockService, 'config' => $mockConfig ) );
		$mockSelect = $this->getMockBuilder( 'Wikia\Search\QueryService\Select\OnWiki' )
		                   ->setConstructorArgs( array( $dc ) )
		                   ->setMethods( null )
		                   ->getMock();
		
		$mockMatch = $this->getMockBuilder( 'Wikia\Search\Match\Article' )
		                  ->disableOriginalConstructor()
		                  ->getMock();
		
		$mockConfig
		    ->expects( $this->once() )
		    ->method ( 'getOriginalQuery' )
		    ->will   ( $this->returnValue( 'term' ) )
		;
		$mockConfig
		    ->expects( $this->once() )
		    ->method ( 'getNamespaces' )
		    ->will   ( $this->returnValue( array( 0, 14 ) ) )
		;
		$mockService
		    ->expects( $this->once() )
		    ->method ( 'getArticleMatchForTermAndNamespaces' )
		    ->with   ( 'term', array( 0, 14 ) )
		    ->will   ( $this->returnValue( $mockMatch ) )
		;
		$mockConfig
		    ->expects( $this->once() )
		    ->method ( 'setArticleMatch' )
		    ->with   ( $mockMatch )
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
	 * @covers Wikia\Search\QueryService\Select\OnWiki::registerComponents
	 */
	public function testRegisterComponents() {
		$mockQuery = $this->getMockBuilder( '\Solarium_Query_Select' )
		                  ->disableOriginalConstructor()
		                  ->getMock();
		
		$selectMethods = array( 
				'registerQueryParams', 'registerHighlighting', 'registerFilterQueries', 
				'registerSpellcheck', 'configureQueryFields' 
				);
		$mockSelect = $this->getMockBuilder( 'Wikia\Search\QueryService\Select\OnWiki' )
		                   ->disableOriginalConstructor()
		                   ->setMethods( $selectMethods )
		                   ->getMock();
		
		$mockSelect
		    ->expects( $this->once() )
		    ->method ( 'configureQueryFields' )
		    ->will   ( $this->returnValue( $mockSelect ) )
		;
		$mockSelect
		    ->expects( $this->once() )
		    ->method ( 'registerQueryParams' )
		    ->with   ( $mockQuery )
		    ->will   ( $this->returnValue( $mockSelect ) )
		;
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
		$register = new ReflectionMethod( 'Wikia\Search\QueryService\Select\OnWiki', 'registerComponents' );
		$register->setAccessible( true );
		$this->assertEquals(
				$mockSelect,
				$register->invoke( $mockSelect, $mockQuery )
		);
	}
	
	/**
	 * @covers Wikia\Search\QueryService\Select\OnWiki::registerFilterQueryForMatch
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
		$mockSelect = $this->getMockBuilder( 'Wikia\Search\QueryService\Select\OnWiki' )
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
		$register = new ReflectionMethod( 'Wikia\Search\QueryService\Select\OnWiki', 'registerFilterQueryForMatch' );
		$register->setAccessible( true );
		$this->assertEquals(
				$mockSelect,
				$register->invoke( $mockSelect )
		);
	}
	
	/**
	 * @covers Wikia\Search\QueryService\Select\OnWiki::registerSpellcheck
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
		$mockConfig = $this->getMock( 'Wikia\Search\Config', array( 'getQueryNoQuotes', 'getCityId'  ) );
		
		$dc = new Wikia\Search\QueryService\DependencyContainer( array( 'service' => $mockService, 'config' => $mockConfig ) );
		$mockSelect = $this->getMockBuilder( 'Wikia\Search\QueryService\Select\OnWiki' )
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
		    ->method ( 'getQueryNoQuotes' )
		    ->with   ( true )
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
		    ->with   ( Wikia\Search\QueryService\Select\OnWiki::SPELLING_RESULT_COUNT )
		    ->will   ( $this->returnValue( $mockSpellcheck ) )
		;
		$mockSpellcheck
		    ->expects( $this->once() )
		    ->method ( 'setMaxCollationTries' )
		    ->with   ( Wikia\Search\QueryService\Select\OnWiki::SPELLING_MAX_COLLATION_TRIES )
		    ->will   ( $this->returnValue( $mockSpellcheck ) )
		;
		$mockSpellcheck
		    ->expects( $this->once() )
		    ->method ( 'setMaxCollations' )
		    ->with   ( Wikia\Search\QueryService\Select\OnWiki::SPELLING_MAX_COLLATIONS )
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
		$register = new ReflectionMethod( 'Wikia\Search\QueryService\Select\OnWiki', 'registerSpellcheck' );
		$register->setAccessible( true );
		$this->assertEquals(
				$mockSelect,
				$register->invoke( $mockSelect, $mockQuery )
		);
	}
	
	/**
	 * @covers Wikia\Search\QueryService\Select\OnWiki::configureQueryFields 
	 */
	public function testConfigureQueryFields() {
		$mockSelect = $this->getMockBuilder( '\Wikia\Search\QueryService\Select\OnWiki' )
		                   ->disableOriginalConstructor()
		                   ->setMethods( array() )
		                   ->getMockForAbstractClass();
		$get = new ReflectionMethod( 'Wikia\Search\QueryService\Select\OnWiki', 'configureQueryFields' );
		$get->setAccessible( true );
		$this->assertEquals(
				$mockSelect,
				$get->invoke( $mockSelect )
		);
	}
	
	/**
	 * @covers Wikia\Search\QueryService\Select\OnWiki::getQueryFieldsString 
	 */
	public function testGetQueryFieldsString() {
		$mockConfig = $this->getMock( 'Wikia\Search\Config', array( 'getQueryFieldsToBoosts' ) );
		$dc = new Wikia\Search\QueryService\DependencyContainer( array( 'config' => $mockConfig ) );
		$mockSelect = $this->getMockBuilder( 'Wikia\Search\QueryService\Select\OnWiki' )
		                   ->setConstructorArgs( array( $dc ) )
		                   ->setMethods( array() )
		                   ->getMock();
		
		$mockConfig
		    ->expects( $this->once() )
		    ->method ( 'getQueryFieldsToBoosts' )
		    ->will   ( $this->returnValue( array( 'foo' => 5, 'bar' => 10 ) ) )
		;
		$get = new ReflectionMethod( 'Wikia\Search\QueryService\Select\OnWiki', 'getQueryFieldsString' );
		$get->setAccessible( true );
		$this->assertEquals(
				'foo^5 bar^10',
				$get->invoke( $mockSelect )
		);
	}
	
	/**
	 * @covers Wikia\Search\QueryService\Select\OnWiki::getFormulatedQuery
	 */
	public function testGetFormulatedQuery() {
		$mockSelect = $this->getMockBuilder( 'Wikia\Search\QueryService\Select\OnWiki' )
		                   ->disableOriginalConstructor()
		                   ->setMethods( array( 'getQueryClausesString', 'getNestedQuery' ) )
		                   ->getMock();
		
		$mockSelect
		    ->expects( $this->once() )
		    ->method ( 'getQueryClausesString' )
		    ->will   ( $this->returnValue( 'foo' ) )
		;
		$mockSelect
		    ->expects( $this->once() )
		    ->method ( 'getNestedQuery' )
		    ->will   ( $this->returnValue( 'bar' ) )
		;
		$method = new ReflectionMethod( 'Wikia\Search\QueryService\Select\OnWiki', 'getFormulatedQuery' );
		$method->setAccessible( true );
		$this->assertEquals(
				'foo AND (bar)',
				$method->invoke( $mockSelect )
		);
	}
	
	/**
	 * @covers Wikia\Search\QueryService\Select\OnWiki::getQueryClausesString
	 */
	public function testGetQueryClausesString() {
		$mockConfig = $this->getMock( 'Wikia\Search\Config', array( 'getCityId', 'getNamespaces' ) );
		$dc = new Wikia\Search\QueryService\DependencyContainer( array( 'config' => $mockConfig ) );
		$mockSelect = $this->getMockBuilder( 'Wikia\Search\QueryService\Select\OnWiki' )
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
		    ->method ( 'getNamespaces' )
		    ->will   ( $this->returnValue( array( 0, 14 ) ) )
		;
		$method = new ReflectionMethod( 'Wikia\Search\QueryService\Select\OnWiki', 'getQueryClausesString' );
		$method->setAccessible( true );
		$this->assertEquals(
				'((wid:123) AND ((ns:0) OR (ns:14)))',
				$method->invoke( $mockSelect )
		);
	}
	
	/**
	 * @covers Wikia\Search\QueryService\Select\OnWiki::getBoostQueryString
	 */
	public function testGetBoostQueryString() {
		$mockConfig = $this->getMock( 'Wikia\Search\Config', array( 'getQueryNoQuotes' ) );
		$dc = new Wikia\Search\QueryService\DependencyContainer( array( 'config' => $mockConfig ) );
		$mockSelect = $this->getMockBuilder( 'Wikia\Search\QueryService\Select\OnWiki' )
		                   ->setConstructorArgs( array( $dc ) )
		                   ->setMethods( null )
		                   ->getMock();
		$queryNoQuotes = 'foo';
		$mockConfig
		    ->expects( $this->once() )
		    ->method ( 'getQueryNoQuotes' )
		    ->with   ( true )
		    ->will   ( $this->returnValue( $queryNoQuotes ) )
		;
		$method = new ReflectionMethod( 'Wikia\Search\QueryService\Select\OnWiki', 'getBoostQueryString' );
		$method->setAccessible( true );
		$boostQueries = array(
				Wikia\Search\Utilities::valueForField( 'html', $queryNoQuotes, array( 'boost'=>5, 'quote'=>'\"' ) ),
				Wikia\Search\Utilities::valueForField( 'title', $queryNoQuotes, array( 'boost'=>10, 'quote'=>'\"' ) ),
		);
		$this->assertEquals(
				implode( ' ', $boostQueries ),
				$method->invoke( $mockSelect )
		);
	}
}