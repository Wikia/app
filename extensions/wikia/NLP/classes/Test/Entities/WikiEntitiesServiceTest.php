<?php
/**
 * Class definition for Wikia\NLP\Test\Entities\WikiEntitiesServiceTest
 */
namespace Wikia\NLP\Test\Entities;
use WikiaBaseTest;
/**
 * Tests Wikia\NLP\Test\Entities\WikiEntitiesService
 * @author relwell
 */
class WikiEntitiesServiceTest extends WikiaBaseTest
{
	
	public function setUp() {
		parent::setUp();
		require_once( __DIR__ . '/../../../WikiaNLP.setup.php' );
	}
	
	const CLASSNAME = 'Wikia\NLP\Entities\WikiEntitiesService';
	
	/**
	 * @covers Wikia\NLP\Entities\WikiEntitiesService::getEntityList
	 */
	public function testGetEntityList() {
		$service = $this->getMock( self::CLASSNAME, [ 'getMwService' ] );
		$mwService = $this->getMock( 'Wikia\Search\MediaWikiService', [ 'getGlobalWithDefault' ] );

		$entities = [ 'foo', 'bar', 'baz' ];
		
		$service
		    ->expects( $this->once() )
		    ->method ( 'getMwService' )
		    ->will   ( $this->returnValue( $mwService ) ) 
		;
		$mwService
		    ->expects( $this->once() )
		    ->method ( 'getGlobalWithDefault' )
		    ->with   ( 'WikiEntities', [] )
		    ->will   ( $this->returnValue( $entities ) )
		;
		$this->assertEquals(
				$entities,
				$service->getEntityList()
		);
	}
	

	/**
	 * @covers Wikia\NLP\Entities\WikiEntitiesService::getLdaTopics
	 */
	public function testGetLdaTopics() {
		$service = $this->getMock( self::CLASSNAME, [ 'getMwService' ] );
		$mwService = $this->getMock( 'Wikia\Search\MediaWikiService', [ 'getGlobalWithDefault' ] );

		$topics = [ 111, 235, 24 ];
		
		$service
		    ->expects( $this->once() )
		    ->method ( 'getMwService' )
		    ->will   ( $this->returnValue( $mwService ) ) 
		;
		$mwService
		    ->expects( $this->once() )
		    ->method ( 'getGlobalWithDefault' )
		    ->with   ( 'WikiLdaTopics', [] )
		    ->will   ( $this->returnValue( $topics ) )
		;
		$this->assertEquals(
				$topics,
				$service->getLdaTopics()
		);
	}
	
	/**
	 * @covers Wikia\NLP\Entities\WikiEntitiesService::registerEntitiesWithDFP
	 */
	public function testLdaTopicsWithDFP() {
		$service = $this->getMock( self::CLASSNAME, [ 'getMwService', 'getLdaTopics' ] );
		$mwService = $this->getMock( 'Wikia\Search\MediaWikiService', [ 'getGlobalWithDefault', 'setGlobal' ] );

		$topics = [111, 222, 333, 444, 555, 666];
		$kvs = 'foo=bar;baz=qux';
		
		$service
		    ->expects( $this->once() )
		    ->method ( 'getMwService' )
		    ->will   ( $this->returnValue( $mwService ) ) 
		;
		$service
		    ->expects( $this->once() )
		    ->method ( 'getLdaTopics' )
		    ->will   ( $this->returnValue( $topics ) )
		;
		$mwService
		    ->expects( $this->once() )
		    ->method ( 'getGlobalWithDefault' )
		    ->with   ( 'wgDartCustomKeyValues', '' )
		    ->will   ( $this->returnValue( $kvs ) )
		;
		$mwService
		    ->expects( $this->once() )
		    ->method ( 'setGlobal' )
		    ->with   ( 'wgDartCustomKeyValues', $kvs . ';wtpx=111;wtpx=222;wtpx=333;wtpx=444;wtpx=555' )
		;
		$this->assertTrue( $service->registerLdaTopicsWithDFP() );
	}
	
}