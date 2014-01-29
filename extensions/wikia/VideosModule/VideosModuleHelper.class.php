<?php

class VideosModuleHelper {

	const SEARCH_START = 0;
	const SEARCH_LIMIT = 20;
	const THUMBNAIL_CATEGORY_WIDTH = 263;
	const THUMBNAIL_CATEGORY_HEIGHT = 148;
	const CACHE_TTL_CATEGORY_DATA = 3600;
	const VIDEO_WIKI_DB = 'video151';

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

		wfProfileIn( __METHOD__ );

		$service = new VideoEmbedToolSearchService();
		$service->setStart( self::SEARCH_START )->setLimit( self::SEARCH_LIMIT );
		$response = $service->getSuggestionsForArticleId( $articleId );
		$videos = array(
			'items' => $response['items'],
			'returnedVideoCount' => count( $response['items'] )
		);

		return $videos;

		wfProfileOut( __METHOD__ );

	}

	/**
	 * Get videos tagged with the category given by parameter $categoryTitle (limit = 100)
	 * @param Title $categoryTitle
	 * @param int $numVideos
	 * @param array $thumbOptions
	 * @return array An array of video data where each array element has the structure:
	 *   [ title => 'Video Title',
	 *     url   => 'http://url.to.video',
	 *     thumb => '<thumbnail_html_snippet>'
	 */
	public function getVideosByCategory( $categoryTitle, $numVideosNeeded, $thumbOptions = array() ) {

		wfProfileIn( __METHOD__ );

		$dbKey = $categoryTitle->getDBkey();
		// pass an empty array here to access the third default argument so we can
		// change the wiki to connect to.
		$db = wfGetDB( DB_SLAVE, array(), self::VIDEO_WIKI_DB );

		$videos = ( new WikiaSQL() )
			->SELECT( 'page_id, page_title' )
			->FROM( 'page' )
			->LEFT_JOIN( 'video_info' )
			->ON( 'page_title', 'video_title' )
			->INNER_JOIN( 'categorylinks' )
			->ON( 'cl_from', 'page_id' )
			->WHERE( 'cl_to' )->EQUAL_TO( $dbKey )
			->AND_( 'page_namespace' )->EQUAL_TO( NS_FILE )
			->ORDER_BY( ['views_7day', 'page_title'] )
			->LIMIT( $numVideosNeeded )
			->cache( self::CACHE_TTL_CATEGORY_DATA )
			->run( $db, function ( $result ) use ( $thumbOptions ) {
				$videos = array();
				while ( $row = $result->fetchObject( $result ) ) {
					$title = $row->page_title;
					$file = WikiaFileHelper::getVideoFileFromTitle( $title );
					if ( !empty( $file ) ) {
						$thumb = $file->transform( array( 'width' => self::THUMBNAIL_CATEGORY_WIDTH, 'height' => self::THUMBNAIL_CATEGORY_HEIGHT ) );
						$videoThumb = $thumb->toHtml( $thumbOptions );
						$videos[] = array(
							'title' => $title->getText(),
							'url'   => $title->getFullURL(),
							'thumb' => $videoThumb,
						);
					}
				}
				return $videos;
			});

		wfProfileOut( __METHOD__ );

		return $videos;
	}
}