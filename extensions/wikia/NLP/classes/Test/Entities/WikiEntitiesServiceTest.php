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
	 * @covers Wikia\NLP\Entities\WikiEntitiesService::registerEntitiesWithDFP
	 */
	public function testRegisterEntitiesWithDFP() {
		$service = $this->getMock( self::CLASSNAME, [ 'getMwService', 'getEntityList' ] );
		$mwService = $this->getMock( 'Wikia\Search\MediaWikiService', [ 'getGlobalWithDefault', 'setGlobal' ] );

		$entities = [ 'foo', 'bar', 'baz' ];
		$entitiesTruncated = $entities;
		$entities[] = str_pad('', 22, 'a' );
		$entitiesTruncated[] = substr( end( $entities ), 0, 20 );
		
		$kvs = 'foo=bar&baz=qux';
		
		$service
		    ->expects( $this->once() )
		    ->method ( 'getMwService' )
		    ->will   ( $this->returnValue( $mwService ) ) 
		;
		$service
		    ->expects( $this->once() )
		    ->method ( 'getEntityList' )
		    ->will   ( $this->returnValue( $entities ) )
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
		    ->with   ( 'wgDartCustomKeyValues', $kvs . '&' . http_build_query( [ 'wikientities' => $entitiesTruncated ] ) )
		;
		$this->assertTrue( $service->registerEntitiesWithDFP() );
	}
	
}