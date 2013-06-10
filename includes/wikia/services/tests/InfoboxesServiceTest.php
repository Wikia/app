<?php

class InfoboxesServiceTest extends WikiaBaseTest
{
	/**
	 * @covers InfoboxesService::getForPageIds
	 */
	public function testGetForPageIds() {
		$service = $this->getMock( 'InfoboxesService', [ 'setExpectedIds', 'getItemsFromSearchResponse', 'getSearchResponse' ] );
		
		$expectedIds = [ 1 ];
		$apiResponse = [ 'items' => [ '123_1' => [ 'foo' => 'bar' ] ] ];
		$response = [ 'items' => [ 1 => [ 'foo' => 'bar' ] ] ];
		
		$service
		    ->expects( $this->once() )
		    ->method ( 'setExpectedIds' )
		    ->with   ( $expectedIds )
		;
		$service
		    ->expects( $this->once() )
		    ->method ( 'getSearchResponse' )
		    ->will   ( $this->returnValue( $apiResponse ) )
		;
		$service
		    ->expects( $this->once() )
		    ->method ( 'getItemsFromSearchResponse' )
		    ->with   ( $apiResponse )
		    ->will   ( $this->returnValue( $response ) )
		;
		$this->assertEquals(
				$response,
				$service->getForPageIds( $expectedIds )
		);
	}
	
	/**
	 * @covers InfoboxesService::setExpectedIds
	 */
	public function testSetExpectedIds() {
		$service = new InfoboxesService();
		$ids = [ 1, 2, 3 ];
		$prop = new ReflectionProperty( 'InfoboxesService', 'mappedIds' );
		$prop->setAccessible( true );
		$prop->setValue( $service, [ 4, 5, 6 ] );
		$set = new ReflectionMethod( 'InfoboxesService', 'setExpectedIds' );
		$set->setAccessible( true );
		$this->assertAttributeEquals(
				[ 4, 5, 6 ],
				'mappedIds',
				$service
		);
		$this->assertEquals(
				$service,
				$set->invoke( $service, $ids )
		);
		$this->assertAttributeEquals(
				[],
				'mappedIds',
				$service,
				'Setting expected IDs on InfoboxesService should erase old mapped IDs'
		);
		$this->assertAttributeEquals(
				$ids,
				'expectedIds',
				$service
		);
	}
	
	/**
	 * @covers InfoboxesService::getIdQueries
	 */
	public function testGetIdQueries() {
		$mwService = $this->getMock( 'Wikia\Search\MediaWikiService', [ 'getWikiId' ] );
		
		$service = $this->getMock( 'InfoboxesService', [ 'getMappedIds', 'getMwService' ] );
		
		$mappedIds = [ 456 => [ 789, 234 ] ];
		
		$service
		    ->expects( $this->once() )
		    ->method ( 'getMwService' )
		    ->will   ( $this->returnValue( $mwService ) )
		;
		$mwService
		    ->expects( $this->once() )
		    ->method ( 'getWikiId' )
		    ->will   ( $this->returnValue( 123 ) )
		;
		$service
		    ->expects( $this->once() )
		    ->method ( 'getMappedIds' )
		    ->will   ( $this->returnValue( $mappedIds ) )
		;
		$get = new ReflectionMethod( 'InfoboxesService', 'getIdQueries' );
		$get->setAccessible( true );
		$this->assertEquals(
				[ Wikia\Search\Utilities::valueForField( 'id', '123_456' ) ],
				$get->invoke( $service )
		);
	}
	
	/**
	 * @covers InfoboxesService::getMappedIds
	 */
	public function testGetMappedIds() {
		$service = $this->getMock( 'InfoboxesService', [ 'getMwService' ] );
		$mwService = $this->getMock( 'Wikia\Search\MediaWikiService', [ 'getCanonicalPageIdFromPageId' ] );
		$this->assertAttributeEmpty(
				'mappedIds',
				$service
		);
		$expectedIds = [ 234, 456, 789 ];
		$mappedIds = [ 123 => [ 234, 456 ], 789 => [ 789 ] ];
		$service
		    ->expects( $this->once() )
		    ->method ( 'getMwService' )
		    ->will   ( $this->returnValue( $mwService ) )
		;
		$mwService
		    ->expects( $this->at( 0 ) )
		    ->method ( 'getCanonicalPageIdFromPageId' )
		    ->with   ( 234 )
		    ->will   ( $this->returnValue( 123 ) )
		;
		$mwService
		    ->expects( $this->at( 1 ) )
		    ->method ( 'getCanonicalPageIdFromPageId' )
		    ->with   ( 456 )
		    ->will   ( $this->returnValue( 123 ) )
		;
		$mwService
		    ->expects( $this->at( 2 ) )
		    ->method ( 'getCanonicalPageIdFromPageId' )
		    ->with   (  789 )
		    ->will   ( $this->returnValue( 789 ) )
		;
		$exp = new ReflectionProperty( 'InfoboxesService', 'expectedIds' );
		$exp->setAccessible( true );
		$exp->setValue( $service, $expectedIds );
		$get = new ReflectionMethod( 'InfoboxesService', 'getMappedIds' );
		$get->setAccessible( true );
		$this->assertEquals(
				$mappedIds,
				$get->invoke( $service )
		);
		// by invoking this here we ensure the "once" assertion for lazy-loading
		$this->assertAttributeEquals(
				$mappedIds,
				'mappedIds',
				$service
		);
	}
	
	/**
	 * @covers InfoboxesService::getItemsFromSearchResponse
	 */
	public function testGetItemsFromSearchResponse() {
		
		$service = $this->getMock( 'InfoboxesService', [ 'getMappedIds' ] );
		$mapped = [ 123 => [ 123 ], 234 => [ 456, 789 ], 987 => [ 889 ] ];
		$boxes = [ 'infobox_1 | foo | bar', 'infobox_2 | baz | qux' ];
		$ib = [ [ 'foo' => 'bar' ], [ 'baz' => 'qux' ] ];
		$result = [ 123 => $ib, 456 => $ib, 789 => $ib, 889 => [] ];
		$service
		    ->expects( $this->once() )
		    ->method ( 'getMappedIds' )
		    ->will   ( $this->returnValue( $mapped ) )
		;
		$searchResponse = array(
				'items' => array(
						'123_123' => [ 'pageid' => 123, 'infoboxes_txt' => $boxes ],
						'123_234' => [ 'pageid' => 234, 'infoboxes_txt' => $boxes ]
				)
		);
		$get = new ReflectionMethod( 'InfoboxesService', 'getItemsFromSearchResponse' );
		$get->setAccessible( true );
		$this->assertEquals(
				$result,
				$get->invoke( $service, $searchResponse )
		);
	}
	
	/**
	 * @covers InfoboxesService::getSearchResponse
	 */
	public function testGetSearchResponse() {
		$config = $this->getMock( 'Wikia\Search\Config', [ 'setDirectLuceneQuery', 'setRequestedFields', 'setQuery' ] );
		$service = $this->getMock( 'InfoboxesService', [ 'getIdQueries' ] );
		$factory = $this->getMock( 'Wikia\Search\QueryService\Factory', [ 'getFromConfig' ] );
		$queryService = $this->getMockBuilder( 'Wikia\Search\QueryService\Select\Lucene' )
		                     ->disableOriginalConstructor()
		                     ->setMethods( [ 'searchAsApi' ] )
		                     ->getMock();
		$expected = [ 'foo' => 'bar' ]; // doesn't really matter
		
		$config
		    ->expects( $this->at( 0 ) )
		    ->method ( 'setDirectLuceneQuery' )
		    ->with   ( true )
		    ->will   ( $this->returnValue( $config ) )
		;
		$config
		    ->expects( $this->at( 1 ) )
		    ->method ( 'setRequestedFields' )
		    ->with   ( [ 'pageid', 'infoboxes_txt' ] )
		    ->will   ( $this->returnValue( $config ) )
		;
		$service
		    ->expects( $this->once() )
		    ->method ( 'getIdQueries' )
		    ->will   ( $this->returnValue( [ 'id:123_456', 'id:123_789' ] ) )
		;
		$config
		    ->expects( $this->at( 2 ) )
		    ->method ( 'setQuery' )
		    ->with   ( 'id:123_456 OR id:123_789' )
		    ->will   ( $this->returnValue( $config ) )
		;
		$factory
		    ->expects( $this->once() )
		    ->method ( 'getFromConfig' )
		    //->with   ( $config ) // commented out due to wikiamockproxy malarkey
		    ->will   ( $this->returnValue( $queryService ) )
		;
		$queryService
		    ->expects( $this->once() )
		    ->method ( 'searchAsApi' )
		    ->with   ( [ 'pageid', 'infoboxes_txt' ], true )
		    ->will   ( $this->returnValue( $expected ) )
		;
		
		$this->mockClass( 'Wikia\Search\Config', $config );
		$this->mockClass( 'Wikia\Search\QueryService\Factory', $factory );
		$get = new ReflectionMethod( 'InfoboxesService', 'getSearchResponse' );
		$get->setAccessible( true );
		$this->assertEquals(
				$expected,
				$get->invoke( $service )
		);
	}
	
}