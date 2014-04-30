<?php

/**
 * Class VideoEmbedToolController
 */
class VideoEmbedToolController extends WikiaController {

	const VIDEO_THUMB_DEFAULT_WIDTH = 160;
	const VIDEO_THUMB_DEFAULT_HEIGHT = 90;

	public function modal() {
		// empty on purpose
	}

	/**
	 * Looks for videos related to the current article
	 *
	 * Example of use:
	 *
	 *   http://harrypotter.jacek.wikia-dev.com/wikia.php?controller=VideoEmbedTool&method=getSuggestedVideos&svStart=0&svSize=5&articleId=15&format=json
	 *
	 * @requestParam svStart - offset
	 * @requestParam svSize - limit
	 * @requestParam trimTitle - Whether to trim the video title returned (boolean 1 or 0)
	 * @requestParam articleId - the suggestions should be related to this article
	 *
	 * @responseParam searchQuery
	 * @responseParam caption - Video caption
	 * @responseParam totalItemCount - Number of items available
	 * @responseParam nextStartFrom - The index for the next page of videos
	 * @responseParam currentSetItemCount - Number of items returned in the current page
	 * @responseParam items - Array of video suggestions
	 * @responseParam addMessage - A translated 'Add Video' message
	 */
	public function getSuggestedVideos() {
		if ( $this->wg->VETEnableSuggestions != true ) {
			// Return empty set if wgVETEnableSuggestions is not enabled
			$result = [
				'caption' => wfMessage( 'vet-suggestions' )->plain(),
				'totalItemCount' => 0,
				'currentSetItemCount' => 0,
				'items' => []
			];
			$this->response->setData( $result );
		} else {
			$request = $this->getRequest();
			$service = new VideoEmbedToolSearchService();
			$service->setStart( $request->getInt( 'svStart', 0 ) )
			        ->setLimit( $request->getInt( 'svSize', 20 ) )
			        ->setTrimTitle( $this->request->getInt( 'trimTitle', 0 ) );
			$response = $service->getSuggestionsForArticleId( $this->request->getInt('articleId', 0 ) );

			$result = [
					'searchQuery' => $service->getSuggestionQuery(),
					'caption' => wfMessage( 'vet-suggestions' )->plain(),
					'totalItemCount' => $response['totalItemCount'],
					'nextStartFrom' => $response['nextStartFrom'],
					'currentSetItemCount' => count($response['items']),
					'items' => $response['items'],
					'addMessage' => wfMessage('vet-add-from-preview')->plain()
			];

			$this->response->setData( $result );
		}
	}

	/**
	 * Looks for videos related to a search phrase
	 *
	 * Example of use:
	 *
	 *   http://glee.wikia.com/wikia.php?controller=VideoEmbedTool&method=search&format=json&order=default&phrase=frog&svSize=20&svStart=0&type=premium
	 *
	 * @requestParam phrase - The search phrase
	 * @requestParam type - Whether to search the local wiki ('local') or the video wiki ('premium')
	 * @requestParam svStart - offset
	 * @requestParam svSize - limit
	 * @requestParam order - How to order the results
	 * @requestParam trimTitle - Whether to trim the video title returned (boolean 1 or 0)
	 *
	 * @responseParam searchQuery - The 'phrase' parameter passed in
	 * @responseParam caption - Video caption
	 * @responseParam totalItemCount - Number of items available
	 * @responseParam nextStartFrom - The index for the next page of videos
	 * @responseParam currentSetItemCount - Number of items returned in the current page
	 * @responseParam items - Array of video suggestions
	 * @responseParam addMessage - A translated 'Add Video' message
	 */
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

		// Grep help: can be either vet-search-results-WVL or vet-search-results-local
		$captionKey = 'vet-search-results-'.($searchType == 'premium' ? 'WVL' : 'local');
		$result = [
			'searchQuery' => $phrase,
			'caption' => wfMessage( $captionKey, $response['totalItemCount'], $phrase )->text(),
			'totalItemCount' => $response['totalItemCount'],
			'nextStartFrom' => $response['nextStartFrom'],
			'currentSetItemCount' => count( $response['items'] ),
			'items' => $response['items'],
			'addMessage' => wfMessage('vet-add-from-preview')->plain()
		];

		$this->response->setData( $result );
	}

	/**
	 * Get the embed code for the given video title
	 *
	 * @requestParam fileTitle - The video title to get an embed code for
	 * @requestParam width - The desired width (default 460)
	 * @requestParam height - The desired height (default 250)
	 */
	public function getEmbedCode() {
		$fileTitle = $this->request->getVal('fileTitle', '');
		$fileTitle = urldecode($fileTitle);
		$title = Title::newFromText($fileTitle, NS_FILE);
		if ( !( $title instanceof Title ) ) {
			return;
		}

		$config = [
			'contextWidth' => $this->request->getVal('width', 460),
			'maxHeight' => $this->request->getVal('height', 250)
		];

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

		if ( $status ) {
			$this->status = 'success';
		} else {
			$this->status = 'fail';
			$this->errMsg = wfMessage('vet-description-save-error')->text();
		}
	}

}