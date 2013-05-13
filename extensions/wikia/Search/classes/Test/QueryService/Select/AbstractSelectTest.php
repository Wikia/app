<?php
/**
 * Class definition for Wikia\Search\Test\QueryService\Select\AbstractSelect
 */
namespace Wikia\Search\Test\QueryService\Select;
use Wikia, ReflectionProperty, ReflectionMethod;
/**
 * Tests core functionality shared by other Select instances
 */
class AbstractSelectTest extends Wikia\Search\Test\BaseTest {
	
	/**
	 * @covers Wikia\Search\QueryService\Select\AbstractSelect::__construct
	 */
	public function test__construct() {
		$config = new Wikia\Search\Config();
		$mockClient = $this->getMockBuilder( '\Solarium_Client' )
		                   ->disableOriginalConstructor()
		                   ->getMock();
		$dc = new Wikia\Search\QueryService\DependencyContainer( array( 'config' => $config, 'client' => $mockClient ) );
		$mockSelect = $this->getMockBuilder( 'Wikia\Search\QueryService\Select\AbstractSelect' )
		                   ->setConstructorArgs( array( $dc ) )
		                   ->getMockForAbstractClass();
		
		$this->assertAttributeInstanceOf(
				'Wikia\Search\Config',
				'config',
				$mockSelect
		);
		$this->assertAttributeInstanceOf(
				'\Solarium_Client',
				'client',
				$mockSelect
		);
		$this->assertAttributeInstanceOf(
				'Wikia\Search\ResultSet\Factory',
				'resultSetFactory',
				$mockSelect
		);
		$this->assertAttributeInstanceOf(
				'Wikia\Search\MediaWikiService',
				'service',
				$mockSelect
		);
	}
	
	/**
	 * @covers Wikia\Search\QueryService\Select\AbstractSelect::search
	 */
	public function testSearch() {
		$mockConfig = $this->getMockBuilder( 'Wikia\Search\Config' )
		                   ->setMethods( array( 'getResults' ) )
		                   ->getMock();
		$dc = new Wikia\Search\QueryService\DependencyContainer( array( 'config' => $mockConfig ) );
		$mockSelect = $this->getMockBuilder( 'Wikia\Search\QueryService\Select\AbstractSelect' )
		                   ->setConstructorArgs( array( $dc ) )
		                   ->setMethods( array( 'getMatch', 'prepareRequest', 'prepareResponse', 'sendSearchRequestToClient' ) )
		                   ->getMockForAbstractClass();
		
		$mockResponse = $this->getMockBuilder( 'Solarium_Result_Select' )
		                     ->disableOriginalConstructor()
		                     ->getMock();
		
		$mockResultSet = $this->getMockBuilder( 'Wikia\Search\ResultSet\Base' )
		                      ->disableOriginalConstructor()
		                      ->getMock();
		
		$mockSelect
		    ->expects( $this->at( 0 ) )
		    ->method ( 'getMatch' )
		;
		$mockSelect
		    ->expects( $this->at( 1 ) )
		    ->method ( 'prepareRequest' )
		    ->will   ( $this->returnValue( $mockSelect ) )
		;
		$mockSelect
		    ->expects( $this->at( 2 ) )
		    ->method ( 'sendSearchRequestToClient' )
		    ->will   ( $this->returnValue( $mockResponse ) )
		;
		$mockSelect
		    ->expects( $this->at( 3 ) )
		    ->method ( 'prepareResponse' )
		    ->will   ( $this->returnValue( $mockResponse ) )
		;
		$mockConfig
		    ->expects( $this->once() )
		    ->method ( 'getResults' )
		    ->will   ( $this->returnValue( $mockResultSet ) )
		;
		$this->assertEquals(
				$mockResultSet,
				$mockSelect->search()
		);
	}
	
	/**
	 * @covers Wikia\Search\QueryService\Select\AbstractSelect::getMatch
	 */
	public function testGetMatch() {
		$mockConfig = $this->getMockBuilder( 'Wikia\Search\Config' )
		                   ->setMethods( array( 'hasMatch', 'getMatch' ) )
		                   ->getMock();
		$dc = new Wikia\Search\QueryService\DependencyContainer( array( 'config' => $mockConfig ) );
		$mockSelect = $this->getMockBuilder( 'Wikia\Search\QueryService\Select\AbstractSelect' )
		                   ->setConstructorArgs( array( $dc ) )
		                   ->setMethods( array( 'extractMatch' ) )
		                   ->getMockForAbstractClass();
		$mockMatch = $this->getMockBuilder( 'Wikia\Search\Match\Article' )
		                  ->disableOriginalConstructor()
		                  ->getMock();

		$mockConfig
		    ->expects( $this->at( 0 ) )
		    ->method ( 'hasMatch' )
		    ->will   ( $this->returnValue( true ) )
		;
		$mockConfig
		    ->expects( $this->at( 1 ) )
		    ->method ( 'getMatch' )
		    ->will   ( $this->returnValue( $mockMatch ) )
		;
		$this->assertEquals(
				$mockMatch,
				$mockSelect->getMatch()
		);
		$mockConfig
		    ->expects( $this->at( 0 ) )
		    ->method ( 'hasMatch' )
		    ->will   ( $this->returnValue( false ) )
		;
		$mockSelect
		    ->expects( $this->at( 0 ) )
		    ->method ( 'extractMatch' )
		    ->will   ( $this->returnValue( $mockMatch ) )
		;
		$this->assertEquals(
				$mockMatch,
				$mockSelect->getMatch()
		);
	}
	
	/**
	 * @covers Wikia\Search\QueryService\Select\AbstractSelect::extractMatch
	 */
	public function testExtractMatch() {
		// using the assurance above to avoid using a reflection method
		$mockConfig = $this->getMockBuilder( 'Wikia\Search\Config' )
		                   ->setMethods( array( 'hasMatch', 'getMatch' ) )
		                   ->getMock();
		$dc = new Wikia\Search\QueryService\DependencyContainer( array( 'config' => $mockConfig ) );
		$mockSelect = $this->getMockBuilder( 'Wikia\Search\QueryService\Select\AbstractSelect' )
		                   ->setConstructorArgs( array( $dc ) )
		                   ->setMethods( array() )
		                   ->getMockForAbstractClass();
		$mockConfig
		    ->expects( $this->at( 0 ) )
		    ->method ( 'hasMatch' )
		    ->will   ( $this->returnValue( false ) )
		;
		$this->assertNull(
				$mockSelect->getMatch()
		);
	}
	
	/**
	 * @covers Wikia\Search\QueryService\Select\AbstractSelect::getSelectQuery
	 */
	public function testGetSelectQuery() {
		$mockClient = $this->getMockBuilder( '\Solarium_Client' )
		                   ->disableOriginalConstructor()
		                   ->setMethods( array( 'createSelect' ) )
		                   ->getMock();
		$dc = new Wikia\Search\QueryService\DependencyContainer( array( 'client' => $mockClient ) );
		$mockSelect = $this->getMockBuilder( '\Wikia\Search\QueryService\Select\AbstractSelect' )
		                   ->setConstructorArgs( array( $dc ) )
		                   ->setMethods( array( 'registerComponents', 'getFormulatedQuery' ) )
		                   ->getMockForAbstractClass();
		$mockQuery = $this->getMockBuilder( '\Solarium_Query_Select' )
		                  ->disableOriginalConstructor()
		                  ->setMethods( array( 'setDocumentClass', 'setQuery' ) )
		                  ->getMock();
		$mockClient
		    ->expects( $this->once() )
		    ->method ( 'createSelect' )
		    ->will   ( $this->returnValue( $mockQuery ) )
		;
		$mockQuery
		    ->expects( $this->at( 0 ) )
		    ->method ( 'setDocumentClass' )
		    ->with   ( '\Wikia\Search\Result' )
		;
		$mockSelect
		    ->expects( $this->at( 0 ) )
		    ->method ( 'registerComponents' )
		    ->with   ( $mockQuery )
		;
		$mockSelect
		    ->expects( $this->at( 1 ) )
		    ->method ( 'getFormulatedQuery' )
		    ->will   ( $this->returnValue( 'foo:bar' ) )
		;
		$mockQuery
		    ->expects( $this->once() )
		    ->method ( 'setQuery' )
		    ->with   ( 'foo:bar' )
		    ->will   ( $this->returnValue( $mockQuery ) )
		;
		$getSelect = new ReflectionMethod( 'Wikia\Search\QueryService\Select\AbstractSelect', 'getSelectQuery' );
		$getSelect->setAccessible( true );
		$this->assertEquals(
				$mockQuery,
				$getSelect->invoke( $mockSelect )
		);
	}
	
	/**
	 * @covers Wikia\Search\QueryService\Select\AbstractSelect::getBoostQueryString 
	 */
	public function testGetBoostQueryString() {
		$mockSelect = $this->getMockBuilder( '\Wikia\Search\QueryService\Select\AbstractSelect' )
		                   ->disableOriginalConstructor()
		                   ->setMethods( array() )
		                   ->getMockForAbstractClass();
		$get = new ReflectionMethod( 'Wikia\Search\QueryService\Select\AbstractSelect', 'getBoostQueryString' );
		$get->setAccessible( true );
		$this->assertEmpty(
				$get->invoke( $mockSelect )
		);
	}
	
	/**
	 * @covers Wikia\Search\QueryService\Select\AbstractSelect::registerComponents 
	 */
	public function testRegisterComponents() {
		$mockSelect = $this->getMockBuilder( '\Wikia\Search\QueryService\Select\AbstractSelect' )
		                   ->disableOriginalConstructor()
		                   ->setMethods( array() )
		                   ->getMockForAbstractClass();
		$mockQuery = $this->getMockBuilder( '\Solarium_Query_select' )
		                  ->disableOriginalConstructor()
		                  ->getMock();
		$register = new ReflectionMethod( 'Wikia\Search\QueryService\Select\AbstractSelect', 'registerComponents' );
		$register->setAccessible( true );
		$this->assertEquals(
				$mockSelect,
				$register->invoke( $mockSelect, $mockQuery )
		);
	}
	
	/**
	 * @covers Wikia\Search\QueryService\Select\AbstractSelect::registerQueryParams 
	 */
	public function testRegisterQueryParams() {
		$mockQuery = $this->getMockBuilder( '\Solarium_Query_select' )
		                  ->disableOriginalConstructor()
		                  ->setMethods( array( 'addFields', 'removeField', 'setStart', 'setRows', 'addSort', 'addParam' ) )
		                  ->getMock();
		$config = new Wikia\Search\Config();
		$dc = new Wikia\Search\QueryService\DependencyContainer( array( 'config' => $config ) );
		$mockSelect = $this->getMockBuilder( '\Wikia\Search\QueryService\Select\AbstractSelect' )
		                   ->setConstructorArgs( array( $dc ) )
		                   ->setMethods( array( null ) )
		                   ->getMockForAbstractClass();
		
		// we'll just use default values.
		$sort = $config->getSort();
		$fields = $config->getRequestedFields();
		$start = $config->getStart();
		$length = $config->getLength();
		
		$mockQuery
		    ->expects( $this->at( 0 ) )
		    ->method ( 'addFields' )
		    ->with   ( $fields )
		    ->will   ( $this->returnValue( $mockQuery ) )
		;
		$mockQuery
		    ->expects( $this->at( 1 ) )
		    ->method ( 'removeField' )
		    ->with   ( '*' )
		    ->will   ( $this->returnValue( $mockQuery ) )
		;
		$mockQuery
		    ->expects( $this->at( 2 ) )
		    ->method ( 'setStart' )
		    ->with   ( $start )
		    ->will   ( $this->returnValue( $mockQuery ) )
		;
		$mockQuery
		    ->expects( $this->at( 3 ) )
		    ->method ( 'setRows' )
		    ->with   ( $length )
		    ->will   ( $this->returnValue( $mockQuery ) )
		;
		$mockQuery
		    ->expects( $this->at( 4 ) )
		    ->method ( 'addSort' )
		    ->with   ( $sort[0], $sort[1] )
		    ->will   ( $this->returnValue( $mockQuery ) )
		;
		$mockQuery
		    ->expects( $this->at( 5 ) )
		    ->method ( 'addParam' )
		    ->with   ( 'timeAllowed', 5000 )
		    ->will   ( $this->returnValue( $mockQuery ) )
		;
		$register = new ReflectionMethod( 'Wikia\Search\QueryService\Select\AbstractSelect', 'registerQueryParams' );
		$register->setAccessible( true );
		$this->assertEquals(
				$mockSelect,
				$register->invoke( $mockSelect, $mockQuery )
		);
	}
	
	/**
	 * @covers Wikia\Search\QueryService\Select\AbstractSelect::registerFilterQueries 
	 */
	public function testRegisterFilterQueries() {
		$mockQuery = $this->getMockBuilder( '\Solarium_Query_select' )
		                  ->disableOriginalConstructor()
		                  ->setMethods( array( 'addFilterQueries' ) )
		                  ->getMock();
		$mockConfig = $this->getMockBuilder( 'Wikia\Search\Config' )
		                   ->setMethods( array( 'setFilterQuery', 'getFilterQueries' ) )
		                   ->getMock();
		$dc = new Wikia\Search\QueryService\DependencyContainer( array( 'config' => $mockConfig ) );
		$mockSelect = $this->getMockBuilder( '\Wikia\Search\QueryService\Select\AbstractSelect' )
		                   ->setConstructorArgs( array( $dc ) )
		                   ->setMethods( array( 'getFilterQueryString', 'registerFilterQueryForMatch' ) )
		                   ->getMockForAbstractClass();
		
		$mockSelect
		    ->expects( $this->at( 0 ) )
		    ->method ( 'getFilterQueryString' )
		    ->will   ( $this->returnValue( 'fqstring' )  )
		;
		$mockConfig
		    ->expects( $this->once() )
		    ->method ( 'setFilterQuery' )
		    ->with   ( 'fqstring' )
		;
		$mockSelect
		    ->expects( $this->at( 0 ) )
		    ->method ( 'registerFilterQueryForMatch' )
		;
		$mockConfig
		    ->expects( $this->once() )
		    ->method ( 'getFilterQueries' )
		    ->will   ( $this->returnValue( array( 'default' => 'fqstring' ) ) )
		;
		$mockQuery
		    ->expects( $this->once() )
		    ->method ( 'addFilterQueries' )
		    ->with   ( array( 'default' => 'fqstring' ) )
		;
		$register = new ReflectionMethod( 'Wikia\Search\QueryService\Select\AbstractSelect', 'registerFilterQueries' );
		$register->setAccessible( true );
		$this->assertEquals(
				$mockSelect,
				$register->invoke( $mockSelect, $mockQuery )
		);
	}
	
	/**
	 * @covers Wikia\Search\QueryService\Select\AbstractSelect::registerFilterQueryForMatch 
	 */
	public function testRegisterFilterQueryForMatch() {
		$mockSelect = $this->getMockBuilder( '\Wikia\Search\QueryService\Select\AbstractSelect' )
		                   ->disableOriginalConstructor()
		                   ->setMethods( array() )
		                   ->getMockForAbstractClass();
		$get = new ReflectionMethod( 'Wikia\Search\QueryService\Select\AbstractSelect', 'registerFilterQueryForMatch' );
		$get->setAccessible( true );
		$this->assertEquals(
				$mockSelect,
				$get->invoke( $mockSelect )
		);
	}
	
	/**
	 * @covers Wikia\Search\QueryService\Select\AbstractSelect::registerHighlighting 
	 */
	public function testRegisterHighlighting() {
		$mockQuery = $this->getMockBuilder( '\Solarium_Query_Select' )
		                  ->disableOriginalConstructor()
		                  ->setMethods( array( 'getHighlighting' ) )
		                  ->getMock();
		
		$hlMethods = array(
				'addField', 'setSnippets', 'setRequireFieldMatch', 'setFragSize', 
				'setSimplePrefix', 'setSimplePostfix', 'setAlternateField', 'setMaxAlternateFieldLength'
				);
		$mockHighlighting = $this->getMockBuilder( '\Solarium_Query_Select_Component_Highlighting' )
		                         ->disableOriginalConstructor()
		                         ->setMethods( $hlMethods )
		                         ->getMock();
		$mockSelect = $this->getMockBuilder( '\Wikia\Search\QueryService\Select\AbstractSelect' )
		                   ->disableOriginalConstructor()
		                   ->setMethods( array( 'getFilterQueryString', 'registerFilterQueryForMatch' ) )
		                   ->getMockForAbstractClass();
		
		$mockQuery
		    ->expects( $this->once() )
		    ->method ( 'getHighlighting' )
		    ->will   ( $this->returnValue( $mockHighlighting ) )
		;
		$mockHighlighting
		    ->expects( $this->at( 0 ) )
		    ->method ( 'addField' )
		    ->with   ( Wikia\Search\Utilities::field( 'html' ) )
		    ->will   ( $this->returnValue( $mockHighlighting ) )
		;
		$mockHighlighting
		    ->expects( $this->at( 1 ) )
		    ->method ( 'setSnippets' )
		    ->with   ( 1 )
		    ->will   ( $this->returnValue( $mockHighlighting ) )
		;
		$mockHighlighting
		    ->expects( $this->at( 2 ) )
		    ->method ( 'setRequireFieldMatch' )
		    ->with   ( true )
		    ->will   ( $this->returnValue( $mockHighlighting ) )
		;
		$mockHighlighting
		    ->expects( $this->at( 3 ) )
		    ->method ( 'setFragSize' )
		    ->with   ( $mockSelect::HL_FRAG_SIZE )
		    ->will   ( $this->returnValue( $mockHighlighting ) )
		;
		$mockHighlighting
		    ->expects( $this->at( 4 ) )
		    ->method ( 'setSimplePrefix' )
		    ->with   ( $mockSelect::HL_MATCH_PREFIX )
		    ->will   ( $this->returnValue( $mockHighlighting ) )
		;
		$mockHighlighting
		    ->expects( $this->at( 5 ) )
		    ->method ( 'setSimplePostfix' )
		    ->with   ( $mockSelect::HL_MATCH_POSTFIX )
		    ->will   ( $this->returnValue( $mockHighlighting ) )
		;
		$mockHighlighting
		    ->expects( $this->at( 6 ) )
		    ->method ( 'setAlternateField' )
		    ->with   ( 'nolang_txt' )
		    ->will   ( $this->returnValue( $mockHighlighting ) )
		;
		$mockHighlighting
		    ->expects( $this->at( 7 ) )
		    ->method ( 'setMaxAlternateFieldLength' )
		    ->with   ( 100 )
		    ->will   ( $this->returnValue( $mockHighlighting ) )
		;
		
		$register = new ReflectionMethod( 'Wikia\Search\QueryService\Select\AbstractSelect', 'registerHighlighting' );
		$register->setAccessible( true );
		$this->assertEquals(
				$mockSelect,
				$register->invoke( $mockSelect, $mockQuery )
		);
	}
	
	/**
	 * @covers Wikia\Search\QueryService\Select\AbstractSelect::sendSearchRequestToClient
	 */
	public function testSearchWorksFirst() {

		$mockClient = $this->getMockBuilder( 'Solarium_Client' )
							->disableOriginalConstructor()
							->setMethods( array( 'select' ) )
							->getMock();

		$mockConfig = $this->getMockBuilder( 'Wikia\Search\Config' )
							->disableOriginalConstructor()
							->setMethods( array( 'getError', 'setError', 'setSkipBoostFunctions' ) )
							->getMock();

		$dc = new Wikia\Search\QueryService\DependencyContainer( array( 'config' => $mockConfig, 'client' => $mockClient ) );
		$mockSelect = $this->getMockBuilder( '\Wikia\Search\QueryService\Select\AbstractSelect' )
		                   ->setConstructorArgs( array( $dc ) )
		                   ->setMethods( array( 'getSelectQuery', 'sendSearchRequestToClient' ) )
		                   ->getMockForAbstractClass();
		
		$mockResult = $this->getMockBuilder( 'Solarium_Result_Select' )
							->disableOriginalConstructor()
							->getMock();

		$mockQuery = $this->getMockBuilder( 'Solarium_Query_Select' )
							->disableOriginalConstructor()
							->getMock();
		
		$mockException = $this->getMockBuilder( '\Exception' )
		                      ->disableOriginalConstructor()
		                      ->getMock();

		$mockSelect
			->expects	( $this->at( 0 ) )
			->method	( 'getSelectQuery' )
			->will		( $this->returnValue( $mockQuery ) )
		;
		$mockClient
			->expects	( $this->at( 0 ) )
			->method	( 'select' )
			->with		( $mockQuery )
			->will		( $this->returnValue( $mockResult ) )
		;
		$reflSearch = new ReflectionMethod( 'Wikia\Search\QueryService\Select\AbstractSelect', 'sendSearchRequestToClient' );
		$reflSearch->setAccessible( true );
		$this->assertEquals(
				$mockResult,
				$reflSearch->invoke( $mockSelect )
		);
		$mockSelect
			->expects	( $this->at( 0 ) )
			->method	( 'getSelectQuery' )
			->will		( $this->returnValue( $mockQuery ) )
		;
		$mockClient
			->expects	( $this->at( 0 ) )
			->method	( 'select' )
			->with		( $mockQuery )
			->will		( $this->throwException( $mockException ) )
		;
		$mockConfig
		    ->expects( $this->at( 0 ) )
		    ->method ( 'getError' )
		    ->will   ( $this->returnValue( null ) )
		;
		$mockConfig
		    ->expects( $this->at( 1 ) )
		    ->method ( 'setSkipBoostFunctions' )
		    ->with   ( true )
		    ->will   ( $this->returnValue( $mockConfig ) )
		;
		$mockConfig
		    ->expects( $this->at( 2 ) )
		    ->method ( 'setError' )
		    ->with   ( $mockException )
		;
		$mockSelect
		    ->expects( $this->at( 1 ) )
		    ->method ( 'sendSearchRequestToClient' )
		    ->will   ( $this->returnValue( $mockResult ) )
		;
		$this->assertEquals(
				$mockResult,
				$reflSearch->invoke( $mockSelect )
		);
		$mockSelect
			->expects	( $this->at( 0 ) )
			->method	( 'getSelectQuery' )
			->will		( $this->returnValue( $mockQuery ) )
		;
		$mockClient
			->expects	( $this->at( 0 ) )
			->method	( 'select' )
			->with		( $mockQuery )
			->will		( $this->throwException( $mockException ) )
		;
		$mockConfig
		    ->expects( $this->at( 0 ) )
		    ->method ( 'getError' )
		    ->will   ( $this->returnValue( $mockException ) )
		;
		$mockConfig
		    ->expects( $this->at( 1 ) )
		    ->method ( 'setError' )
		    ->with   ( $mockException )
		;
		$this->assertInstanceOf(
				'\Solarium_Result_Select_Empty',
				$reflSearch->invoke( $mockSelect )
		);
	}
	
	/**
	 * @covers Wikia\Search\QueryService\Select\AbstractSelect::prepareRequest
	 */
	public function testPrepareRequest() {
		$mockConfig = $this->getMockBuilder( 'Wikia\Search\Config' )
                           ->disableOriginalConstructor()
                           ->setMethods( array( 'getPage', 'setStart', 'getLength' ) )
                           ->getMock();
		$dc = new Wikia\Search\QueryService\DependencyContainer( array( 'config' => $mockConfig ) );
		$mockSelect = $this->getMockBuilder( '\Wikia\Search\QueryService\Select\AbstractSelect' )
		                   ->setConstructorArgs( array( $dc ) )
		                   ->setMethods( array( null ) )
		                   ->getMockForAbstractClass();
		
		$mockConfig
		    ->expects( $this->any() )
		    ->method ( 'getPage' )
		    ->will   ( $this->returnValue( 2 ) )
		;
		$mockConfig
		    ->expects( $this->any() )
		    ->method ( 'getLength' )
		    ->will   ( $this->returnValue( 10 ) )
		;
		$mockConfig
		    ->expects( $this->once() )
		    ->method ( 'setStart' )
		    ->with   ( 10 )
		;
		$reflPrep = new ReflectionMethod( 'Wikia\Search\QueryService\Select\AbstractSelect', 'prepareRequest' );
		$reflPrep->setAccessible( true );
		$this->assertEquals(
				$mockSelect,
				$reflPrep->invoke( $mockSelect )
		);
	}
	
	/**
	 * @covers Wikia\Search\QueryService\Select\AbstractSelect::spellcheckResult
	 */
	public function testSpellcheckResult() {
		$mockService = $this->getMockBuilder( 'Wikia\Search\MediaWikiService' )
		                      ->disableOriginalConstructor()
		                      ->setMethods( array( 'getGlobal' ) )
		                      ->getMock();
		$mockConfig = $this->getMock( 'Wikia\Search\Config', array( 'hasMatch', 'setQuery' ) );
		
		$dc = new Wikia\Search\QueryService\DependencyContainer( array( 'config' => $mockConfig, 'service' => $mockService ) ); 
		$mockSelect = $this->getMockBuilder( '\Wikia\Search\QueryService\Select\AbstractSelect' )
		                   ->setConstructorArgs( array( $dc ) )
		                   ->setMethods( array( 'sendSearchRequestToClient' ) )
		                   ->getMockForAbstractClass();
		
		$mockResult = $this->getMockBuilder( 'Solarium_Result_Select' )
		                   ->disableOriginalConstructor()
		                   ->setMethods( array( 'getNumFound', 'getSpellcheck' ) )
		                   ->getMock();
		$mockSp = $this->getMockBuilder( 'Solarium_Result_Select_Spellcheck' )
		               ->disableOriginalConstructor()
		               ->setMethods( array( 'getCollation' ) )
		               ->getMock();
		$mockCollation = $this->getMockBuilder( 'Solarium_Result_Select_Spellcheck_Collation' )
		                      ->disableOriginalConstructor()
		                      ->setMethods( array( 'getQuery' ) )
		                      ->getMock();
		
		$mockService
		    ->expects( $this->once() )
		    ->method ( 'getGlobal' )
		    ->with   ( 'WikiaSearchSpellcheckActivated' )
		    ->will   ( $this->returnValue( true ) )
		;
		$mockResult
		    ->expects( $this->once() )
		    ->method ( 'getNumFound' )
		    ->will   ( $this->returnValue( 0 ) )
		;
		$mockConfig
		    ->expects( $this->once() )
		    ->method ( 'hasMatch' )
		    ->will   ( $this->returnValue( false ) )
		;
		$mockResult
		    ->expects( $this->once() )
		    ->method ( 'getSpellcheck' )
		    ->will   ( $this->returnValue( $mockSp ) )
		;
		$mockSp
		    ->expects( $this->once() )
		    ->method ( 'getCollation' )
		    ->will   ( $this->returnValue( $mockCollation ) )
		;
		$mockCollation
		    ->expects( $this->once() )
		    ->method ( 'getQuery' )
		    ->will   ( $this->returnValue( 'foo' ) )
		;
		$mockConfig
		    ->expects( $this->once() )
		    ->method ( 'setQuery' )
		    ->with   ( 'foo' )
		;
		$mockSelect
		    ->expects( $this->once() )
		    ->method ( 'sendSearchRequestToClient' )
		    ->will   ( $this->returnValue( $mockResult ) )
		;
		$reflspell = new ReflectionMethod( 'Wikia\Search\QueryService\Select\AbstractSelect', 'spellcheckResult' );
		$reflspell->setAccessible( true );
		$this->assertEquals(
				$mockResult,
				$reflspell->invoke( $mockSelect, $mockResult )
		);
	}
	
	/**
	 * @covers Wikia\Search\QueryService\Select\AbstractSelect::prepareResponse
	 */
	public function testPrepareResponse() {
		$mockFactory = $this->getMockBuilder( 'Wikia\Search\ResultSet\Factory' )
		                    ->disableOriginalConstructor()
		                    ->setMethods( array( 'get' ) )
		                    ->getMock();
		$mockConfig = $this->getMock( 'Wikia\Search\Config', array( 'setResults', 'setResultsFound', 'getPage', 'getQuery' ) );
		$mockQuery = $this->getMock( 'Wikia\Search\Query\Select', array( 'getSanitizedQuery' ), array( 'foo' ) );
		
		$mockResult = $this->getMockBuilder( 'Solarium_Result_Select' )
		                   ->disableOriginalConstructor()
		                   ->setMethods( array( 'getNumFound', 'getSpellcheck' ) )
		                   ->getMock();
		
		$mockResultSet = $this->getMockBuilder( 'Wikia\Search\ResultSet\Base' )
		                      ->disableOriginalConstructor()
		                      ->setMethods( array( 'getResultsFound' ) )
		                      ->getMock();
		
		$dc = new Wikia\Search\QueryService\DependencyContainer( array( 'config' => $mockConfig, 'resultSetFactory' => $mockFactory ) ); 
		$mockSelect = $this->getMockBuilder( '\Wikia\Search\QueryService\Select\AbstractSelect' )
		                   ->setConstructorArgs( array( $dc ) )
		                   ->setMethods( array( 'spellcheckResult' ) )
		                   ->getMockForAbstractClass();
		$mockSelect
		    ->expects( $this->once() )
		    ->method ( 'spellcheckResult' )
		    ->with   ( $mockResult )
		;
		$mockFactory
		    ->expects( $this->once() )
		    ->method ( 'get' )
		    ->will   ( $this->returnValue( $mockResultSet ) )
		;
		$mockResultSet
		    ->expects( $this->once() )
		    ->method ( 'getResultsFound' )
		    ->will   ( $this->returnValue( 10 ) )
		;
		$mockConfig
		    ->expects( $this->once() )
		    ->method ( 'setResults' )
		    ->with   ( $mockResultSet )
		    ->will   ( $this->returnValue( $mockConfig ) )
		;
		$mockConfig
		    ->expects( $this->once() )
		    ->method ( 'getPage' )
		    ->will   ( $this->returnValue( 1 ) )
		;
		$mockConfig
		    ->expects( $this->once() )
		    ->method ( 'getQuery' )
	        ->will   ( $this->returnValue( $mockQuery ) )
        ;
		$mockQuery
		    ->expects( $this->once() )
		    ->method ( 'getSanitizedQuery' )
		    ->will   ( $this->returnValue( 'foo' ) )
		;
		$reflspell = new ReflectionMethod( 'Wikia\Search\QueryService\Select\AbstractSelect', 'prepareResponse' );
		$reflspell->setAccessible( true );
		$reflspell->invoke( $mockSelect, $mockResult );
	}
	
	/**
	 * @covers Wikia\Search\QueryService\Select\AbstractSelect::getFilterQueryString
	 */
	public function testGetFilterQueryString() {
		$mockConfig = $this->getMock( 'Wikia\Search\Config', array( 'getCityId' ) );
		$dc = new Wikia\Search\QueryService\DependencyContainer( array( 'config' => $mockConfig ) ); 
		$mockSelect = $this->getMockBuilder( '\Wikia\Search\QueryService\Select\AbstractSelect' )
		                   ->setConstructorArgs( array( $dc ) )
		                   ->setMethods( array( null ) )
		                   ->getMockForAbstractClass();
		$mockConfig
		    ->expects( $this->once() )
		    ->method ( 'getCityId' )
		    ->will   ( $this->returnValue( 123 ) )
		;
		$reflspell = new ReflectionMethod( 'Wikia\Search\QueryService\Select\AbstractSelect', 'getFilterQueryString' );
		$reflspell->setAccessible( true );
		$this->assertEquals(
				Wikia\Search\Utilities::valueForField( 'wid', 123 ),
				$reflspell->invoke( $mockSelect )
		);
	}
	
	/**
	 * @covers Wikia\Search\QueryService\Select\AbstractSelect::registerDismax
	 */
	public function testRegisterDismax() {
		$mockQuery = $this->getMockBuilder( 'Solarium_Query_Select' )
		                  ->disableOriginalConstructor()
		                  ->setMethods( array( 'getDismax' ) )
		                  ->getMock();
		
		$dismaxMethods = array( 
				'setQueryFields', 'setQueryParser', 'setPhraseFields', 'setBoostFunctions',
				'setBoostQuery', 'setMinimumMatch', 'setPhraseSlop', 'setTie' 
				);
		$mockDismax = $this->getMockBuilder( 'Solarium_Query_Select_Component_DisMax' )
		                   ->disableOriginalConstructor()
		                   ->setMethods( $dismaxMethods )
		                   ->getMock();
		$mockService = $this->getMockBuilder( 'Wikia\Search\MediaWikiService' )
		                      ->disableOriginalConstructor()
		                      ->setMethods( array( 'isOnDbCluster' ) )
		                      ->getMock();
		
		$mockConfig = $this->getMockBuilder( 'Wikia\Search\Config' )
		                   ->setMethods( array( 'getMinimumMatch', 'getSkipBoostFunctions', 'getQuery' ) )
		                   ->getMock();
		
		$deps = array( 'config' => $mockConfig, 'service' => $mockService  );
		$dc = new Wikia\Search\QueryService\DependencyContainer( $deps );
		$mockSelect = $this->getMockBuilder( 'Wikia\Search\QueryService\Select\AbstractSelect' )
		                   ->setConstructorArgs( array( $dc ) )
		                   ->setMethods( array( 'getQueryFieldsString', 'getBoostQueryString' ) )
		                   ->getMockForAbstractClass();
		
		$mockSelect
		    ->expects( $this->once() )
		    ->method ( 'getQueryFieldsString' )
		    ->will   ( $this->returnValue( 'bar' ) )
		;
		$mockQuery
		    ->expects( $this->once() )
		    ->method ( 'getDismax' )
		    ->will   ( $this->returnValue( $mockDismax ) )
		;
		$mockDismax
		    ->expects( $this->once() )
		    ->method ( 'setQueryFields' )
		    ->with   ( 'bar' )
		    ->will   ( $this->returnValue( $mockDismax ) )
	    ;
		$mockDismax
		    ->expects( $this->once() )
		    ->method ( 'setQueryParser' )
		    ->with   ( 'edismax' )
		    ->will   ( $this->returnValue( $mockDismax ) )
		;
		$mockService
		    ->expects( $this->once() )
		    ->method ( 'isOnDbCluster' )
		    ->will   ( $this->returnValue( true  ) )
		;
		$mockDismax
		    ->expects( $this->once() )
		    ->method ( 'setPhraseFields' )
		    ->with   ( 'bar' )
		    ->will   ( $this->returnValue( $mockDismax ) )
		;
		$mockSelect
		    ->expects( $this->once() )
		    ->method ( 'getBoostQueryString' )
		    ->will   ( $this->returnValue( 'bq' ) )
		;
		$mockDismax
		    ->expects( $this->once() )
		    ->method ( 'setBoostQuery' )
		    ->with   ( 'bq' )
		    ->will   ( $this->returnValue( $mockDismax ) )
		;
		$mockConfig
		    ->expects( $this->once() )
		    ->method ( 'getMinimumMatch' )
		    ->will   ( $this->returnValue( '80%' ) )
		;
		$mockDismax
		    ->expects( $this->once() )
		    ->method ( 'setMinimumMatch' )
		    ->with   ( '80%' )
		    ->will   ( $this->returnValue( $mockDismax ) )
		;
		$mockDismax
		    ->expects( $this->once() )
		    ->method ( 'setPhraseSlop' )
		    ->with   ( 3 )
		    ->will   ( $this->returnValue( $mockDismax ) )
		;
		$mockDismax
		    ->expects( $this->once() )
		    ->method ( 'setTie' )
		    ->with   ( 0.01 )
		    ->will   ( $this->returnValue( $mockDismax ) )
		;
		$mockConfig
		    ->expects( $this->once() )
		    ->method ( 'getSkipBoostFunctions' )
		    ->will   ( $this->returnValue( false ) )
		;
		$bfsRefl = new ReflectionProperty( 'Wikia\Search\QueryService\Select\AbstractSelect', 'boostFunctions' );
		$bfsRefl->setAccessible( true );
		$bfsRefl->setValue( $mockSelect, array( 'foo', 'bar' ) );
		$mockDismax
		    ->expects( $this->once() )
		    ->method ( 'setBoostFunctions' )
		    ->with   ( 'foo bar' )
		;
		$funcRefl = new ReflectionMethod( 'Wikia\Search\QueryService\Select\AbstractSelect', 'registerDismax' );
		$funcRefl->setAccessible( true );
		$this->assertEquals(
				$mockSelect,
				$funcRefl->invoke( $mockSelect, $mockQuery )
		);
	}
	
	/**
	 * @covers Wikia\Search\QueryService\Select\AbstractSelect::searchAsApi
	 */
	public function testSearchAsApi() {
		$mockSelect = $this->getMockBuilder( 'Wikia\Search\QueryService\Select\AbstractSelect' )
		                   ->disableOriginalConstructor()
		                   ->setMethods( array( 'search' ) )
		                   ->getMockForAbstractClass();
		
		$mockResultSet = $this->getMockBuilder( 'Wikia\Search\ResultSet\Base' )
		                      ->disableOriginalConstructor()
		                      ->setMethods( array( 'toArray' ) )
		                      ->getMock();
		
		$results = array( array( 'id' => '123_234', 'title' => 'foo' ) );
		
		$mockSelect
		    ->expects( $this->once() )
		    ->method ( 'search' )
		    ->will   ( $this->returnValue( $mockResultSet ) )
		;
		$mockResultSet
		    ->expects( $this->once() )
		    ->method ( 'toArray' )
		    ->will   ( $this->returnValue( $results ) )
		;
		$this->assertEquals(
				$results,
				$mockSelect->searchAsApi()
		);
	}
	
}