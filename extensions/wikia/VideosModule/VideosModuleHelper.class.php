<?php

class VideosModuleHelper extends WikiaModel {

	const SEARCH_START = 0;
	const SEARCH_LIMIT = 20;
	const THUMBNAIL_WIDTH = 500;
	const THUMBNAIL_HEIGHT = 309;
	// We don't care where else this video has been posted, we just want to display it
	const POSTED_IN_ARTICLES = 0;
	const VIDEO_LIMIT = 20;
	const GET_THUMB = true;

	/**
	 * Use the VideoEmbedToolSearchService to find premium videos related to the current article.
	 * @param $articleId - ID of the article being viewed.
	 * @return array - Premium videos related to article.
	 */
	public function getArticleRelatedVideos( $articleId ) {

		wfProfileIn( __METHOD__ );

		$service = new VideoEmbedToolSearchService();
		$service->setStart( self::SEARCH_START )->setLimit( self::SEARCH_LIMIT );
		$service->setHeight( self::THUMBNAIL_HEIGHT );
		$service->setWidth( self::THUMBNAIL_WIDTH );
		$response = $service->getSuggestionsForArticleId( $articleId );

		$videos = array(
			'items' => $response['items'],
			'returnedVideoCount' => count( $response['items'] )
		);

		wfProfileOut( __METHOD__ );

		return $videos;

	}

	/**
	 * Use WikiaSearchController to find premium videos related to the local wiki.
	 * @return array - Premium videos related to the local wiki.
	 */
	public function getWikiRelatedVideos() {

		wfProfileIn( __METHOD__ );

		// Strip Wiki off the end of the wiki name if it exists
		$wikiTitle = preg_replace('/ Wiki$/', '', $this->wg->Sitename);

		$params = array( 'title' => $wikiTitle );
		$videoResults = $this->app->sendRequest( 'WikiaSearchController', 'searchVideosByTitle', $params )->getData();

		$helper = new VideoHandlerHelper();
		$videos = array();
		foreach ( $videoResults as $video ) {
			$videoTitle = preg_replace( '/.+File:/', '', $video['title'] );
			$videoDetail = $helper->getVideoDetailFromWiki( $this->wg->WikiaVideoRepoDBName,
					$videoTitle,
					self::THUMBNAIL_WIDTH,
					self::THUMBNAIL_HEIGHT,
					self::POSTED_IN_ARTICLES,
					self::GET_THUMB );
			// normalize json so the key for the url for the video is identical to the key
			// used in getArticleRelatedVideos
			$videoDetail['url'] = $videoDetail['fileUrl'];
			unset( $videoDetail['fileUrl'] );
			$videos[] = $videoDetail;
		}

		wfProfileOut( __METHOD__ );

		return $videos;
	}
}
