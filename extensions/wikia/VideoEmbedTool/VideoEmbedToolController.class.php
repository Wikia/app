<?php

class VideoEmbedToolController extends WikiaController {

	const VIDEO_THUMB_DEFAULT_WIDTH = 160;
	const VIDEO_THUMB_DEFAULT_HEIGHT = 90;

	/*
	 *   Example of use:
	 *   http://harrypotter.jacek.wikia-dev.com/wikia.php?controller=VideoEmbedToolController&method=getSuggestedVideos&svStart=0&svSize=5&articleId=15&format=json
	 *   svStart     - offset
	 *   svSize      - limit
	 *   videoWidth  - thumbnail width
	 *   videoHeight - thumbnail height
	 *   articleId 	 - the suggestions should be related to this article
	 */
	public function getSuggestedVideos() {
		if ( $this->wg->vetEnableSuggestions != true ) {
			// Return empty set if wgVetEnableSuggestions is not enabled
			$result = array(
				'caption' => $this->wf->Msg( 'vet-suggestions' ),
				'totalItemCount' => 0,
				'currentSetItemCount' => 0,
				'items' => array()
			);
			$this->response->setData( $result );
		}
		else {
			$svStart = $this->request->getInt( 'svStart', 0 );
			$svSize = $this->request->getInt( 'svSize', 20 );
			$trimTitle = $this->request->getInt( 'trimTitle', 0 );

			$wikiaSearchConfig = F::build( 'WikiaSearchConfig' );  /* @var $wikiaSearchConfig WikiaSearchConfig */
			$wikiaSearchConfig  ->setStart( $svStart )
								->setLength( $svSize*2 )   // fetching more results to make sure we will get desired number of results in the end
								->setCityID( WikiaSearch::VIDEO_WIKI_ID );
			$articleId = $this->request->getInt('articleId', 0 );

			if ( $articleId > 0 ) {
				$wikiaSearchConfig->setPageId( $articleId );
			}

			$search = F::build( 'WikiaSearch' );  /* @var $search WikiaSearch */
			$response = $search->getRelatedVideos( $wikiaSearchConfig );

			if ( !$response->hasResults() && ( $articleId > 0 ) && ( $this->request->getVal('debug') != 1 ) ) {
				// if nothing for specify article, do general search
				$wikiaSearchConfig->setPageId( false );
				$response = $search->getRelatedVideos( $wikiaSearchConfig );
			}

			//TODO: fill $currentVideosByTitle array with unwated videos
			$currentVideosByTitle = array();

			$response = $this->processSearchResponse( $response, $svStart, $svSize, $trimTitle, $currentVideosByTitle );

			$result = array(
					'caption' => $this->wf->Msg( 'vet-suggestions' ),
					'totalItemCount' => 0,
					'nextStartFrom' => $response['nextStartFrom'],
					'currentSetItemCount' => count($response['items']),
					'items' => $response['items']
			);

			$this->response->setData( $result );
		}
	}

	public function search() {
		$svStart = $this->request->getInt( 'svStart', 0 );
		$svSize = $this->request->getInt( 'svSize', 20 );
		$trimTitle = $this->request->getInt( 'trimTitle', 0 );
		$phrase = $this->request->getVal( 'phrase' );
		$searchType = $this->request->getVal( 'type', 'local' );

		$svSize = $svSize < 1 ? 1 : $svSize;

		$wikiaSearchConfig = F::build( 'WikiaSearchConfig' );  /* @var $wikiaSearchConfig WikiaSearchConfig */
		$wikiaSearchConfig  ->setStart( $svStart )
							->setLength( $svSize*2 )   // fetching more results to make sure we will get desired number of results in the end
							->setVideoSearch( true )
							->setNamespaces( array( NS_FILE ) );

		if($searchType == 'premium') {
			$wikiaSearchConfig->setCityID( WikiaSearch::VIDEO_WIKI_ID );
		}
		else {
			$wikiaSearchConfig->setCityID( $this->wg->CityId );
		}

		if ( !empty( $phrase ) && strlen( $phrase ) > 0 ) {
			$wikiaSearchConfig->setQuery( $phrase );
			$search = F::build( 'WikiaSearch' );  /* @var $search WikiaSearch */
			$search->setNamespaces( array(NS_FILE) );

			$response = $this->processSearchResponse( $search->doSearch( $wikiaSearchConfig ), $svStart, $svSize, $trimTitle );
		}

		$result = array (
			'caption' => $this->wf->Msg( ( ( $searchType == 'premium' ) ? 'vet-search-results-WVL' : 'vet-search-results-local' ), array( $response['totalItemCount'], $phrase ) ),
			'totalItemCount' => $response['totalItemCount'],
			'nextStartFrom' => $response['nextStartFrom'],
			'currentSetItemCount' => count( $response['items'] ),
			'items' => $response['items']
		);

		$this->response->setData( $result );
	}

	/**
	 * left here for backward compatibility, consider using search() instead
	 * @deprecarted
	 */
	public function searchInVideoWiki() {
		$svStart = $this->request->getInt( 'svStart', 0 );
		$svSize = $this->request->getInt( 'svSize', 20 );
		$trimTitle = $this->request->getInt( 'trimTitle', 0 );
		$phrase = $this->request->getVal( 'phrase' );

		$response = $this->sendSelfRequest( 'search', array(
			'type' => 'premium',
			'svStart' => $svStart,
			'svSize' => $svSize,
			'trimTitle' => $trimTitle,
			'phrase' => $phrase
		));

		$this->response->setData( $response->getData() );
	}

	private function processSearchResponse( WikiaSearchResultSet $response, $svStart, $svSize, $trimTitle = false, $excludedVideos = array() ) {
		$data = array();
		$nextStartFrom = $svStart;
		foreach( $response  as $result ) {   /* @var $result WikiaSearchResult */
			$singleVideoData = array();
			$singleVideoData['pageid'] = $result->getVar("pageId");
			$singleVideoData['wid'] =  $result->getCityId();
			$singleVideoData['title'] = $result->getTitle();

			if( isset( $excludedVideos[ $singleVideoData['title'] ] ) ) {
				// don't suggest this video
				continue;
			}

			WikiaFileHelper::inflateArrayWithVideoData( $singleVideoData,
				Title::newFromText($singleVideoData['title'], NS_FILE),
				$this->request->getVal( 'videoWidth', self::VIDEO_THUMB_DEFAULT_WIDTH ),
				$this->request->getVal( 'videoHeight', self::VIDEO_THUMB_DEFAULT_HEIGHT ),
				true
			);

			if ( $trimTitle > 0 ) {
				$singleVideoData['title'] = mb_substr( $singleVideoData['title'], 0, $trimTitle );
			}

			if ( !empty( $singleVideoData['thumbnail'] ) && count( $data ) < $svSize  ) {
				$data[] = $singleVideoData;
			}

			$nextStartFrom++;
			if ( count( $data ) == $svSize ) break;
		}
		return array( 'totalItemCount' => $response->getResultsFound(), 'nextStartFrom' => $nextStartFrom, 'items' => $data );
	}

	public function getEmbedCode() {

		$fileTitle = $this->request->getVal('fileTitle', '');
		$fileTitle = urldecode($fileTitle);
		$title = F::build('Title', array($fileTitle, NS_FILE), 'newFromText');
		if ( !( $title instanceof Title ) ) {
			return;
		}

		$config = array(
			'contextWidth' => $this->request->getVal('width', 460),
			'maxHeight' => $this->request->getVal('height', 250)
		);

		$data = WikiaFileHelper::getMediaDetail( $title, $config );

		$this->response->setData( $data );
	}
}