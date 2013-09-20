<?php

class VideoEmbedToolController extends WikiaController {

	const VIDEO_THUMB_DEFAULT_WIDTH = 160;
	const VIDEO_THUMB_DEFAULT_HEIGHT = 90;

	public function modal() {
		// empty on purpose
	}

	/*
	 *   Example of use:
	 *   http://harrypotter.jacek.wikia-dev.com/wikia.php?controller=VideoEmbedTool&method=getSuggestedVideos&svStart=0&svSize=5&articleId=15&format=json
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
				'caption' => wfMsg( 'vet-suggestions' ),
				'totalItemCount' => 0,
				'currentSetItemCount' => 0,
				'items' => array()
			);
			$this->response->setData( $result );
		}
		else {
			$request = $this->getRequest();
			$service = new VideoEmbedToolSearchService();
			$service->setStart( $request->getInt( 'svStart', 0 ) )
			        ->setLimit( $request->getInt( 'svSize', 20 ) )
			        ->setTrimTitle( $this->request->getInt( 'trimTitle', 0 ) );
			$response = $service->getSuggestionsForArticleId( $this->request->getInt('articleId', 0 ) );
			
			$result = array(
					'searchQuery' => $service->getSuggestionQuery(),
					'caption' => wfMsg( 'vet-suggestions' ),
					'totalItemCount' => $response['totalItemCount'],
					'nextStartFrom' => $response['nextStartFrom'],
					'currentSetItemCount' => count($response['items']),
					'items' => $response['items']
			);

			$this->response->setData( $result );
		}
	}

	public function search() {
		$request = $this->getRequest();
		$phrase = $request->getVal( 'phrase' );
		$searchType = $request->getVal( 'type', 'local' );
		
		$service = new VideoEmbedToolSearchService();
		$service->setTrimTitle( $this->request->getInt( 'trimTitle', 0 ) )
		        ->setStart( $request->getInt( 'svStart', 0 ) )
		        ->setLimit( max( [ 1, $request->getInt( 'svSize', 20 ) ] ) )
		        ->setRank( $request->getVal( 'order', 'default' ) )
		        ->setSearchType( $searchType );
		$response = $service->videoSearch( $phrase );

		$result = array (
			'searchQuery' => $phrase,
			'caption' => wfMsgExt( ( ( $searchType == 'premium' ) ? 'vet-search-results-WVL' : 'vet-search-results-local' ), array('parsemag'),  $response['totalItemCount'], $phrase ),
			'totalItemCount' => $response['totalItemCount'],
			'nextStartFrom' => $response['nextStartFrom'],
			'currentSetItemCount' => count( $response['items'] ),
			'items' => $response['items']
		);

		$this->response->setData( $result );
	}


	public function getEmbedCode() {

		$fileTitle = $this->request->getVal('fileTitle', '');
		$fileTitle = urldecode($fileTitle);
		$title = Title::newFromText($fileTitle, NS_FILE);
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

	/**
	 * Modify the description of a video
	 * @requestParam string title
	 * @requestParam string description
	 * @responseParam string status [success/fail]
	 * @responseParam string errMsg
	*/
	public function editDescription() {
		$title = urldecode( $this->request->getVal('title') );
		$title = Title::newFromText($title, NS_FILE);

		$description = urldecode( $this->request->getVal('description') );
		$vHelper = new VideoHandlerHelper();
		$status = $vHelper->setVideoDescription($title, $description);

		if ($status) {
			$this->status = 'success';
		} else {
			$this->status = 'fail';
			$this->errMsg = wfMessage('vet-description-save-error')->text();
		}
	}

}