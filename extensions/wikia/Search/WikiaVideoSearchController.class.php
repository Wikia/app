<?php

class WikiaVideoSearchController extends WikiaSpecialPageController {

	/**
	 * Responsible for search queries
	 * @var WikiaSearch
	 */
	private $wikiaSearch;

	/**
	 * Handles dependency-building and special page routing before calling controller actions 
	 */
	public function __construct() {
        // note: this is required since we haven't constructed $this->wg yet
		global $wgWikiaSearchIsDefault;
		// Solarium_Client dependency handled in class constructor call in WikiaSearch.setup.php
		$this->wikiaSearch			= F::build('WikiaSearch'); 

		parent::__construct( 'VideoSearch', 'VideoSearch', false );
	}
	
	
	public function index() {
		$this->submittedTitle  = '';
		$this->submittedPageId = '';
		if ( ($title = $this->getVal( 'pagetitle', false )) && (!empty($title)) ) {
			$this->submittedTitle = $title;
			$this->title = F::build( 'Title', array( $title ), 'newFromText' );
		} else if ( $pageId = $this->getVal( 'pageid', false ) ) {
			$this->submittedPageId = $pageId;
			$this->title = F::build( 'Title', array( $pageId ), 'newFromId' );
		}
		
		$this->wikiMltResults = $this->getRelatedVideosForWiki() ;
		$this->wikiSearchResults = $this->getRelatedVideosBySearchForWiki();
		
		if ( isset( $this->title ) ) {
			$this->mltResults = $this->getRelatedVideosForPage();
			
			$this->searchResults = $this->getRelatedVideosBySearchForPage();
			
			$this->combinedSearchResults = $this->getRelatedVideosBySearchForPageAndWiki();
		}
		
		$this->suggestedVideoResults = $this->getSuggestedVideoResults();
		$this->relatedVideoServiceResults = $this->getRelatedVideoServiceResults();
	}
	
	protected function getRelatedVideosForPage() {
		
		$searchConfig = F::build( 'WikiaSearchConfig' );
		$searchConfig	->setCityId	( $this->wg->CityId )
						->setStart	( 0 )
						->setSize	( 10 )
		;

		$relatedVideosParams = array( 'video_wiki_only'=>true, 'start'=>0, 'size'=>20 );

		$searchConfig->setPageId( $this->title->getArticleID() );

		return $this->wikiaSearch->getRelatedVideos( $searchConfig );
	}
	
	protected function getRelatedVideosBySearchForPage( ) {
		
		$searchConfig = F::build( 'WikiaSearchConfig' );
		$searchConfig	->setCityId	( WikiaSearch::VIDEO_WIKI_ID )
						->setStart	( 0 )
						->setSize	( 10 )
		;

		$relatedVideosParams = array( 'video_wiki_only'=>true, 'start'=>0, 'size'=>20 );

		$searchConfig	->setQuery		( $this->title )
						->setVideoSearch( true )
						->setPageId		( false )
		;

		return $this->wikiaSearch->doSearch( $searchConfig );
	}
	
	protected function getRelatedVideosBySearchForWiki( ) {
		
		$searchConfig = F::build( 'WikiaSearchConfig' );
		$searchConfig	->setCityId	( WikiaSearch::VIDEO_WIKI_ID )
						->setStart	( 0 )
						->setSize	( 10 )
		;

		$relatedVideosParams = array( 'video_wiki_only'=>true, 'start'=>0, 'size'=>20 );
		
		$this->wikiQuery = preg_replace( '/ wiki\b/i', '', $this->wg->Sitename );
		
		$searchConfig	->setQuery		( $this->wikiQuery ) 
						->setVideoSearch( true )
						->setPageId		( false )
		;
		
		return $this->wikiaSearch->doSearch( $searchConfig );
	}
	
	protected function getRelatedVideosBySearchForPageAndWiki( ) {
		
		$searchConfig = F::build( 'WikiaSearchConfig' );
		$searchConfig	->setCityId	( WikiaSearch::VIDEO_WIKI_ID )
						->setStart	( 0 )
						->setSize	( 10 )
		;

		$relatedVideosParams = array( 'video_wiki_only'=>true, 'start'=>0, 'size'=>20 );
		
		$this->combinedQuery = sprintf( '%s %s', $this->title, $this->wikiQuery );

		$searchConfig	->setQuery		( $this->combinedQuery )
						->setVideoSearch( true )
						->setPageId		( false )
		;

		return $this->wikiaSearch->doSearch( $searchConfig );
	}
	
	protected function getRelatedVideosForWiki( ) {
		$searchConfig = F::build( 'WikiaSearchConfig' );
		$searchConfig	->setCityId	( $this->wg->CityId )
						->setStart	( 0 )
						->setSize	( 10 )
		;

		$relatedVideosParams = array( 'video_wiki_only'=>true, 'start'=>0, 'size'=>20 );

		return $this->wikiaSearch->getRelatedVideos( $searchConfig );
	}
	
	protected function getSuggestedVideoResults() {
		
		$numFound = 0;
		
		if ( !empty( $this->title ) ) {
			$results = $this->getRelatedVideosForPage();
			$numFound = $results->getResultsFound();
		}
		
		if ( $numFound == 0 ) {
			$results = $this->getRelatedVideosForWiki( );
			$numFound = $results->getResultsFound();
		}
		
		if ( ( $numFound == 0 ) && !empty( $this->title ) ) {
			$results = $this->getRelatedVideoBySearchForPage();
		} else if ( $numFound == 0 && empty( $this->title ) ) {
			$results = $this->getRelatedVideosBySearchForWiki();
		}
		
		return (! empty( $results ) ) ? $results : F::build( 'WikiaSearchResultSet', array( F::build('Solarium_Result_Select_Empty'), F::build('WikiaSearchConfig') ) );
	}
	

	protected function getRelatedVideoServiceResults() {
		
		$rvService = F::build( 'RelatedVideosService' ); /* @var $rvService RelatedVideosService */

		$currentVideos = (! empty( $this->title ) ) ? $rvService->getRVforArticleId( $this->title->getArticleID() ) : array();
		// reorganize array to index by video title
		$currentVideosByTitle = array();
		$newResults = array();
		foreach( $currentVideos as $vid ) {
			$vid[WikiaSearch::field('title')] = $vid['title'];
			$vid['url'] = $vid['fullUrl'];
			$newResults[] = F::build( 'Solarium_Document_ReadWrite', array( $vid ) );
		}
		return array_slice( $newResults, 0, 10 );
	}
	
	
}