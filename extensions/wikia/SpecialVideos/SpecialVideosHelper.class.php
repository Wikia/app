<?php

/**
 * SpecialVideos Helper
 * @author Liz
 * @author Saipetch
 */
class SpecialVideosHelper extends WikiaModel {

	const VIDEOS_PER_PAGE = 24;
	const THUMBNAIL_WIDTH = 330;
	const THUMBNAIL_HEIGHT = 211;
	const POSTED_IN_ARTICLES = 5;

	/**
	 * get list of filter options
	 * @return array $options
	 */
	public function getFilterOptions() {
		$options = array();

		$premiumVideos = $this->premiumVideosExist();
		if ( !empty($premiumVideos) ) {
			$options['premium'] = wfMessage( 'specialvideos-sort-featured' )->text();
		}

		return $options;
	}

	/**
	 * get list of videos
	 * @param string $sort [recent/popular/trend]
	 * @param integer $page
	 * @param array $providers
	 * @return array $videos
	 */
	public function getVideos( $sort, $page, $providers = array() ) {
		wfProfileIn( __METHOD__ );

		if ( $sort == 'premium' ) {
			$sort = 'recent';
			$filter = 'premium';
		} else {
			$filter = 'all';
		}

		$mediaService = new MediaQueryService();
		$videoList = $mediaService->getVideoList( $sort, $filter, self::VIDEOS_PER_PAGE, $page, $providers );

		$videos = array();
		$helper = new VideoHandlerHelper();
		foreach ( $videoList as $videoInfo ) {
			$videoDetail = $helper->getVideoDetail( $videoInfo, self::THUMBNAIL_WIDTH, self::THUMBNAIL_HEIGHT, self::POSTED_IN_ARTICLES );
			if ( !empty($videoDetail) ) {
				$videos[] = $videoDetail;
			}
		}

		wfProfileOut( __METHOD__ );

		return $videos;
	}

	/**
	 * get message for by user section
	 * @param string $userName
	 * @param string $userUrl
	 * @return string $byUserMsg
	 */
	public function getByUserMsg( $userName, $userUrl ) {
		$byUserMsg = '';
		if ( !empty($userName) ) {
			$attribs = array(
				'href' => $userUrl,
				'class' => 'wikia-gallery-item-user',
			);

			$userLink = Xml::element( 'a', $attribs, $userName, false );
			$byUserMsg = wfMsg( 'specialvideos-uploadby', $userLink );
		}

		return $byUserMsg;
	}

	/**
	 * get html tag for article
	 * @param array $article
	 * @return string $articleLink
	 */
	protected function getArticleLink( $article ) {
		$attribs = array(
			'href' => $article['url'],
		);

		$articleLink = Xml::element( 'a', $attribs, $article['titleText'], false );

		return $articleLink;
	}

	/**
	 * get message for by posted in section
	 * @param array $truncatedList
	 * @param integer $isTruncated [0/1]
	 * @return string $postedInMsg
	 */
	public function getPostedInMsg( $truncatedList, $isTruncated ) {
		$postedInMsg = '';
		$articleLinks = array();
		foreach ( $truncatedList as $article ) {
			$articleLinks[] = $this->getArticleLink( $article );
		}

		if ( !empty($articleLinks) ) {
			$postedInMsg = wfMsg( 'specialvideos-posted-in', implode($articleLinks, ', ') );
		}

		return $postedInMsg;
	}

	/**
	 * check if premium video exists
	 * @return integer $videoExist [0/1]
	 */
	public function premiumVideosExist() {
		$mediaService = new MediaQueryService();
		$videoExist = (bool) $mediaService->getTotalPremiumVideos();

		return $videoExist;
	}

}
