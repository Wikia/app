<?php

class VideosModuleHelper extends WikiaModel {

	const SEARCH_START = 0;
	const SEARCH_LIMIT = 20;
	const THUMBNAIL_WIDTH = 500;
	const THUMBNAIL_HEIGHT = 309;
	// We don't care where else this video has been posted, we just want to display it
	const POSTED_IN_ARTICLES = 0;
	const VIDEO_LIMIT = 25;
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

		wfProfileIn(__METHOD__);

		// Strip Wiki off the end of the wiki name if it exists
		$wikiTitle = preg_replace('/ Wiki$/', '', $this->wg->Sitename);

		$params = array( 'title' => $wikiTitle );
		$videoResults = $this->app->sendRequest( 'WikiaSearchController', 'searchVideosByTitle', $params )->getData();

		$helper = new VideoHandlerHelper();
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
			unset($videoDetail['fileUrl']);
			$videos[] = $videoDetail;
		}

		wfProfileOut(__METHOD__);

		return $videos;
	}

	/**
	 * Get videos to populated the Videos Module. First try and get premium videos
	 * related to the article page. If that's not enough add premium videos related
	 * to the local wiki. Finally, if still more or needed, get trending premium
	 * videos related to the vertical of the wiki.
	 * @var int $articleId - ID of the article being viewed.
	 * @return array - The list of videos.
	 */
	public function getVideos( $articleId ) {

		wfProfileIn(__METHOD__);

		$articleRelatedVideos = $this->getArticleRelatedVideos( $articleId );
		$articleRelatedVideosCount = $articleRelatedVideos['returnedVideoCount'];
		$videos = $articleRelatedVideos['items'];

		// Add videos from getWikiRelatedVideos if we didn't hit our video count limit
		if ( $articleRelatedVideosCount < self::VIDEO_LIMIT ) {
			$wikiRelatedVideos = $this->getWikiRelatedVideos();
			array_splice( $wikiRelatedVideos, self::VIDEO_LIMIT - $articleRelatedVideosCount );
			// We want these to always be shown in a random order to the user
			shuffle( $wikiRelatedVideos );
			$videos = array_merge( $videos,  $wikiRelatedVideos );
		}

		wfProfileOut(__METHOD__);

		return $videos;
	}

}
