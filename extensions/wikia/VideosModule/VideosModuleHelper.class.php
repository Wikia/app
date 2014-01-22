<?php

class VideosModuleHelper {

	const SEARCH_START = 0;
	const SEARCH_LIMIT = 20;

	/*
	 *   Example of use:
	 *   http://harrypotter.jacek.wikia-dev.com/wikia.php?controller=VideoEmbedTool&method=getSuggestedVideos&svStart=0&svSize=5&articleId=15&format=json
	 *   svStart     - offset
	 *   svSize      - limit
	 *   videoWidth  - thumbnail width
	 *   videoHeight - thumbnail height
	 *   articleId 	 - the suggestions should be related to this article
	 */
	public function getSuggestedVideos( $articleId ) {
		$service = new VideoEmbedToolSearchService();
		$service->setStart( self::SEARCH_START )->setLimit( self::SEARCH_LIMIT );
		$response = $service->getSuggestionsForArticleId( $articleId );

		print_tmp("response: \n", $response);

		$result = array(
			'totalSuggestedVideos' => count( $response['items'] ),
			'items' => $response['items']
		);

		return $result;
	}
}