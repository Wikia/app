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
		
		if ( isset( $this->title ) ) {
			$this->mltResults = $this->getRelatedVideosForPage();
			
			$this->searchResults = $this->getRelatedVideosBySearchForPage();
		}
		
		$this->wikiMltResults = $this->getRelatedVideosForWiki( $this->wg->CityId );
		$this->wikiSearchResults = $this->getRelatedVideosBySearchForWiki( $this->wg->CityId );
	}
	
	protected function getRelatedVideosForPage() {
		
		$searchConfig = F::build( 'WikiaSearchConfig' );
		$searchConfig	->setCityId	( $this->wg->CityId )
						->setStart	( 0 )
						->setSize	( 20 )
		;

		$relatedVideosParams = array( 'video_wiki_only'=>true, 'start'=>0, 'size'=>20 );

		$searchConfig->setPageId( $this->title->getArticleID() );

		$searchResultSet = $this->wikiaSearch->getRelatedVideos( $searchConfig );

		return $this->prepareResultSet( $searchResultSet, $this->title->getArticleID() );
		
	}
	
	protected function getRelatedVideosBySearchForPage( ) {
		
		$searchConfig = F::build( 'WikiaSearchConfig' );
		$searchConfig	->setCityId	( WikiaSearch::VIDEO_WIKI_ID )
						->setStart	( 0 )
						->setSize	( 20 )
		;

		$relatedVideosParams = array( 'video_wiki_only'=>true, 'start'=>0, 'size'=>20 );

		$searchConfig	->setQuery		( $this->title )
						->setVideoSearch( true )
						->setPageId		( false )
		;

		$searchResultSet = $this->wikiaSearch->doSearch( $searchConfig );
		
		return $this->prepareResultSet( $searchResultSet, $this->title->getArticleID() );
		
	}
	
	protected function getRelatedVideosBySearchForWiki( $wid ) {
		
		$searchConfig = F::build( 'WikiaSearchConfig' );
		$searchConfig	->setCityId	( WikiaSearch::VIDEO_WIKI_ID )
						->setStart	( 0 )
						->setSize	( 20 )
		;

		$relatedVideosParams = array( 'video_wiki_only'=>true, 'start'=>0, 'size'=>20 );
		
		$this->wikiQuery = preg_replace( '/ wiki\b/i', '', $this->wg->Sitename );
		
		$searchConfig	->setQuery		( $this->wikiQuery ) 
						->setVideoSearch( true )
						->setPageId		( false )
		;
		
		$searchResultSet = $this->wikiaSearch->doSearch( $searchConfig );
		
		return $this->prepareResultSet( $searchResultSet );
		
	}
	
	protected function getRelatedVideosForWiki( $wid ) {
		$searchConfig = F::build( 'WikiaSearchConfig' );
		$searchConfig	->setCityId	( $wid )
						->setStart	( 0 )
						->setSize	( 20 )
		;

		$relatedVideosParams = array( 'video_wiki_only'=>true, 'start'=>0, 'size'=>20 );

		$searchResultSet = $this->wikiaSearch->getRelatedVideos( $searchConfig );

		return $this->prepareResultSet( $searchResultSet );
	}
	

	protected function prepareResultSet( $searchResultSet, $articleId = 0 ) {
		
		$rvService = F::build( 'RelatedVideosService' ); /* @var $rvService RelatedVideosService */

		$currentVideos = $articleId > 0 ? $rvService->getRVforArticleId( $articleId ) : array();
		// reorganize array to index by video title
		$currentVideosByTitle = array();
		foreach( $currentVideos as $vid ) {
			$currentVideosByTitle[$vid['title']] = $vid;
		}

		$response = array();
		foreach ( $searchResultSet as $document ) {
			
			list( $cityId, $id ) = explode( '_', $document['id'] );
			$globalTitle = F::build( 'GlobalTitle', array($id, $cityId), 'newFromId' );
			if ( !empty( $globalTitle ) ) {
				$title = $globalTitle->getText();
				if( isset( $currentVideosByTitle[$title] ) ) {
					// don't suggest videos that are already in RelatedVideos
					continue;
				}

				$response[ $document['url'] ] = $document->getFields();

				$rvService->inflateWithVideoData(
								$document->getFields(),
								$globalTitle,
								$this->getVal( 'videoWidth', 160 ),
								$this->getVal( 'videoHeight', 90 )
				);

			} else {
				unset( $response[ $document['url'] ] );
			}
		}
		
		return $response;
		
	}
	
	
}