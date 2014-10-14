<?php
/** 
 * Class definition for Wikia\Search\Test\ResultSet\GroupingTest
 */
namespace Wikia\Search\Test\ResultSet;
use Wikia, ReflectionProperty, ReflectionMethod, Exception;
/**
 * Tests individual groupings of result sets
 */
class GroupingTest extends Wikia\Search\Test\BaseTest
{
	/**
	 * Convenience method to easily handle the necessary dependencies & method mocking for recurrent mocks
	 * @param array $resultSetMethods
	 * @param array $configMethods
	 * @param array $resultMethods
	 */
	protected function prepareMocks( $resultSetMethods = array(), $configMethods = array(), $resultMethods = array(), $serviceMethods = array() ) { 

		$this->searchResult		=	$this->getMockBuilder( 'Solarium_Result_Select' )
									->disableOriginalConstructor()
									->setMethods( $resultMethods )
									->getMock();
		
		$this->config		=	$this->getMockBuilder( 'WikiaSearchConfig' )
									->disableOriginalConstructor()
									->setMethods( $configMethods )
									->getMock();
		
		$this->resultSet	=	$this->getMockBuilder( '\Wikia\Search\ResultSet\Grouping' )
									->disableOriginalConstructor()
									->setMethods( $resultSetMethods )
									->getMock();
		
		$this->service = $this->getMockbuilder( 'Wikia\Search\MediaWikiService' )
		                        ->disableOriginalConstructor()
		                        ->setMethods( $serviceMethods )
		                        ->getMock();
		
		$reflResult = new ReflectionProperty( '\Wikia\Search\ResultSet\Base', 'searchResultObject' );
		$reflResult->setAccessible( true );
		$reflResult->setValue( $this->resultSet, $this->searchResult );
		
		$reflConfig = new ReflectionProperty(  '\Wikia\Search\ResultSet\Base', 'searchConfig' );
		$reflConfig->setAccessible( true );
		$reflConfig->setValue( $this->resultSet, $this->config );
		
		$reflConfig = new ReflectionProperty(  '\Wikia\Search\ResultSet\Base', 'service' );
		$reflConfig->setAccessible( true );
		$reflConfig->setValue( $this->resultSet, $this->service );
	}

	/**
	 * @covers Wikia\Search\ResultSet\Grouping::getHostGrouping
	 */
	public function testGetHostGroupingWithoutGrouping() {
		$this->prepareMocks( array(), array(), array( 'getGrouping' ) );
		
		$this->searchResult
			->expects	( $this->at( 0 ) )
			->method	( 'getGrouping' )
			->will		( $this->returnValue( null ) )
		;
		
		$method = new ReflectionMethod( 'Wikia\Search\ResultSet\Grouping', 'getHostGrouping' );
		$method->setAccessible( true );
		
		try {
			$method->invoke( $this->resultSet );
		} catch ( Exception $e ) { }
		
		$this->assertInstanceOf( 
				'Exception', 
				$e,
				'Wikia\Search\ResultSet\Grouping::getHostGrouping should throw an exception if called in a situation where we are not grouping results'
		);
	}
	
	/**
	 * @covers Wikia\Search\ResultSet\Grouping::getHostGrouping
	 */
	public function testGetHostGroupingWithoutHostGrouping() {
		$this->prepareMocks( array(), array(), array( 'getGrouping' ) );
		
		$mockGrouping = $this->getMockBuilder( 'Solarium_Result_Select_Grouping' )
							->disableOriginalConstructor()
							->setMethods( array( 'getGroup' ) )
							->getMock();
		
		$this->searchResult
			->expects	( $this->at( 0 ) )
			->method	( 'getGrouping' )
			->will		( $this->returnValue( $mockGrouping ) )
		;
		$mockGrouping
			->expects	( $this->at( 0 ) )
			->method	( 'getGroup' )
			->with		( 'host' )
			->will		( $this->returnValue( null ) )
		;
		
		$method = new ReflectionMethod( 'Wikia\Search\ResultSet\Grouping', 'getHostGrouping' );
		$method->setAccessible( true );
		
		try {
			$method->invoke( $this->resultSet );
		} catch ( Exception $e ) { }
		
		$this->assertInstanceOf( 
				'Exception', 
				$e,
				'Wikia\Search\ResultSet\Grouping::getHostGrouping should throw an exception if called in a situation where we are not grouping results by host'
		);
	}
	
	/**
	 * @covers Wikia\Search\ResultSet\Grouping::getHostGrouping
	 */
	public function testGetHostGroupingWorks() {
		
		$this->prepareMocks( array(), array(), array( 'getGrouping' ) );
		
		$mockGrouping = $this->getMockBuilder( 'Solarium_Result_Select_Grouping' )
							->disableOriginalConstructor()
							->setMethods( array( 'getGroup' ) )
							->getMock();
		
		$mockFieldGroup = $this->getMockBuilder( 'Solarium_Result_Select_Grouping_FieldGroup' )
							->disableOriginalConstructor()
							->setMethods( array( 'getValueGroups' ) )
							->getMock();
		
		$this->searchResult
			->expects	( $this->at( 0 ) )
			->method	( 'getGrouping' )
			->will		( $this->returnValue( $mockGrouping ) )
		;
		$mockGrouping
			->expects	( $this->at( 0 ) )
			->method	( 'getGroup' )
			->with		( 'host' )
			->will		( $this->returnValue( $mockFieldGroup ) )
		;
		
		$method = new ReflectionMethod( 'Wikia\Search\ResultSet\Grouping', 'getHostGrouping' );
		$method->setAccessible( true );
		
		$this->assertEquals(
				$mockFieldGroup,
				$method->invoke( $this->resultSet ),
				'Wikia\Search\ResultSet\Grouping::getHostGrouping should return an instance of Solarium_Result_Select_Grouping_FieldGroup'
		);
	}
	
	public function testConfigure() {
		$dcMethods = array( 'getResult', 'getConfig', 'getService', 'getParent', 'getMetaposition' );
		$dc = $this->getMockBuilder( 'Wikia\Search\ResultSet\DependencyContainer' )
		           ->disableOriginalConstructor()
		           ->setMethods( $dcMethods )
		           ->getMock();
		
		$mockGrouping = $this->getMockBuilder( 'Wikia\Search\ResultSet\Grouping' )
		                     ->disableOriginalConstructor()
		                     ->setMethods( array( 'setResultsFromHostGrouping', 'configureHeaders' ) )
		                     ->getMock();
		foreach ( $dcMethods as $method ) {
			$dc
			    ->expects( $this->once() )
			    ->method ( $method )
			;
		}
		$mockGrouping
		    ->expects( $this->once() )
		    ->method ( 'setResultsFromHostGrouping' )
		    ->will   ( $this->returnValue( $mockGrouping ) )
		;
		$mockGrouping
		    ->expects( $this->once() )
		    ->method ( 'configureHeaders' )
		    ->will   ( $this->returnValue( $mockGrouping ) )
		;
		$configure = new ReflectionMethod( 'Wikia\Search\ResultSet\Grouping', 'configure' );
		$configure->setAccessible( true );
		$configure->invoke( $mockGrouping, $dc );
	}
	
	/**
	 * @covers Wikia\Search\ResultSet\MatchGrouping::configure
	 */
	public function testMatchGroupingConfigure() {
		$dcMethods = array( 'getResult', 'getConfig', 'getService', 'getParent', 'getMetaposition' );
		$dc = $this->getMockBuilder( 'Wikia\Search\ResultSet\DependencyContainer' )
		           ->disableOriginalConstructor()
		           ->setMethods( array_merge( $dcMethods, ['getWikiMatch'] ) )
		           ->getMock();
		
		$mockWikiMatch = $this->getMockBuilder( 'Wikia\Search\Match\Wiki' )
		                      ->disableOriginalConstructor()
		                      ->setMethods( array( 'getResult' ) )
		                      ->getMock();
		
		$mockResult = $this->getMock( 'Wikia\Search\Result', array( 'getFields' ) );
		
		$mockGrouping = $this->getMockBuilder( 'Wikia\Search\ResultSet\MatchGrouping' )
		                     ->disableOriginalConstructor()
		                     ->setMethods( array( 'addHeaders' ) )
		                     ->getMock();
		
		$fields = array( 'id' => 'who cares' );
		
		foreach ( $dcMethods as $method ) {
			$dc
			    ->expects( $this->once() )
			    ->method ( $method )
			;
		}
		$dc
		    ->expects( $this->once() )
		    ->method ( 'getWikiMatch' )
		    ->will   ( $this->returnValue( $mockWikiMatch ) )
		;
		$mockWikiMatch
		    ->expects( $this->once() )
		    ->method ( 'getResult' )
		    ->will   ( $this->returnValue( $mockResult ) )
		;
		$mockResult
		    ->expects( $this->once() )
		    ->method ( 'getFields' )
		    ->will   ( $this->returnValue( $fields ) )
		;
		$mockGrouping
		    ->expects( $this->once() )
		    ->method ( 'addHeaders' )
		    ->with   ( $fields )
		    ->will   ( $this->returnValue( $mockGrouping ) )
		;
		$configure = new ReflectionMethod( 'Wikia\Search\ResultSet\MatchGrouping', 'configure' );
		$configure->setAccessible( true );
		$configure->invoke( $mockGrouping, $dc );
	}
	
	/**
	 * @covers Wikia\Search\ResultSet\Grouping::getTopPages
	 */
	public function testGetTopPages() {
		
		$this->prepareMocks( [ 'getHeader' ], [], [], [ 'getMainPageIdForWikiId' ] );
		$mockDmService = $this->getMock( 'DataMartService', [ 'getTopArticlesByPageview' ] );
		
		$topPages = [ 1, 2, 3, 4 ];
		$this->resultSet
		    ->expects( $this->once() )
		    ->method ( 'getHeader' )
		    ->with   ( 'wid' )
		    ->will   ( $this->returnValue( 123 ) )
		;
		$mockDmService
		    ->staticExpects( $this->once() )
		    ->method ( 'getTopArticlesByPageView' )
		    ->will   ( $this->returnValue( [ 1 => [], 2 => [], 5 => [], 3 => [], 4 => [] ] ) )
		;
		$this->service
		    ->expects( $this->once() )
		    ->method ( 'getMainPageIdForWikiId' )
		    ->will   ( $this->returnValue( 5 ) )
		;
		$this->proxyClass( 'DataMartService', $mockDmService );
		$this->mockApp();
		$this->assertEquals(
				$topPages,
				$this->resultSet->getTopPages()
		);
		$this->assertAttributeEquals(
				$topPages,
				'topPages',
				$this->resultSet
		);
	}
	
	
	/**
	 * @covers Wikia\Search\ResultSet\Grouping::setResultsFromHostGrouping
	 *
	public function testSetResultsFromHostGrouping() {
		$mockFieldGroup = $this->getMockBuilder( 'Solarium_Result_Select_Grouping_FieldGroup' )
							->disableOriginalConstructor()
							->setMethods( array( 'getValueGroups' ) )
							->getMock();
		
		$mockGrouping = $this->getMockBuilder( 'Wikia\Search\ResultSet\Grouping' )
		                     ->disableOriginalConstructor()
		                     ->setMethods( array( 'getHostGrouping', 'setResults' ) )
		                     ->getMock();
		
		$mockValueGroup = $this->getMockBuilder( 'Solarium_Result_Select_Grouping_ValueGroup' )
		                       ->disableOriginalConstructor()
		                       ->setMethods( array( 'getValue', 'getNumFound', 'getDocuments' ) )
		                       ->getMock();
		
		$metapos = new ReflectionProperty( 'Wikia\Search\ResultSet\Grouping', 'metaposition' );
		$metapos->setAccessible( true );
		$metapos->setValue( $mockGrouping, 0 );
		
		$mockGrouping
		    ->expects( $this->once() )
		    ->method ( 'getHostGrouping' )
		    ->will   ( $this->returnValue( $mockFieldGroup ) )
		;
		$mockFieldGroup
		    ->expects( $this->once() )
		    ->method ( 'getValueGroups' )
		    ->will   ( $this->returnValue( array( $mockValueGroup ) ) )
		;
		$mockValueGroup
		    ->expects( $this->once() )
		    ->method ( 'getValue' )
		    ->will   ( $this->returnValue( 'foo.wikia.com' ) )
		;
		$mockValueGroup
		    ->expects( $this->once() )
		    ->method ( 'getNumFound' )
		    ->will   ( $this->returnValue( 20 ) )
		;
		$mockValueGroup
		    ->expects( $this->once() )
		    ->method ( 'getDocuments' )
		    ->will   ( $this->returnValue( array( 'doc' ) ) )
		;
		$mockGrouping
		    ->expects( $this->once() )
		    ->method ( 'setResults' )
		    ->with   ( array( 'doc' ) )
		;
		
		$set = new ReflectionMethod( 'Wikia\Search\ResultSet\Grouping', 'setResultsFromHostGrouping' );
		$set->setAccessible( true );
		$this->assertEquals(
				$mockGrouping,
				$set->invoke( $mockGrouping )
		);
		$host = new ReflectionProperty( 'Wikia\Search\ResultSet\Grouping', 'host' );
		$host->setAccessible( true );
		$this->assertEquals(
				'foo.wikia.com',
				$host->getValue( $mockGrouping )
		);
		$found = new ReflectionProperty( 'Wikia\Search\ResultSet\Grouping', 'resultsFound' );
		$found->setAccessible( true );
		$this->assertEquals(
				20,
				$found->getValue( $mockGrouping )
		);
	}*/
	
	/**
	 * @covers Wikia\Search\ResultSet\Grouping::configureHeaders
	 */
	public function testConfigureHeaders() {
		$mockResult = $this->getMock( 'Wikia\Search\Result', array( 'offsetGet', 'getFields' ) );
		$results = new \ArrayIterator( array( $mockResult ) );
		$this->prepareMocks( array( 'addHeaders', 'setHeader', 'getHeader', 'getDescription' ), array(), array(), array( 'getSimpleMessage', 'getWikiIdByHost', 'getStatsInfoForWikiId', 'getVisualizationInfoForWikiId', 'getGlobalForWiki', 'getHubForWikiId' ) );
		$fields = array( 'id' => 123 );
		$vizInfo = array( 'description' => 'yup', 'lang' => 'get rid of me' );
		$mockResult
		    ->expects( $this->at( 0 ) )
		    ->method ( 'offsetGet' )
		    ->with   ( 'wid' )
		    ->will   ( $this->returnValue( 123 ) )
		;
		$resultsRefl = new ReflectionProperty( 'Wikia\Search\ResultSet\Grouping', 'results' );
		$resultsRefl->setAccessible( true );
		$resultsRefl->setValue( $this->resultSet, $results );
		$mockResult
		    ->expects( $this->at( 1 ) )
		    ->method ( 'getFields' )
		    ->will   ( $this->returnValue( array( 'id' => 123 ) ) )
		;
		$this->service
		    ->expects( $this->at( 1 ) )
		    ->method ( 'getVisualizationInfoForWikiId' )
		    ->with   ( 123 )
		    ->will   ( $this->returnValue( $vizInfo ) )
		;
		$this->service
		    ->expects( $this->at( 2 ) )
		    ->method ( 'getStatsInfoForWikiId' )
		    ->with   ( 123 )
		    ->will   ( $this->returnValue( array( 'users_count' => 100 ) ) )
		;
		$mockResult
		    ->expects( $this->once() )
		    ->method ( 'getFields' )
		    ->will   ( $this->returnValue( $fields ) )
		;
		$this->resultSet
		    ->expects( $this->at( 0 ) )
		    ->method ( 'addHeaders' )
		    ->with   ( $fields )
		    ->will   ( $this->returnValue( $this->resultSet ) )
		;
		$this->resultSet
		    ->expects( $this->at( 1 ) )
		    ->method ( 'addHeaders' )
		    ->with   ( [ 'description' => 'yup' ] ) // note we dropped the lang
		    ->will   ( $this->returnValue( $this->resultSet ) )
		;
		$this->resultSet
		    ->expects( $this->at( 2 ) )
		    ->method ( 'addHeaders' )
		    ->with   ( array( 'users_count' => 100 ) )
		    ->will   ( $this->returnValue( $this->resultSet ) )
		;
		$this->service
		    ->expects( $this->any() )
		    ->method ( 'getGlobalForWiki' )
		    ->with   ( 'wgSitename', 123 )
		    ->will   ( $this->returnValue( "my title" ) )
		;
		$this->resultSet
		    ->expects( $this->at( 3 ) )
		    ->method ( 'setHeader' )
		    ->with   ( "wikititle", "my title" )
		    ->will   ( $this->returnValue( $this->resultSet ) )
		;
		$this->service
		    ->expects( $this->any() )
		    ->method ( 'getHubForWikiId' )
		    ->with   ( 123 )
		    ->will   ( $this->returnValue( "Edutainment" ) )
		;
		$this->resultSet
		    ->expects( $this->at( 4 ) )
		    ->method ( 'setHeader' )
		    ->with   ( "title", "my title" )
		    ->will   ( $this->returnValue( $this->resultSet ) )
		;
		$this->resultSet
		    ->expects( $this->at( 5 ) )
		    ->method ( 'setHeader' )
		    ->with   ( "hub", "Edutainment" )
		    ->will   ( $this->returnValue( $this->resultSet ) )
		;
		$this->resultSet
		    ->expects( $this->at( 6 ) )
		    ->method ( 'getDescription' )
		    ->will   ( $this->returnValue( "we already got a descriptiopn" ) )
		;
		$this->service
		    ->expects( $this->never() )
		    ->method ( 'getSimpleMessage' )
		;
		$conf = new ReflectionMethod( 'Wikia\Search\ResultSet\Grouping', 'configureHeaders' );
		$conf->setAccessible( true );
		$this->assertEquals(
				$this->resultSet,
				$conf->invoke( $this->resultSet )
		);
	}
	
	/**
	 * @covers Wikia\Search\ResultSet\Grouping::configureHeaders
	 */
	public function testConfigureHeadersWithDegenerateCases() {
		$mockResult = $this->getMock( 'Wikia\Search\Result', array( 'offsetGet', 'getFields' ) );
		$results = new \ArrayIterator( array( $mockResult ) );
		$this->prepareMocks( array( 'addHeaders', 'setHeader', 'getHeader', 'getDescription' ), array(), array(), array( 'getSimpleMessage', 'getWikiIdByHost', 'getStatsInfoForWikiId', 'getVisualizationInfoForWikiId', 'getGlobalForWiki', 'getHubForWikiId' ) );
		$fields = array( 'id' => 123 );
		$vizInfo = array( 'description' => 'yup' );
		$mockResult
		    ->expects( $this->at( 0 ) )
		    ->method ( 'offsetGet' )
		    ->with   ( 'wid' )
		    ->will   ( $this->returnValue( 123 ) )
		;
		$resultsRefl = new ReflectionProperty( 'Wikia\Search\ResultSet\Grouping', 'results' );
		$resultsRefl->setAccessible( true );
		$resultsRefl->setValue( $this->resultSet, $results );
		$mockResult
		    ->expects( $this->at( 1 ) )
		    ->method ( 'getFields' )
		    ->will   ( $this->returnValue( array( 'id' => 123 ) ) )
		;
		$this->service
		    ->expects( $this->at( 1 ) )
		    ->method ( 'getVisualizationInfoForWikiId' )
		    ->with   ( 123 )
		    ->will   ( $this->returnValue( $vizInfo ) )
		;
		$this->service
		    ->expects( $this->at( 2 ) )
		    ->method ( 'getStatsInfoForWikiId' )
		    ->with   ( 123 )
		    ->will   ( $this->returnValue( array( 'users_count' => 100 ) ) )
		;
		$mockResult
		    ->expects( $this->once() )
		    ->method ( 'getFields' )
		    ->will   ( $this->returnValue( $fields ) )
		;
		$this->resultSet
		    ->expects( $this->at( 0 ) )
		    ->method ( 'addHeaders' )
		    ->with   ( $fields )
		    ->will   ( $this->returnValue( $this->resultSet ) )
		;
		$this->resultSet
		    ->expects( $this->at( 1 ) )
		    ->method ( 'addHeaders' )
		    ->with   ( $vizInfo )
		    ->will   ( $this->returnValue( $this->resultSet ) )
		;
		$this->resultSet
		    ->expects( $this->at( 2 ) )
		    ->method ( 'addHeaders' )
		    ->with   ( array( 'users_count' => 100 ) )
		    ->will   ( $this->returnValue( $this->resultSet ) )
		;
		$this->service
		    ->expects( $this->any() )
		    ->method ( 'getGlobalForWiki' )
		    ->with   ( 'wgSitename', 123 )
		    ->will   ( $this->returnValue( false ) )
	    ;
		$mockResult
		    ->expects( $this->at( 2 ) )
		    ->method ( 'offsetGet' )
		    ->with   ( \Wikia\Search\Utilities::field( 'wikititle' ) )
		    ->will   ( $this->returnValue( "my title" ) )
		;
		$this->resultSet
		    ->expects( $this->at( 3 ) )
		    ->method ( 'setHeader' )
		    ->with   ( "wikititle", "my title" )
		    ->will   ( $this->returnValue( $this->resultSet ) )
		;
		$this->service
		    ->expects( $this->any() )
		    ->method ( 'getHubForWikiId' )
		    ->with   ( 123 )
		    ->will   ( $this->returnValue( "Edutainment" ) )
		;
		$this->resultSet
		    ->expects( $this->at( 4 ) )
		    ->method ( 'setHeader' )
		    ->with   ( "title", "my title" )
		    ->will   ( $this->returnValue( $this->resultSet ) )
		;
		$this->resultSet
		    ->expects( $this->at( 5 ) )
		    ->method ( 'setHeader' )
		    ->with   ( "hub", "Edutainment" )
		    ->will   ( $this->returnValue( $this->resultSet ) )
		;
		$this->resultSet
		    ->expects( $this->at( 6 ) )
		    ->method ( 'getDescription' )
		    ->will   ( $this->returnValue( "" ) )
		;
		$this->service
		    ->expects( $this->once() )
		    ->method ( 'getSimpleMessage' )
		    ->with   ( 'wikiasearch2-crosswiki-description', array( 'my title' ) )
		    ->will   ( $this->returnValue( "description message" ) )
		;
		$this->resultSet
		    ->expects( $this->at( 7 ) )
		    ->method ( 'setHeader' )
		    ->with   ( 'desc', "description message" )
		;
		$conf = new ReflectionMethod( 'Wikia\Search\ResultSet\Grouping', 'configureHeaders' );
		$conf->setAccessible( true );
		$this->assertEquals(
				$this->resultSet,
				$conf->invoke( $this->resultSet )
		);
	}
	
	/**
	 * @covers Wikia\Search\ResultSet\Grouping::getParent
	 */
	public function testGetParent() {
		$resultSet = $this->getMockBuilder( '\Wikia\Search\ResultSet\Grouping' )
		                  ->disableOriginalConstructor()
		                  ->setMethods( null )
		                  ->getMock();
		
		$mockGroupingSet = $this->getMockBuilder( '\Wikia\Search\ResultSet\GroupingSet' )
		                        ->disableOriginalConstructor()
		                        ->getMock();
		
		$resultsFound = new ReflectionProperty( 'Wikia\Search\ResultSet\Grouping', 'parent' );
		$resultsFound->setAccessible( true );
		$resultsFound->setValue( $resultSet, $mockGroupingSet );
		$this->assertEquals(
				$mockGroupingSet,
				$resultSet->getParent()
		);
	}
	
	/**
	 * @covers Wikia\Search\ResultSet\Grouping::getId
	 */
	public function testGetId() {
		$resultSet = $this->getMockBuilder( '\Wikia\Search\ResultSet\Grouping' )
		                  ->disableOriginalConstructor()
		                  ->setMethods( null )
		                  ->getMock();
		$resultsFound = new ReflectionProperty( 'Wikia\Search\ResultSet\Grouping', 'host' );
		$resultsFound->setAccessible( true );
		$resultsFound->setValue( $resultSet, 'foo.wikia.com' );
		$this->assertEquals(
				'foo.wikia.com',
				$resultSet->getId()
		);
	}
	
	/**
	 * @covers Wikia\Search\ResultSet\Grouping::toArray
	 */
	public function testToArray() {
		$resultSet = $this->getMockBuilder( '\Wikia\Search\ResultSet\Grouping' )
		                  ->disableOriginalConstructor()
		                  ->setMethods( array( 'getHeader' ) )
		                  ->getMock();
		$array = array( 'foo' => 'bar' );
		$resultSet
		    ->expects( $this->once( 'getHeader' ) )
		    ->method ( 'getHeader' )
		    ->will   ( $this->returnValue( $array ) )
		;
		$this->assertEquals(
				$array,
				$resultSet->toArray()
		);
	}

	/**
	 * @covers Wikia\Search\ResultSet\Grouping::getArticlesCountMsg
	 */
	public function testGetArticlesCountMsg() {
		$count = 1000;
		$msg = 'get_msg_result';

		$this->prepareMocks( array( 'getHeader' ), array(), array(), array( 'shortNumForMsg' ) );
		$this->resultSet
			->expects( $this->once() )
			->method( 'getHeader' )
			->with( 'articles_count' )
			->will( $this->returnValue( $count ) )
		;

		$this->service
			->expects( $this->once() )
			->method( 'shortNumForMsg' )
			->with( $count )
			->will( $this->returnValue( $msg ) )
		;

		$this->assertEquals( $msg, $this->resultSet->getArticlesCountMsg() );
	}

	/**
	 * @covers Wikia\Search\ResultSet\Grouping::getImagesCountMsg
	 */
	public function testGetImagesCountMsg() {
		$count = 1000;
		$msg = 'get_msg_result';

		$this->prepareMocks( array( 'getHeader' ), array(), array(), array( 'shortNumForMsg' ) );
		$this->resultSet
			->expects( $this->once() )
			->method( 'getHeader' )
			->with( 'images_count' )
			->will( $this->returnValue( $count ) )
		;

		$this->service
			->expects( $this->once() )
			->method( 'shortNumForMsg' )
			->with( $count )
			->will( $this->returnValue( $msg ) )
		;

		$this->assertEquals( $msg, $this->resultSet->getImagesCountMsg() );
	}

	/**
	 * @covers Wikia\Search\ResultSet\Grouping::getVideosCountMsg
	 */
	public function testGetVideosCountMsg() {
		$count = 1000;
		$msg = 'get_msg_result';

		$this->prepareMocks( array( 'getHeader' ), array(), array(), array( 'shortNumForMsg' ) );
		$this->resultSet
			->expects( $this->once() )
			->method( 'getHeader' )
			->with( 'videos_count' )
			->will( $this->returnValue( $count ) )
		;

		$this->service
			->expects( $this->once() )
			->method( 'shortNumForMsg' )
			->with( $count )
			->will( $this->returnValue( $msg ) )
		;

		$this->assertEquals( $msg, $this->resultSet->getVideosCountMsg() );
	}
}