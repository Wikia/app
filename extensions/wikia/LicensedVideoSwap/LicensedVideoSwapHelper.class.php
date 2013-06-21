<?php

/**
 * LicensedVideoSwap Helper
 * @author Garth Webb
 * @author Liz Lee
 * @author Saipetch Kongkatong
 */
class LicensedVideoSwapHelper extends WikiaModel {

	const STATUS_KEEP = 1;
	const STATUS_SWAP_NORM = 2;
	const STATUS_SWAP_EXACT = 3;

	const VIDEOS_PER_PAGE = 10;
	const THUMBNAIL_WIDTH = 500;
	const THUMBNAIL_HEIGHT = 309;
	const POSTED_IN_ARTICLES = 100;
	const NUM_SUGGESTIONS = 5;

	/**
	 * Gets a list of videos that have not yet been swapped (e.g., no decision to keep or not keep the
	 * original video has been made)
	 *
	 * @param string $sort - The sort order for the video list (options: recent, popular, trend)
	 * @param int $limit - The number of videos to return
	 * @param int $page - Which page of video to return
	 * @return array - An array of video metadata
	 */
	public function getUnswappedVideoList ( $sort = 'popular', $limit = 10, $page = 1 ) {
		wfProfileIn( __METHOD__ );

		$db = wfGetDB( DB_SLAVE );

		// We want to make sure the video hasn't been removed, is not premium and does not exist
		// in the video_swap table
		$sqlWhere = array(
			'removed' => 0,
			'premium' => 0,
			'video_title = page_title',
			'page_namespace' => NS_FILE,
			'page_wikia_props.page_id IS NULL'
		);

		// Paging options
		$sqlOptions = array(
			'LIMIT'  => $limit,
			'OFFSET' => ( ( $page - 1 ) * $limit )
		);

		// Get the right sorting
		switch ( $sort ) {
			case 'popular': $sqlOptions['ORDER BY'] = 'views_total DESC';
							break;
			case 'trend'  : $sqlOptions['ORDER BY'] = 'views_30day DESC';
							break;
			default:        $sqlOptions['ORDER BY'] = 'added_at DESC';
		}

		// Do the outer join on the video_swap table
		$joinCond['page_wikia_props'] = array( 'LEFT JOIN', array( 'page.page_id' => 'page_wikia_props.page_id', 'propname' => WPP_LVS_STATUS ) );

		// Select video info making sure to skip videos that have entries in the video_swap table
		$result = $db->select(
			array( 'video_info', 'page', 'page_wikia_props' ),
			array( 'video_title, added_at, added_by' ),
			$sqlWhere,
			__METHOD__,
			$sqlOptions,
			$joinCond
		);

		// Build the return array
		$videoList = array();
		while( $row = $db->fetchObject($result) ) {
			$videoList[] = array(
				'title' => $row->video_title,
				'addedAt' => $row->added_at,
				'addedBy' => $row->added_by,
			);
		}

		wfProfileOut( __METHOD__ );

		return $videoList;
	}

	/**
	 * Get the total number of unswapped videos
	 * @return int - The number of unswapped videos
	 */
	public function getUnswappedVideoTotal ( ) {
		wfProfileIn( __METHOD__ );

		$db = wfGetDB( DB_SLAVE );

		// We want to make sure the video hasn't been removed, is not premium and does not exist
		// in the video_swap table
		$sqlWhere = array(
			'removed' => 0,
			'premium' => 0,
			'video_title = page_title',
			'page_namespace' => NS_FILE,
			'page_wikia_props.page_id IS NULL'
		);

		// Give a name for clarity, but no options for this statement
		$sqlOptions = array( );

		// Do the outer join on the video_swap table
		$joinCond = array( 'page_wikia_props' => array( 'LEFT JOIN', 'page.page_id = page_wikia_props.page_id' ) );

		// Select video info making sure to skip videos that have entries in the video_swap table
		$result = $db->select(
			array( 'video_info', 'page', 'page_wikia_props' ),
			array( 'count(*) as total' ),
			$sqlWhere,
			__METHOD__,
			$sqlOptions,
			$joinCond
		);

		// Get the result
		$total = 0;
		while( $row = $db->fetchObject($result) ) {
			$total = $row->total;

			// Should only be one result
			break;
		}

		wfProfileOut( __METHOD__ );

		return $total;
	}

	/**
	 * Get a list of non-premium video that is available to swap
	 *
	 * @param string $sort - The sort order for the video list (options: recent, popular, trend)
	 * @param int $page - Which page to display. Each page contains self::VIDEOS_PER_PAGE videos
	 * @return array - Returns a list of video metadata
	 */
	public function getRegularVideoList ( $sort, $page ) {
		wfProfileIn( __METHOD__ );

		// Get the play button image to overlay on the video
		$playButton = WikiaFileHelper::videoPlayButtonOverlay( self::THUMBNAIL_WIDTH, self::THUMBNAIL_HEIGHT );

		// Get the list of videos that haven't been swapped yet
		$videoList = $this->getUnswappedVideoList( $sort, self::VIDEOS_PER_PAGE, $page );

		// Reuse code from VideoHandlerHelper
		$helper = new VideoHandlerHelper();

		// Go through each video and add additional detail needed to display the video
		$videos = array();
		foreach ( $videoList as $videoInfo ) {
			$readableTitle = preg_replace( '/_/', ' ', $videoInfo['title'] );
			$suggestions = $this->getVideoSuggestions( $readableTitle );

			$videoDetail = $helper->getVideoDetail( $videoInfo, self::THUMBNAIL_WIDTH, self::THUMBNAIL_HEIGHT, self::POSTED_IN_ARTICLES );
			if ( !empty($videoDetail) ) {
				$videoOverlay =  WikiaFileHelper::videoInfoOverlay( self::THUMBNAIL_WIDTH, $videoDetail['fileTitle'] );

				$videoDetail['videoPlayButton'] = $playButton;
				$videoDetail['videoOverlay'] = $videoOverlay;
				$videoDetail['videoSuggestions'] = $suggestions;

				$seeMoreLink = SpecialPage::getTitleFor( "WhatLinksHere" )->escapeLocalUrl();
				$seeMoreLink .= '/' . $this->app->wg->ContLang->getNsText( NS_FILE ). ':' . $videoDetail['title'];

				$videoDetail['seeMoreLink'] = $seeMoreLink;

				$videos[] = $videoDetail;
			}
		}

		wfProfileOut( __METHOD__ );

		return $videos;
	}

	/**
	 * get video suggestions
	 * @param string videoTitle
	 * @return array videos
	 */
	public function getVideoSuggestions( $videoTitle = '' ) {
		wfProfileIn( __METHOD__ );

		$app = F::App();
		$videoRows = $app->sendRequest( 'WikiaSearchController', 'searchVideosByTitle', array( 'title' => $videoTitle ) )
						 ->getData();

		// Reuse code from VideoHandlerHelper
		$helper = new VideoHandlerHelper();

		// Get the play button image to overlay on the video
		$playButton = WikiaFileHelper::videoPlayButtonOverlay( self::THUMBNAIL_WIDTH, self::THUMBNAIL_HEIGHT );

		$videos = array();
		$count = 0;
		foreach ($videoRows as $videoInfo) {
			$videoDetail = $helper->getVideoDetail( $videoInfo,
													self::THUMBNAIL_WIDTH,
													self::THUMBNAIL_HEIGHT,
													self::POSTED_IN_ARTICLES );
			if ( empty($videoDetail) ) {
				break;
			}

			$videoOverlay =  WikiaFileHelper::videoInfoOverlay( self::THUMBNAIL_WIDTH, $videoDetail['fileTitle'] );
			$videoDetail['videoPlayButton'] = $playButton;
			$videoDetail['videoOverlay'] = $videoOverlay;

			$videos[] = $videoDetail;

			$count++;
			if ( $count >= self::NUM_SUGGESTIONS ) {
				break;
			}
		}

		wfProfileOut( __METHOD__ );

		// The first video in the array is the top choice.
		return $videos;
	}


	/**
	 * get file object (video only)
	 * @param string $videoTitle
	 * @param boolean $force
	 * @return File|null $result
	 */
	public function getVideoFile( $videoTitle, $force = false ) {
		$result = null;

		$title = Title::newFromText( $videoTitle,  NS_FILE );
		if ( $title instanceof Title ) {
			// clear cache for file object
			if ( $force ) {
				RepoGroup::singleton()->clearCache( $title );
			}

			$file = wfFindFile( $title );
			if ( $file instanceof File && $file->exists() && WikiaFileHelper::isFileTypeVideo( $file ) ) {
				$result = $file;
			}
		}

		return $result;
	}

	/**
	 * Set the status of this file page to swapped
	 * @param int|$articleId - The ID of a video's file page
	 */
	public function setSwapStatus( $articleId ) {
		wfSetWikiaPageProp( WPP_LVS_STATUS, $articleId, self::STATUS_SWAP_NORM );
	}

	/**
	 * Set the status of this file page to swapped with an exact match
	 * @param int|$articleId - The ID of a video's file page
	 */
	public function setSwapExactStatus( $articleId ) {
		wfSetWikiaPageProp( WPP_LVS_STATUS, $articleId, self::STATUS_SWAP_EXACT );
	}

	/**
	 * add log to RecentChange
	 * @param Title $title
	 * @param string $action
	 * @param string $reason
	 */
	public function addLog( $title, $action, $reason = '' ) {
		$user = $this->wg->User;
		RecentChange::notifyLog( wfTimestampNow(), $title, $user, '', '', RC_EDIT, $action, $title, $reason, '' );
	}

	public function isSwapped( $articleId ) {
		$status = wfGetWikiaPageProp( WPP_LVS_STATUS, $articleId );
		return ( $status == self::STATUS_SWAP_EXACT || $status == self::STATUS_SWAP_NORM );
	}

	/**
	 * add redirect link to the article
	 * @param Title $title
	 * @param Title $newTitle
	 * @return Status $status
	 */
	public function addRedirectLink( $title, $newTitle ) {
		wfProfileIn( __METHOD__ );

		$article = new Article( $title );
		$content = "#REDIRECT [[{$newTitle->getPrefixedText()}]]";
		$summary = wfMessage( 'autoredircomment', $title->getFullText() )->inContentLanguage()->text();
		$status = $article->doEdit( $content, $summary );

		wfProfileOut( __METHOD__ );

		return $status;
	}

	/**
	 * remove redirect link (last revision)
	 * @param Article $article
	 * @return Status $status
	 */
	public function removeRedirectLink( $article ) {
		wfProfileIn( __METHOD__ );

		$lastRevision = $article->getRevision();
		$previousRevision = $lastRevision->getPrevious();
		if ( $previousRevision instanceof Revision ) {
			$baseRevId = $previousRevision->getId();
			$previousText = $previousRevision->getText();
		} else {
			$baseRevId = false;
			$previousText = '';
		}
		$summary = wfMessage( 'lvs-log-removed-redirected-link' )->inContentLanguage()->text();
		$status = $article->doEdit( $previousText, $summary, EDIT_UPDATE, $baseRevId );

		wfProfileOut( __METHOD__ );

		return $status;
	}

	/**
	 * undelete page (local file)
	 * @param Title $title
	 * @param boolean $removePremium
	 * @return Status $status
	 */
	public function undeletePage( $title, $removePremium = false ) {
		wfProfileIn( __METHOD__ );

		// use Phalanx to check recovered page title
		if ( !wfRunHooks( 'CreatePageTitleCheck', array( $title, false ) ) ) {
			wfProfileOut( __METHOD__ );
			return Status::newFatal( wfMessage( 'spamprotectiontext' )->text() );
		}

		$archive = new PageArchive( $title );
		wfRunHooks( 'UndeleteForm::undelete', array( &$archive, $title ) );

		$time = '';
		$comment = '';
		$fileVersions = array();
		$unsuppress = false;

		$status = $archive->undelete( $time, $comment, $fileVersions, $unsuppress );
		if ( is_array( $status ) ) {
			// Undeleted file count
			if ( $status[1] ) {
				// remove premium video from video_info table if swapping same video titles
				if ( $removePremium ) {
					wfRunHooks( 'RemovePremiumVideo', array( $title ) );
				}

				// clear file cache
				RepoGroup::singleton()->clearCache( $title );

				wfRunHooks( 'FileUndeleteComplete', array( $title, $fileVersions, $this->wg->User, $comment ) );
			}
			$status = Status::newGood();
		} else {
			$status = Status::newFatal( wfMessage( 'cannotundelete' )->text() );
		}

		wfProfileOut( __METHOD__ );

		return $status;
	}

	/**
	 * get pagination
	 * @param integer $currentPage
	 * @param string $selectedSort
	 * @return string $pagination
	 */
	public function getPagination( $currentPage, $selectedSort ) {
		$pagination = '';
		$totalVideos = $this->getUnswappedVideoTotal();
		if ( $totalVideos > self::VIDEOS_PER_PAGE ) {
			$pages = Paginator::newFromArray( array_fill( 0, $totalVideos, '' ), self::VIDEOS_PER_PAGE );
			$pages->setActivePage( $currentPage - 1 );

			$linkToSpecialPage = SpecialPage::getTitleFor( "LicensedVideoSwap" )->escapeLocalUrl();
			$pagination = $pages->getBarHTML( $linkToSpecialPage.'?currentPage=%s&sort='.$selectedSort );
		}

		return $pagination;
	}

}