<?php

/**
 * SpecialVideos Helper
 * @author Liz
 * @author Saipetch
 */
class SpecialVideosHelper extends WikiaModel {

	const VIDEOS_PER_PAGE = 24;
	const THUMBNAIL_WIDTH = 320;
	const THUMBNAIL_HEIGHT = 205;
	const POSTED_IN_ARTICLES = 5;

	// get list of sorting options
	public function getSortingOptions() {
		$options = array(
			'recent' => $this->wf->Msg( 'specialvideos-sort-latest' ),
			'popular' => $this->wf->Msg( 'specialvideos-sort-most-popular' ),
			'trend' => $this->wf->Msg( 'specialvideos-sort-trending' ),
		);

		return $options;
	}

	// get list of filter options
	public function getFilterOptions() {
		$options = array(
			'premium' => $this->wf->Msg( 'specialvideos-sort-featured' ),
		);

		return $options;
	}

	// get list of videos
	public function getVideos( $sort ) {
		$this->wf->ProfileIn( __METHOD__ );

		$memKey = $this->getMemKeySortedVideos( $sort );
		$videos = $this->wg->Memc->get( $memKey );
		if ( !is_array($videos) ) {
			$mediaService = F::build( 'MediaQueryService' );
			if ( $sort == 'premium' ) {
				$videoList = $mediaService->getVideoList( true );
				$sort = 'recent';
			} else {
				$videoList = $mediaService->getVideoList();
			}

			$videos = array();
			foreach ( $videoList as $video ) {
				$videoDetail = $this->getVideoDetail( $video['name'] );
				if ( !empty($videoDetail) ) {
					$videos[] = $videoDetail;
				}
			}

			// sort video list
			$this->sortVideoList( $videos, $sort );

			$this->wg->Memc->set( $memKey, $videos, 60*60*2 );
		}

		$this->wf->ProfileOut( __METHOD__ );

		return $videos;
	}

	protected function getMemKeySortedVideos( $sort ) {
		return $this->wf->MemcKey( 'videos', 'sorted_videos', 'v2', $sort );
	}

	public function clearCacheSortedVideos() {
		$sortingOptions = array_keys( $this->getSortingOptions() );
		foreach( $sortingOptions as $option ) {
			$this->wg->Memc->delete( $this->getMemKeySortedVideos( $option ) );
		}
	}

	public function clearCacheSortedPremiumVideos() {
		$this->wg->Memc->delete( $this->getMemKeySortedVideos( 'premium' ) );
	}

	/**
	 * get video detail
	 * @param string $title
	 * @return array $videoDetail
	 */
	public function getVideoDetail( $title ) {
		$this->wf->ProfileIn( __METHOD__ );

		$videoDetail = array();
		$title = F::build( 'Title', array( $title, NS_FILE ), 'newFromText' );
		if ( $title instanceof Title ) {
			$file = $this->wf->FindFile( $title );
			if ( $file instanceof File && $file->exists()
				&& F::build( 'WikiaFileHelper', array( $file ), 'isFileTypeVideo' ) ) {
				// get thumbnail
				$thumb = $file->transform( array('width'=>self::THUMBNAIL_WIDTH, 'height'=>self::THUMBNAIL_HEIGHT) );
				$thumbUrl = $thumb->getUrl();

				// get user
				$user = F::build( 'User', array( $file->getUser('id') ), 'newFromId' );
				$userName = $user->getName();
				$userUrl = $user->getUserPage()->getFullURL();

				// get article list
				$mediaQuery =  F::build( 'ArticlesUsingMediaQuery' , array( $title ) );
				$articleList = $mediaQuery->getArticleList();
				list( $truncatedList, $isTruncated ) = F::build( 'WikiaFileHelper', array( $articleList, self::POSTED_IN_ARTICLES ), 'truncateArticleList' );

				// video details
				$videoDetail = array(
					'title' => $title->getDBKey(),
					'fileTitle' => $title->getText(),
					'fileUrl' => $title->getLocalUrl(),
					'thumbUrl' => $thumbUrl,
					'userName' => $userName,
					'userUrl' => $userUrl,
					'truncatedList' => $truncatedList,
					'isTruncated' => $isTruncated,
					'timestamp' => $file->getTimestamp(),
				);
			}
		}

		$this->wf->ProfileOut( __METHOD__ );

		return $videoDetail;
	}

	/**
	 * sort video list
	 * @param array $videoList
	 * @param string $sort [recent/popular/trend]
	 */
	public function sortVideoList( &$videoList, $sort = 'recent' ) {
		$this->wf->ProfileIn( __METHOD__ );

		if ( $sort == 'popular' ) {
			uasort( $videoList, array($this, 'sortByMostPopular') );
		} else if ( $sort == 'trend' ) {
			uasort( $videoList, array($this, 'sortByTrending') );
		}

		$this->wf->ProfileOut( __METHOD__ );
	}

	// sort by most popular
	protected function sortByMostPopular( $a, $b ) {
		$aViews = F::build( 'DataMartService', array( $a['title'] ), 'getVideoViewsByTitleTotal' );
		$bViews = F::build( 'DataMartService', array( $b['title'] ), 'getVideoViewsByTitleTotal' );
		if ( $aViews < $bViews ) {
			$result = 1;
		} else if ( $aViews > $bViews ) {
			$result = -1;
		} else {
			$result = ( $a['timestamp'] < $b['timestamp'] ) ? 1 : -1;
		}
		return $result;
	}

	// sort by trending
	protected function sortByTrending( $a, $b ) {
		$startDate = date( 'Y-m-d', strtotime('-30 day') );
		$aViews = F::build( 'DataMartService', array( $a['title'], DataMartService::PERIOD_ID_DAILY, $startDate ), 'getVideoViewsByTitleTotal' );
		$bViews = F::build( 'DataMartService', array( $b['title'], DataMartService::PERIOD_ID_DAILY, $startDate ), 'getVideoViewsByTitleTotal' );
		if ( $aViews < $bViews ) {
			$result = 1;
		} else if ( $aViews > $bViews ) {
			$result = -1;
		} else {
			$result = ( $a['timestamp'] < $b['timestamp'] ) ? 1 : -1;
		}
		return $result;
	}

	// get message for by user section
	public function getByUserMsg( $userName, $userUrl ) {
		$attribs = array(
			'href' => $userUrl,
			'class' => 'wikia-gallery-item-user',
		);

		$userLink = Xml::element( 'a', $attribs, $userName, false );
		$byUserMsg = $this->wf->Msg( 'specialvideos-uploadby', $userLink );

		return $byUserMsg;
	}

	// get html tag for article
	protected function getArticleLink( $article ) {
		$attribs = array(
			'href' => $article['url'],
		);

		$articleLink = Xml::element( 'a', $attribs, $article['titleText'], false );

		return $articleLink;
	}

	// get message for by posted in section
	public function getPostedInMsg( $truncatedList, $isTruncated ) {
		$postedInMsg = '';
		$articleLinks = array();
		foreach( $truncatedList as $article ) {
			$articleLinks[] = $this->getArticleLink( $article );
		}

		if ( !empty($articleLinks) ) {
			$postedInMsg = $this->wf->Msg( 'specialvideos-posted-in', implode($articleLinks, ', ') );
		}

		return $postedInMsg;
	}

}
