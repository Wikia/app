<?php

class VideoEmbedToolSearchServiceTest extends WikiaBaseTest {
	
	/**
	 * @covers VideoEmbedToolSearchService::getSuggestionsForArticleId
	 */
	public function testGetSuggestionsForArticleId() {
		
		$mockService = $this->getMockBuilder( 'VideoEmbedToolSearchService' )
		                    ->disableOriginalConstructor()
		                    ->setMethods( [ 'setSuggestionQueryByArticleId', 'getConfig', 'postProcessSearchResponse', 'getExpectedFields', 'getFactory', 'getSuggestionQuery' ] )
		                    ->getMock();
		
		$mockConfig = $this->getMockBuilder( 'Wikia\Search\Config' )
		                   ->disableOriginalConstructor()
		                   ->setMethods( [ 'setCityId', 'setQuery', 'setVideoEmbedToolSearch' ] )
		                   ->getMock();
		
		$mockFactory = $this->getMockBuilder( 'Wikia\Search\QueryService\Factory' )
		                    ->disableOriginalConstructor()
		                    ->setMethods( [ 'getFromConfig' ] )
		                    ->getMock();
		
		$mockQueryService = $this->getMockBuilder( 'Wikia\Search\QueryService\Select\VideoEmbedTool' )
		                         ->disableOriginalConstructor()
		                         ->setMethods( [ 'searchAsApi' ] )
		                         ->getMock();
		$articleId = 123;
		$suggestionQuery = 'notorious BIG';
		$expectedFields = [ 'doesnt matter' ];
		$apiResponse = [ 'also doesnt matter' ];
		$serviceResponse = [ 'service response' ];
		$mockService
		    ->expects( $this->at( 0 ) )
		    ->method ( 'setSuggestionQueryByArticleid' )
		    ->with   ( $articleId )
		;
		$mockService
		    ->expects( $this->at( 1 ) )
		    ->method ( 'getConfig' )
		    ->will   ( $this->returnValue( $mockConfig ) )
		;
		$mockConfig
		    ->expects( $this->at( 0 ) )
		    ->method ( 'setCityId' )
		    ->with   ( Wikia\Search\QueryService\Select\Video::VIDEO_WIKI_ID )
		    ->will   ( $this->returnValue( $mockConfig ) )
		;
		$mockService
		    ->expects( $this->at( 2 ) )
		    ->method ( 'getSuggestionQuery' )
		    ->will   ( $this->returnValue( $suggestionQuery ) )
		;
		$mockConfig
		    ->expects( $this->at( 1 ) )
		    ->method ( 'setQuery' )
		    ->with   ( $suggestionQuery )
		    ->will   ( $this->returnValue( $mockConfig ) )
		;
		$mockConfig
		    ->expects( $this->at( 2 ) )
		    ->method ( 'setVideoEmbedToolSearch' )
		    ->with   ( true )
		    ->will   ( $this->returnValue( $mockConfig ) )
		;
		$mockService
		    ->expects( $this->at( 3 ) )
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
		    ->expects( $this->at( 4 ) )
		    ->method ( 'getExpectedFields' )
		    ->will   ( $this->returnValue( $expectedFields ) )
		;
		$mockQueryService
		    ->expects( $this->once() )
		    ->method ( 'searchAsApi' )
		    ->will   ( $this->returnValue( $apiResponse ) )
		;
		$mockService
		    ->expects( $this->at( 5 ) )
		    ->method ( 'postProcessSearchResponse' )
		    ->with   ( $apiResponse )
		    ->will   ( $this->returnValue( $serviceResponse ) )
		;
		$this->assertEquals(
				$serviceResponse,
				$mockService->getSuggestionsForArticleId( $articleId )
		);
	}
	
}