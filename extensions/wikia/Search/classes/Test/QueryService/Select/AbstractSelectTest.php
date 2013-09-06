<?php
/**
 * Class definition for Wikia\Search\Test\QueryService\Select\AbstractSelect
 */
namespace Wikia\Search\Test\QueryService\Select;
use Wikia, ReflectionProperty, ReflectionMethod, Wikia\Search\Utilities;
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
		
		$mockSelect = $this->getMockBuilder( 'Wikia\Search\QueryService\Select\AbstractSelect' )
		                   ->disableOriginalConstructor()
		                   ->setMethods( array( 'getMatch', 'prepareRequest', 'prepareResponse', 'sendSearchRequestToClient', 'getConfig' ) )
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
		$mockSelect
		    ->expects( $this->at( 4 ) )
		    ->method ( 'getConfig' )
		    ->will   ( $this->returnValue( $mockConfig ) )
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
		$mockSelect = $this->getMockBuilder( 'Wikia\Search\QueryService\Select\AbstractSelect' )
		                   ->disableOriginalConstructor()
		                   ->setMethods( array( 'extractMatch', 'getConfig' ) )
		                   ->getMockForAbstractClass();
		$mockMatch = $this->getMockBuilder( 'Wikia\Search\Match\Article' )
		                  ->disableOriginalConstructor()
		                  ->getMock();

		$mockSelect
		    ->expects( $this->at( 0 ) )
		    ->method ( 'getConfig' )
		    ->will   ( $this->returnValue( $mockConfig ) )
		;
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
		    ->method ( 'getConfig' )
		    ->will   ( $this->returnValue( $mockConfig ) )
		;
		$mockSelect
		    ->expects( $this->at( 1 ) )
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
		$mockSelect = $this->getMockBuilder( 'Wikia\Search\QueryService\Select\AbstractSelect' )
		                   ->disableOriginalConstructor()
		                   ->setMethods( array( 'getConfig' ) )
		                   ->getMockForAbstractClass();
		$mockSelect
		    ->expects( $this->once() )
		    ->method ( 'getConfig' )
		    ->will   ( $this->returnValue( $mockConfig ) )
		;
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
		                   ->setMethods( array( 'registerComponents', 'getQuery', 'registerQueryParams' ) )
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
		    ->method ( 'registerQueryParams' )
		    ->with   ( $mockQuery )
		    ->will   ( $this->returnValue( $mockSelect ) )
		;
		$mockSelect
		    ->expects( $this->at( 1 ) )
		    ->method ( 'registerComponents' )
		    ->with   ( $mockQuery )
		    ->will   ( $this->returnValue( $mockSelect ) )
		;
		$mockSelect
		    ->expects( $this->at( 2 ) )
		    ->method ( 'getQuery' )
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
		$mockQuery = $this->getMockBuilder( '\Solarium_Query_Select' )
		                  ->disableOriginalConstructor()
		                  ->setMethods( array( 'addFields', 'removeField', 'setStart', 'setRows', 'addSort', 'addParam' ) )
		                  ->getMock();
		$config = new Wikia\Search\Config();
		$mockSelect = $this->getMockBuilder( '\Wikia\Search\QueryService\Select\AbstractSelect' )
		                   ->disableOriginalConstructor()
		                   ->setMethods( array( 'getConfig', 'getRequestedFields' ) )
		                   ->getMockForAbstractClass();
		
		$mockSelect
		    ->expects( $this->any() )
		    ->method ( 'getConfig' )
		    ->will   ( $this->returnValue( $config ) )
		;
		
		// we'll just use default values.
		$sort = $config->getSort();
		$start = $config->getStart();
		$length = $config->getLength();
		
		$fields = [ 'foo', 'bar', 'baz' ];
		
		$mockSelect
		    ->expects( $this->once() )
		    ->method ( 'getRequestedFields' )
		    ->will   ( $this->returnValue( $fields ) )
		;
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
		$mockSelect = $this->getMockBuilder( '\Wikia\Search\QueryService\Select\AbstractSelect' )
		                   ->disableOriginalConstructor()
		                   ->setMethods( array( 'getFilterQueryString', 'registerFilterQueryForMatch', 'getConfig' ) )
		                   ->getMockForAbstractClass();
		
		$mockSelect
		    ->expects( $this->any() )
		    ->method ( 'getConfig' )
		    ->will   ( $this->returnValue( $mockConfig ) )
		;
		$mockSelect
		    ->expects( $this->at( 1 ) )
		    ->method ( 'getFilterQueryString' )
		    ->will   ( $this->returnValue( 'fqstring' )  )
		;
		$mockConfig
		    ->expects( $this->once() )
		    ->method ( 'setFilterQuery' )
		    ->with   ( 'fqstring' )
		;
		$mockSelect
		    ->expects( $this->at( 1 ) )
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
		$mockSelect = $this->getMockBuilder( '\Wikia\Search\QueryService\Select\AbstractSelect' )
		                   ->disableOriginalConstructor()
		                   ->setMethods( array( 'getConfig' ) )
		                   ->getMockForAbstractClass();
		
		$mockSelect
		    ->expects( $this->any() )
		    ->method ( 'getConfig' )
		    ->will   ( $this->returnValue( $mockConfig ) )
		;
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
		
		$mockSelect = $this->getMockBuilder( '\Wikia\Search\QueryService\Select\AbstractSelect' )
		                   ->disableOriginalConstructor()
		                   ->setMethods( array( 'sendSearchRequestToClient', 'getConfig', 'getService' ) )
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
		$mockConfig = $this->getMock( 'Wikia\Search\Config', array( 'setResults', 'setResultsFound', 'getPage', 'getQuery' ) );
		$mockQuery = $this->getMock( 'Wikia\Search\Query\Select', array( 'getSanitizedQuery' ), array( 'foo' ) );
		
		$mockResultSetFactory = $this->getMock( 'Wikia\Search\ResultSet\Factory', [ 'get' ] );
		
		$mockResult = $this->getMockBuilder( 'Solarium_Result_Select' )
		                   ->disableOriginalConstructor()
		                   ->setMethods( array( 'getNumFound', 'getSpellcheck' ) )
		                   ->getMock();
		
		$mockResultSet = $this->getMockBuilder( 'Wikia\Search\ResultSet\Base' )
		                      ->disableOriginalConstructor()
		                      ->setMethods( array( 'getResultsFound' ) )
		                      ->getMock();
		
		$mockSelect = $this->getMockBuilder( '\Wikia\Search\QueryService\Select\AbstractSelect' )
		                   ->disableOriginalConstructor()
		                   ->setMethods( array( 'spellcheckResult', 'getConfig' ) )
		                   ->getMockForAbstractClass();
		
		$mockResultSetFactory
		    ->expects( $this->once() )
		    ->method ( 'get' )
		    ->will   ( $this->returnValue( $mockResultSet ) )
		;
		$mockSelect
		    ->expects( $this->once() )
		    ->method ( 'spellcheckResult' )
		    ->with   ( $mockResult )
		;
		$mockSelect
		    ->expects( $this->once() )
		    ->method ( 'getConfig' )
		    ->will   ( $this->returnValue( $mockConfig ) )
		;
		$mockConfig
		    ->expects( $this->once() )
		    ->method ( 'setResults' )
		    ->will   ( $this->returnValue( $mockConfig ) )
		;
		
		$this->proxyClass( 'Wikia\Search\ResultSet\Factory', $mockResultSetFactory );
		$this->mockApp();
		
		$reflspell = new ReflectionMethod( $mockSelect, 'prepareResponse' );
		$reflspell->setAccessible( true );
		$reflspell->invoke( $mockSelect, $mockResult ); // weirdness
	}
	
	/**
	 * @covers Wikia\Search\QueryService\Select\AbstractSelect::getFilterQueryString
	 *@todo move to correct query service
	public function testGetFilterQueryString() {
		$mockConfig = $this->getMock( 'Wikia\Search\Config', array( 'getCityId', 'getNamespaces' ) );
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
		$mockConfig
		    ->expects( $this->once() )
		    ->method ( 'getNamespaces' )
		    ->will   ( $this->returnValue( [ 0, 14 ] ) )
		;
		$reflspell = new ReflectionMethod( 'Wikia\Search\QueryService\Select\AbstractSelect', 'getFilterQueryString' );
		$reflspell->setAccessible( true );
		$this->assertEquals(
				'((ns:0) OR (ns:14)) AND (wid:123)',
				$reflspell->invoke( $mockSelect )
		);
	}
	*/
	
	/**
	 * @covers Wikia\Search\QueryService\Select\AbstractSelect::registerDismax
	 * @todo move ot correct query service
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
	}*/
	
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
	
	/**
	 * @covers Wikia\Search\QueryService\Select\AbstractSelect::searchAsApi
	 */
	public function testSearchAsApiWithMetadata() {
		$mockSelect = $this->getMockBuilder( 'Wikia\Search\QueryService\Select\AbstractSelect' )
		                   ->disableOriginalConstructor()
		                   ->setMethods( array( 'search', 'getConfig' ) )
		                   ->getMockForAbstractClass();
		
		$mockResultSet = $this->getMockBuilder( 'Wikia\Search\ResultSet\Base' )
		                      ->disableOriginalConstructor()
		                      ->setMethods( array( 'toArray' ) )
		                      ->getMock();
		
		$mockConfig = $this->getMockBuilder( 'Wikia\Search\Config' )
		                   ->disableOriginalConstructor()
		                   ->setMethods( [ 'getNumPages', 'getPage', 'getStart', 'getLimit', 'getResultsFound' ] )
		                   ->getMock();
		
		$expectedFields = [ 'id', 'title' ];
		
		$results = array( array( 'id' => '123_234', 'title' => 'foo' ) );
		
		$mockSelect
		    ->expects( $this->any() )
		    ->method ( 'getConfig' )
		    ->will   ( $this->returnValue( $mockConfig ) )
		;
		$mockSelect
		    ->expects( $this->once() )
		    ->method ( 'search' )
		    ->will   ( $this->returnValue( $mockResultSet ) )
		;
		$mockResultSet
		    ->expects( $this->once() )
		    ->method ( 'toArray' )
		    ->with   ( $expectedFields )
		    ->will   ( $this->returnValue( $results ) )
		;
		$mockConfig
		    ->expects( $this->once() )
		    ->method ( 'getResultsFound' )
		    ->will   ( $this->returnValue( 200 ) )
		;
		$mockConfig
		    ->expects( $this->once() )
		    ->method ( 'getPage' )
		    ->will   ( $this->returnValue( 1 ) )
		;
		$mockConfig
		    ->expects( $this->once() )
		    ->method ( 'getNumPages' )
		    ->will   ( $this->returnValue( 10 ) )
		;
		$mockConfig
		    ->expects( $this->once() )
		    ->method ( 'getLimit' )
		    ->will   ( $this->returnValue( 20 ) )
		;
		$mockConfig
		    ->expects( $this->once() )
		    ->method ( 'getStart' )
		    ->will   ( $this->returnValue( 0 ) )
		;
		$this->assertEquals(
				[ 'total' => 200, 'batches' => 10, 'currentBatch' => 1, 'next' => 20, 'items' => $results ],
				$mockSelect->searchAsApi( $expectedFields, true )
		);
	}
	
	/**
	 * @covers Wikia\Search\QueryService\Select\AbstractSelect::searchAsApi
	 */
	public function testSearchAsApiWithMetadataNoResults() {
		$mockSelect = $this->getMockBuilder( 'Wikia\Search\QueryService\Select\AbstractSelect' )
		                   ->disableOriginalConstructor()
		                   ->setMethods( array( 'search', 'getConfig' ) )
		                   ->getMockForAbstractClass();
		
		$mockResultSet = $this->getMockBuilder( 'Wikia\Search\ResultSet\Base' )
		                      ->disableOriginalConstructor()
		                      ->setMethods( array( 'toArray' ) )
		                      ->getMock();
		
		$mockConfig = $this->getMockBuilder( 'Wikia\Search\Config' )
		                   ->disableOriginalConstructor()
		                   ->setMethods( [ 'getNumPages', 'getPage', 'getStart', 'getLimit', 'getResultsFound' ] )
		                   ->getMock();
		
		$expectedFields = [ 'id', 'title' ];
		
		$results = array();
		
		$mockSelect
		    ->expects( $this->any() )
		    ->method ( 'getConfig' )
		    ->will   ( $this->returnValue( $mockConfig ) )
		;
		$mockSelect
		    ->expects( $this->once() )
		    ->method ( 'search' )
		    ->will   ( $this->returnValue( $mockResultSet ) )
		;
		$mockResultSet
		    ->expects( $this->once() )
		    ->method ( 'toArray' )
		    ->with   ( $expectedFields )
		    ->will   ( $this->returnValue( $results ) )
		;
		$mockConfig
		    ->expects( $this->once() )
		    ->method ( 'getResultsFound' )
		    ->will   ( $this->returnValue( 0 ) )
		;
		$this->assertEquals(
				[ 'total' => 0, 'batches' => 0, 'currentBatch' => 0, 'next' => 0, 'items' => $results ],
				$mockSelect->searchAsApi( $expectedFields, true )
		);
	}
	
	/**
	 * @covers Wikia\Search\QueryService\Select\AbstractSelect::extractWikiMatch
	 */
	public function testExtractWikiMatchWithMatch() {
		$mockService = $this->getMockBuilder( 'Wikia\Search\QueryService\Select\AbstractSelect' )
		                    ->disableOriginalConstructor()
		                    ->setMethods( [ 'getService', 'getConfig' ] )
		                    ->getMockForAbstractClass();
		
		$mockConfig = $this->getMockBuilder( 'Wikia\Search\Config' )
		                   ->disableOriginalConstructor()
		                   ->setMethods( [ 'getQuery', 'setWikiMatch', 'getWikiMatch' ] )
		                   ->getMock();
		
		$mockMatch = $this->getMockBuilder( 'Wikia\Search\Match\Wiki' )
		                  ->setMethods( [ 'getId', 'getResult' ] )
		                  ->disableOriginalConstructor()
		                  ->getMock();
		
		$mockResult = $this->getMock( 'Wikia\Search\Result', [ 'offsetGet' ] );
		
		$mockMwService = $this->getMock( 'Wikia\Search\MediaWikiService', [ 'getWikiMatchByHost', 'getWikiId' ] );
		
		$mockQuery = $this->getMock( 'Wikia\Search\Query\Select', [ 'getSanitizedQuery' ], [ 'foo' ] );
		
		$mockService
		    ->expects( $this->once() )
		    ->method ( 'getConfig' )
		    ->will   ( $this->returnValue( $mockConfig ) )
		;
		$mockService
		    ->expects( $this->once() )
		    ->method ( 'getService' )
		    ->will   ( $this->returnValue( $mockMwService ) )
		;
		$mockConfig
		    ->expects( $this->once() )
		    ->method ( 'getQuery' )
		    ->will   ( $this->returnValue( $mockQuery ) )
		;
		$mockQuery
		    ->expects( $this->once() )
		    ->method ( 'getSanitizedQuery' )
		    ->will   ( $this->returnValue( 'foo bar 123' ) )
		;
		$mockMwService
		    ->expects( $this->once() )
		    ->method ( 'getWikiMatchByHost' )
		    ->with   ( 'foobar123' )
		    ->will   ( $this->returnValue( $mockMatch ) )
		;
		$mockMwService
		    ->expects( $this->once() )
		    ->method ( 'getWikiId' )
		    ->will   ( $this->returnValue( 123 ) )
		;
		$mockMatch
		    ->expects( $this->once() )
		    ->method ( 'getId' )
		    ->will   ( $this->returnValue( 321 ) )
		;
		$mockMatch
		    ->expects( $this->once() )
		    ->method ( 'getResult' )
		    ->will   ( $this->returnValue( $mockResult ) )
		;
		$mockResult
		    ->expects( $this->once() )
		    ->method ( 'offsetGet' )
		    ->with   ( 'articles_i' )
		    ->will   ( $this->returnValue( 50 ) )
		;
		$mockConfig
		    ->expects( $this->once() )
		    ->method ( 'setWikiMatch' )
		    ->with   ( $mockMatch )
		;
		$mockConfig
		    ->expects( $this->once() )
		    ->method ( 'getWikiMatch' )
		    ->will   ( $this->returnValue( $mockMatch ) )
		;
		$extract = new ReflectionMethod( $mockService, 'extractWikiMatch' );
		$extract->setAccessible( true );
		$this->assertEquals(
				$mockMatch,
				$extract->invoke( $mockService )
		);
	}
	
	/**
	 * @covers Wikia\Search\QueryService\Select\AbstractSelect::extractWikiMatch
	 */
	public function testExtractWikiMatchWithMatchUnder50Articles() {
		$mockService = $this->getMockBuilder( 'Wikia\Search\QueryService\Select\AbstractSelect' )
		                    ->disableOriginalConstructor()
		                    ->setMethods( [ 'getService', 'getConfig' ] )
		                    ->getMockForAbstractClass();
		
		$mockConfig = $this->getMockBuilder( 'Wikia\Search\Config' )
		                   ->disableOriginalConstructor()
		                   ->setMethods( [ 'getQuery', 'setWikiMatch', 'getWikiMatch' ] )
		                   ->getMock();
		
		$mockMatch = $this->getMockBuilder( 'Wikia\Search\Match\Wiki' )
		                  ->setMethods( [ 'getId', 'getResult' ] )
		                  ->disableOriginalConstructor()
		                  ->getMock();
		
		$mockResult = $this->getMock( 'Wikia\Search\Result', [ 'offsetGet' ] );
		
		$mockMwService = $this->getMock( 'Wikia\Search\MediaWikiService', [ 'getWikiMatchByHost', 'getWikiId' ] );
		
		$mockQuery = $this->getMock( 'Wikia\Search\Query\Select', [ 'getSanitizedQuery' ], [ 'foo' ] );
		
		$mockService
		    ->expects( $this->once() )
		    ->method ( 'getConfig' )
		    ->will   ( $this->returnValue( $mockConfig ) )
		;
		$mockService
		    ->expects( $this->once() )
		    ->method ( 'getService' )
		    ->will   ( $this->returnValue( $mockMwService ) )
		;
		$mockConfig
		    ->expects( $this->once() )
		    ->method ( 'getQuery' )
		    ->will   ( $this->returnValue( $mockQuery ) )
		;
		$mockQuery
		    ->expects( $this->once() )
		    ->method ( 'getSanitizedQuery' )
		    ->will   ( $this->returnValue( 'foo bar 123' ) )
		;
		$mockMwService
		    ->expects( $this->once() )
		    ->method ( 'getWikiMatchByHost' )
		    ->with   ( 'foobar123' )
		    ->will   ( $this->returnValue( $mockMatch ) )
		;
		$mockMwService
		    ->expects( $this->once() )
		    ->method ( 'getWikiId' )
		    ->will   ( $this->returnValue( 123 ) )
		;
		$mockMatch
		    ->expects( $this->once() )
		    ->method ( 'getId' )
		    ->will   ( $this->returnValue( 321 ) )
		;
		$mockMatch
		    ->expects( $this->once() )
		    ->method ( 'getResult' )
		    ->will   ( $this->returnValue( $mockResult ) )
		;
		$mockResult
		    ->expects( $this->once() )
		    ->method ( 'offsetGet' )
		    ->with   ( 'articles_i' )
		    ->will   ( $this->returnValue( 49 ) )
		;
		$mockConfig
		    ->expects( $this->never() )
		    ->method ( 'setWikiMatch' )
		;
		$mockConfig
		    ->expects( $this->once() )
		    ->method ( 'getWikiMatch' )
		    ->will   ( $this->returnValue( null ) )
		;
		$extract = new ReflectionMethod( $mockService, 'extractWikiMatch' );
		$extract->setAccessible( true );
		$this->assertNull(
				$extract->invoke( $mockService )
		);
	}

	/**
	 * @covers Wikia\Search\QueryService\Select\AbstractSelect::extractWikiMatch
	 */
	public function testExtractWikiMatchWithMatchSameWiki() {
		$mockService = $this->getMockBuilder( 'Wikia\Search\QueryService\Select\AbstractSelect' )
		                    ->disableOriginalConstructor()
		                    ->setMethods( [ 'getService', 'getConfig' ] )
		                    ->getMockForAbstractClass();
		
		$mockConfig = $this->getMockBuilder( 'Wikia\Search\Config' )
		                   ->disableOriginalConstructor()
		                   ->setMethods( [ 'getQuery', 'setWikiMatch', 'getWikiMatch' ] )
		                   ->getMock();
		
		$mockMatch = $this->getMockBuilder( 'Wikia\Search\Match\Wiki' )
		                  ->setMethods( [ 'getId' ] )
		                  ->disableOriginalConstructor()
		                  ->getMock();
		
		$mockMwService = $this->getMock( 'Wikia\Search\MediaWikiService', [ 'getWikiMatchByHost', 'getWikiId' ] );
		
		$mockQuery = $this->getMock( 'Wikia\Search\Query\Select', [ 'getSanitizedQuery' ], [ 'foo' ] );
		
		$mockService
		    ->expects( $this->once() )
		    ->method ( 'getConfig' )
		    ->will   ( $this->returnValue( $mockConfig ) )
		;
		$mockService
		    ->expects( $this->once() )
		    ->method ( 'getService' )
		    ->will   ( $this->returnValue( $mockMwService ) )
		;
		$mockConfig
		    ->expects( $this->once() )
		    ->method ( 'getQuery' )
		    ->will   ( $this->returnValue( $mockQuery ) )
		;
		$mockQuery
		    ->expects( $this->once() )
		    ->method ( 'getSanitizedQuery' )
		    ->will   ( $this->returnValue( 'foo bar 123' ) )
		;
		$mockMwService
		    ->expects( $this->once() )
		    ->method ( 'getWikiMatchByHost' )
		    ->with   ( 'foobar123' )
		    ->will   ( $this->returnValue( $mockMatch ) )
		;
		$mockMwService
		    ->expects( $this->once() )
		    ->method ( 'getWikiId' )
		    ->will   ( $this->returnValue( 123 ) )
		;
		$mockMatch
		    ->expects( $this->once() )
		    ->method ( 'getId' )
		    ->will   ( $this->returnValue( 123 ) )
		;
		$mockConfig
		    ->expects( $this->never() )
		    ->method ( 'setWikiMatch' )
		;
		$mockConfig
		    ->expects( $this->once() )
		    ->method ( 'getWikiMatch' )
		    ->will   ( $this->returnValue( null ) )
		;
		$extract = new ReflectionMethod( $mockService, 'extractWikiMatch' );
		$extract->setAccessible( true );
		$this->assertNull(
				$extract->invoke( $mockService )
		);
	}

	/**
	 * @covers Wikia\Search\QueryService\Select\AbstractSelect::getRequestedFields
	 */
	public function testGetRequestedFields() {
		$mockService = $this->getMockBuilder( 'Wikia\Search\QueryService\Select\AbstractSelect' )
		                    ->disableOriginalConstructor()
		                    ->setMethods( [ 'getConfig' ] )
		                    ->getMockForAbstractClass();
		$mockConfig = $this->getMock( 'Wikia\Search\Config', [ 'getRequestedFields' ] );
		$attr = new ReflectionProperty( $mockService, 'requestedFields' );
		$attr->setAccessible( true );
		$attr->setValue( $mockService, [ 'html' ] );
		$get = new ReflectionMethod( $mockService, 'getRequestedFields' );
		$get->setAccessible( true );
		$mockService
		    ->expects( $this->once() )
		    ->method ( 'getConfig' )
		    ->will   ( $this->returnValue( $mockConfig ) )
		;
		$mockConfig
		    ->expects( $this->once() )
		    ->method ( 'getRequestedFields' )
		    ->will   ( $this->returnValue( [ 'title' ] ) )
		;
		$this->assertEquals(
				[ Utilities::field( 'html' ), Utilities::field( 'title' ) ],
				$get->invoke( $mockService )
		);
	}
	
	/**
	 * @covers Wikia\Search\QueryService\Select\AbstractSelect::getFilterQueryString
	 */
	public function testGetFilterQueryString() {
		$mockService = $this->getMockBuilder( 'Wikia\Search\QueryService\Select\AbstractSelect' )
		                    ->disableOriginalConstructor()
		                    ->setMethods( [ null ] )
		                    ->getMockForAbstractClass();
		$fqs = new ReflectionMethod( $mockService, 'getFilterQueryString' );
		$fqs->setAccessible( true );
		$this->assertEquals(
				'',
				$fqs->invoke( $mockService )
		);
	}
	
	/**
	 * @covers Wikia\Search\QueryService\Select\AbstractSelect::getConfig
	 */
	public function testGetConfig() {
		$mockSelect = $this->getMockBuilder( 'Wikia\Search\QueryService\Select\AbstractSelect' )
		                    ->disableOriginalConstructor()
		                    ->setMethods( [ null ] )
		                    ->getMockForAbstractClass();
		$config = new Wikia\Search\Config;
		$cnf = new ReflectionProperty( $mockSelect, 'config' );
		$cnf->setAccessible( true );
		$cnf->setValue( $mockSelect, $config );
		$get = new ReflectionMethod( $mockSelect, 'getConfig' );
		$get->setAccessible( true );
		$this->assertEquals(
				$config,
				$get->invoke( $mockSelect )
		);
	}
	
	/**
	 * @covers Wikia\Search\QueryService\Select\AbstractSelect::getService
	 */
	public function testGetService() {
		$mockSelect = $this->getMockBuilder( 'Wikia\Search\QueryService\Select\AbstractSelect' )
		                    ->disableOriginalConstructor()
		                    ->setMethods( [ null ] )
		                    ->getMockForAbstractClass();
		$service = new Wikia\Search\MediaWikiService;
		$svc = new ReflectionProperty( $mockSelect, 'service' );
		$svc->setAccessible( true );
		$svc->setValue( $mockSelect, $service );
		$get = new ReflectionMethod( $mockSelect, 'getService' );
		$get->setAccessible( true );
		$this->assertEquals(
				$service,
				$get->invoke( $mockSelect )
		);
	}
	
	/**
	 * @covers Wikia\Search\QueryService\Select\AbstractSelect::getClient
	 */
	public function testGetClient() {
		$mockSelect = $this->getMockBuilder( 'Wikia\Search\QueryService\Select\AbstractSelect' )
		                   ->disableOriginalConstructor()
		                   ->setMethods( [ 'setCoreInClient' ] )
		                   ->getMockForAbstractClass();
		
		$mockClient = $this->getMockBuilder( '\Solarium_Client' )
		                   ->disableOriginalConstructor()
		                   ->getMock();
		
		$mockSelect
		    ->expects( $this->once() )
		    ->method ( 'setCoreInClient' )
		;
		
		$attr = new ReflectionProperty( $mockSelect, 'client' );
		$attr->setAccessible( true );
		$attr->setValue( $mockSelect, $mockClient );
		
		$get = new ReflectionMethod( $mockSelect, 'getClient' );
		$get->setAccessible( true );
		
		$this->assertAttributeEmpty(
				'coreSetInClient',
				$mockSelect
		);
		$this->assertEquals(
				$mockClient,
				$get->invoke( $mockSelect )
		);
		$set = new ReflectionProperty( $mockSelect, 'coreSetInClient' );
		$set->setAccessible( true );
		$set->setValue( $mockSelect, true );
		$this->assertEquals(
				$mockClient,
				$get->invoke( $mockSelect )
		); 
	}
	
	/**
	 * @covers Wikia\Search\QueryService\Select\AbstractSelect::setCoreInClient
	 */
	public function testSetCoreInClient() {
		$mockSelect = $this->getMockBuilder( 'Wikia\Search\QueryService\Select\AbstractSelect' )
		                   ->disableOriginalConstructor()
		                   ->setMethods( [ null ] )
		                   ->getMockForAbstractClass();
		
		$mockClient = $this->getMockBuilder( '\Solarium_Client' )
		                   ->disableOriginalConstructor()
		                   ->setMethods( [ 'getOptions', 'setOptions' ] )
		                   ->getMock();
		
		$before = [ 'foo' => 'bar', 'adapteroptions' => [ 'path' => 'whatever', 'baz' => 'qux' ] ];
		$after = [ 'foo' => 'bar', 'adapteroptions' => [ 'path' => '/solr/main', 'baz' => 'qux' ] ];
		
		$mockClient
		    ->expects( $this->once() )
		    ->method ( 'getOptions' )
		    ->will   ( $this->returnValue( $before ) )
		;
		$mockClient
		    ->expects( $this->once() )
		    ->method ( 'setOptions' )
		    ->with   ( $after, true )
		;
		
		$client = new ReflectionProperty( $mockSelect, 'client' );
		$client->setAccessible( true );
		$client->setValue( $mockSelect, $mockClient );
		
		$set = new ReflectionMethod( $mockSelect, 'setCoreInClient' );
		$set->setAccessible( true );
		$this->assertEquals(
				$mockSelect,
				$set->invoke( $mockSelect )
		);
		$this->assertAttributeEquals(
				true,
				'coreSetInClient',
				$mockSelect
		);
	}
	
}