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
		if ( $this->wg->VETEnableSuggestions != true ) {
			// Return empty set if wgVETEnableSuggestions is not enabled
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
			$requestedFields   = $wikiaSearchConfig->getRequestedFields();
			$requestedFields[] = 'pageid';
			$articleId         = $this->request->getInt('articleId', 0 );
			$article           = ( $articleId > 0 ) ? F::build( 'Article', array( $articleId ), 'newFromId' ) : null;
			$articleTitle      = ( $article !== null ) ? $article->getTitle() : '';
			$wikiTitleSansWiki = preg_replace( '/\bwiki\b/i', '', $this->wg->Sitename );
			
			$wikiaSearchConfig  ->setStart( $svStart )
								->setLength( $svSize*2 )   // fetching more results to make sure we will get desired number of results in the end
								->setCityID( WikiaSearch::VIDEO_WIKI_ID )
								->setRequestedFields( $requestedFields )
								->setIsVideo( true )
								->setNamespaces( array( NS_FILE ) );

			$wikiaSearchConfig->setQuery( $articleTitle . ' ' . $wikiTitleSansWiki );

			$search = F::build( 'WikiaSearch' );  /* @var $search WikiaSearch */
			 
			$response = $search->doSearch( $wikiaSearchConfig );
			
			if ( $response->getResultsFound() == 0 ) {
				$wikiaSearchConfig->setQuery( $articleTitle == '' ? $wikiTitleSansWiki : $articleTitle ); 
				$response = $search->doSearch( $wikiaSearchConfig );
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
			
			$requestedFields = $this->wg->ContLang->mCode == 'en' 
							? array( 'pageid' ) // get English for free
							: array( 'pageid', WikiaSearch::field( 'title', 'en' ), WikiaSearch::field( 'html', 'en' ) );
							  
			$wikiaSearchConfig->setQuery( $phrase )
							  ->setRequestedFields( array_merge( $wikiaSearchConfig->getRequestedFields(), $requestedFields ) );
			$search = F::build( 'WikiaSearch' );  /* @var $search WikiaSearch */

			$searchResults = $search->doSearch( $wikiaSearchConfig );
			$response = $this->processSearchResponse( $searchResults, $svStart, $svSize, $trimTitle );
		}

		$result = array (
			'caption' => $this->wf->MsgExt( ( ( $searchType == 'premium' ) ? 'vet-search-results-WVL' : 'vet-search-results-local' ), array('parsemag'),  $response['totalItemCount'], $phrase ),
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
			$singleVideoData['pageid'] = $result['pageid'];
			$singleVideoData['wid'] =  $result->getCityId();
			$singleVideoData['title'] = $result->getTitle();
			if( empty($singleVideoData['title']) || isset( $excludedVideos[ $singleVideoData['title'] ] ) ) {
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
		$totalItemCount = $response->getResultsFound();
		// sometimes we need to filter some videos out and when there is a small number of results
		// it's obvious that the number of results shown in the slider does not match
		// the number stated in the label about
		// luckily in this case - when there is only one page of results - we
		// can count the exact number of videos ourselves
		if (!$svStart && ( count( $data ) < $svSize ) ) $totalItemCount = count( $data );
		return array( 'totalItemCount' => $totalItemCount, 'nextStartFrom' => $nextStartFrom, 'items' => $data );	
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