<?php

/**
 * Class VideoEmbedToolSearchServiceTest
 *
 * @group MediaFeatures
 */
class VideoEmbedToolSearchServiceTest extends WikiaBaseTest {

	/**
	 * @covers VideoEmbedToolSearchService::videoSearch
	 */
	public function testVideoSearch() {
		
		$mockService = $this->getMockBuilder( 'VideoEmbedToolSearchService' )
		                    ->disableOriginalConstructor()
		                    ->setMethods( [ 'setSuggestionQueryByArticleId', 'getConfig', 'postProcessSearchResponse', 'getExpectedFields', 'getFactory', 'getSuggestionQuery' ] )
		                    ->getMock();
		
		$mockConfig = $this->getMockBuilder( 'Wikia\Search\Config' )
		                   ->disableOriginalConstructor()
		                   ->setMethods( [ 'setWikiId', 'setQuery', 'setVideoSearch', 'setRequestedFields' ] )
		                   ->getMock();
		
		$mockFactory = $this->getMockBuilder( 'Wikia\Search\QueryService\Factory' )
		                    ->disableOriginalConstructor()
		                    ->setMethods( [ 'getFromConfig' ] )
		                    ->getMock();
		
		$mockQueryService = $this->getMockBuilder( 'Wikia\Search\QueryService\Select\Dismax\Video' )
		                         ->disableOriginalConstructor()
		                         ->setMethods( [ 'searchAsApi' ] )
		                         ->getMock();
		
		$query = 'notorious BIG';
		$expectedFields = [ 'doesnt matter' ];
		$apiResponse = [ 'also doesnt matter' ];
		$serviceResponse = [ 'service response' ];
		$mockService
		    ->expects( $this->at( 1 ) )
		    ->method ( 'getConfig' )
		    ->will   ( $this->returnValue( $mockConfig ) )
		;
		$mockConfig
		    ->expects( $this->at( 0 ) )
		    ->method ( 'setVideoSearch' )
		    ->with   ( true )
		    ->will   ( $this->returnValue( $mockConfig ) )
		;
		$mockConfig
		    ->expects( $this->at( 1 ) )
		    ->method ( 'setQuery' )
		    ->with   ( $query )
		    ->will   ( $this->returnValue( $mockConfig ) )
		;
		$mockConfig
			->expects( $this->at( 2 ) )
			->method ( 'setRequestedFields' )
			->with   ( $expectedFields )
			->will   ( $this->returnValue( $mockConfig ) )
		;
		$mockService
		    ->expects( $this->at( 2 ) )
		    ->method ( 'getFactory' )
		    ->will   ( $this->returnValue( $mockFactory ) )
		;
		$mockFactory
		    ->expects( $this->once() )
		    ->method ( 'getFromConfig' )
		    ->with   ( $mockConfig )
		    ->will   ( $this->returnValue( $mockQueryService ) )
		;
		$mockService
		    ->expects( $this->at( 0 ) )
		    ->method ( 'getExpectedFields' )
		    ->will   ( $this->returnValue( $expectedFields ) )
		;
		$mockQueryService
		    ->expects( $this->once() )
		    ->method ( 'searchAsApi' )
		    ->will   ( $this->returnValue( $apiResponse ) )
		;
		$mockService
		    ->expects( $this->at( 3 ) )
		    ->method ( 'postProcessSearchResponse' )
		    ->with   ( $apiResponse )
		    ->will   ( $this->returnValue( $serviceResponse ) )
		;
		$this->assertEquals(
				$serviceResponse,
				$mockService->videoSearch( $query )
		);
	}
	
	/**
	 * @covers VideoEmbedToolSearchService::setSuggestionQueryByArticleId
	 */
	public function testSetSuggestionQueryByArticleIdWorks() {
		$mockService = $this->getMockBuilder( 'VideoEmbedToolSearchService' )
		                    ->disableOriginalConstructor()
		                    ->setMethods( [ 'getMwService', 'setSuggestionQuery' ] )
		                    ->getMock();
		
		$mockMwService = $this->getMockBuilder( 'Wikia\Search\MediaWikiService' )
		                      ->disableOriginalConstructor()
		                      ->setMethods( [ 'getTitleStringFromPageId', 'getCanonicalPageIdFromPageId' ] )
		                      ->getMock();
		
		$mockService
		    ->expects( $this->once() )
		    ->method ( 'getMwService' )
		    ->will   ( $this->returnValue( $mockMwService ) )
		;
		$mockMwService
		    ->expects( $this->once() )
		    ->method ( 'getCanonicalPageIdFromPageId' )
		    ->with   ( 321 )
		    ->will   ( $this->returnValue( 123 ) )
		;
		$mockMwService
		    ->expects( $this->once() )
		    ->method ( 'getTitleStringFromPageId' )
		    ->with   ( 123 )
		    ->will   ( $this->returnValue( 'foo' ) )
		;
		$mockService
		    ->expects( $this->once() )
		    ->method ( 'setSuggestionQuery' )
		    ->with   ( 'foo' )
		    ->will   ( $this->returnValue( $mockService ) )
		;
		$set = new ReflectionMethod( 'VideoEmbedToolSearchService', 'setSuggestionQueryByArticleId' );
		$set->setAccessible( true );
		$this->assertEquals(
				$mockService,
				$set->invoke( $mockService, 321 )
		);
	}
	
	/**
	 * @covers VideoEmbedToolSearchService::setSuggestionQueryByArticleId
	 */
	public function testSetSuggestionQueryByArticleIdBreaks() {
		$mockService = $this->getMockBuilder( 'VideoEmbedToolSearchService' )
		                    ->disableOriginalConstructor()
		                    ->setMethods( [ 'getMwService', 'setSuggestionQuery' ] )
		                    ->getMock();
		
		$mockMwService = $this->getMockBuilder( 'Wikia\Search\MediaWikiService' )
		                      ->disableOriginalConstructor()
		                      ->setMethods( [ 'getTitleStringFromPageId', 'getCanonicalPageIdFromPageId' ] )
		                      ->getMock();
		
		$mockException = $this->getMockBuilder( 'Exception' )
		                      ->disableOriginalConstructor()
		                      ->getMock();
		
		$mockService
		    ->expects( $this->once() )
		    ->method ( 'getMwService' )
		    ->will   ( $this->returnValue( $mockMwService ) )
		;
		$mockMwService
		    ->expects( $this->once() )
		    ->method ( 'getCanonicalPageIdFromPageId' )
		    ->with   ( 321 )
		    ->will   ( $this->throwException( $mockException ) )
		;
		$mockService
		    ->expects( $this->once() )
		    ->method ( 'setSuggestionQuery' )
		    ->with   ( '' )
		    ->will   ( $this->returnValue( $mockService ) )
		;
		$set = new ReflectionMethod( 'VideoEmbedToolSearchService', 'setSuggestionQueryByArticleId' );
		$set->setAccessible( true );
		$this->assertEquals(
				$mockService,
				$set->invoke( $mockService, 321 )
		);
	}
	
	/**
	 * @covers VideoEmbedToolSearchService::getSuggestionQuery
	 * @covers VideoEmbedToolSearchService::setSuggestionQuery
	 */
	public function testGetSetSuggestionQuery() {
		$vetSearch = new VideoEmbedToolSearchService();
		$this->assertAttributeEmpty(
				'suggestionQuery',
				$vetSearch
		);
		$vetSearch->setSuggestionQuery(
				'foo',
				$vetSearch
		);
		$this->assertAttributeEquals(
				'foo',
				'suggestionQuery',
				$vetSearch
		);
		$this->assertEquals(
				'foo',
				$vetSearch->getSuggestionQuery()
		);
	}
}
