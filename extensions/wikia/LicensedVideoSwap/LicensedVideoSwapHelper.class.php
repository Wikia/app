<?php

use NlpTools\Tokenizers\WhitespaceAndPunctuationTokenizer,
	NlpTools\Stemmers\PorterStemmer,
	NlpTools\Similarity\JaccardIndex;

/**
 * LicensedVideoSwap Helper
 * @author Garth Webb
 * @author Liz Lee
 * @author Saipetch Kongkatong
 */
class LicensedVideoSwapHelper extends WikiaModel {

	const STATUS_KEEP = 1;            // set bit to 1 = kept video
	const STATUS_SWAP = 2;            // set bit to 1 = swapped video
	const STATUS_EXACT = 4;           // set bit to 0 = normal swap, 1 = swap with an exact match
	const STATUS_SWAPPABLE = 8;       // set bit to 1 = video with suggestions
	const STATUS_NEW = 16;            // set bit to 1 = video with new suggestions
	const STATUS_FOREVER = 32;        // set bit to 1 = no more matches

	/**
	 * Duration variation in seconds
	 * @var int
	 */
	const DURATION_DELTA = 10;

	/**
	 * Threshold used with duration to constrain matches
	 * @var float
	 */
	const MIN_JACCARD_SIMILARITY = 0.7;

	const VIDEOS_PER_PAGE = 10;
	const THUMBNAIL_WIDTH = 500;
	const THUMBNAIL_HEIGHT = 309;
	const POSTED_IN_ARTICLES = 100;
	const NUM_SUGGESTIONS = 5;
	const USER_VISITED_DATE = 'LicensedVideoSwap_visitedDate';    // last visited date (store in user properties)
	const USER_VISITED_LIST = 'LicensedVideoSwap_visitedList';

	/**
	 * TTL of 604800 is 7 days.  Expire suggestion cache after this
	 * @var int
	 */
	const SUGGESTIONS_TTL = 604800;

	/**
	 * Tokenizer for text processing
	 * @var NlpTools\Tokenizers\WhitespaceAndPunctuationTokenizer
	 */
	protected $tokenizer;

	/**
	 * Stemmer for text processing
	 * @var NlpTools\Stemmers\PorterStemmer
	 */
	protected $stemmer;

	/**
	 * Used to compute Jaccard similarity
	 * @var NlpTools\Similarity\JaccardIndex
	 */
	protected $jaccard;

	/**
	 * Get the raw data about LVS from the DB
	 * @return array
	 */
	public function getVideoDebugInfo() {
		$db = wfGetDB( DB_SLAVE );

		$sql = "SELECT video_title AS title,
					   provider AS provider,
					   p.propname AS prop,
					   p.props AS val
				FROM video_info, page, page_wikia_props p
				WHERE video_title=page_title
				  AND page.page_id=p.page_id
				  AND propname IN (18,19,20,22)
				  AND page.page_id NOT IN (
						SELECT e.page_id
						FROM page_wikia_props e
						WHERE e.propname = 21
						  AND e.props = 1
				  )
				ORDER BY added_at desc";

		$result = $db->query( $sql, __METHOD__ );

		// Build the return array
		$debugInfo = [];
		while ( $row = $db->fetchObject( $result ) ) {
			$debugInfo[ $row->title ]['provider'] = $row->provider;

			// Get the prop val
			$val = $row->val;
			// If this propname isn't in the list of already unserialized data, unserialize it.
			if ( !in_array( $row->prop, $this->wg->WPPNotSerialized ) ) {
				$val = unserialize($val);
			}

			$name = 'unknown';
			// Convert the prop name
			switch ($row->prop) {
				case 18: $name = 'Status Info'; break;
				case 19: $name = 'Suggestions'; break;
				case 20: $name = 'Suggestions Updated'; break;
				case 21: $name = 'No suggestions'; break;
				case 22: $name = 'Status Flags';
					break;
			}

			// Reuse code from VideoHandlerHelper
			$helper = new VideoHandlerHelper();
			$videoDetail = $helper->getVideoDetail( ["title" => $row->title ], 200, 200, 5 );

			$debugInfo[ $row->title ]['detail'] = $videoDetail;
			$debugInfo[ $row->title ]['props'][$name] = $val;
		}

		return $debugInfo;
	}

	/**
	 * Gets a list of videos that have not yet been swapped (e.g., no decision to keep or not keep the
	 * original video has been made)
	 *
	 * @param string $sort - The sort order for the video list (options: recent, popular, trend)
	 * @param int $limit - The number of videos to return
	 * @param int $page - Which page of video to return
	 * @param boolean $useMaster - Whether to use the master DB to do this query
	 * @return array - An array of video metadata
	 */
	public function getUnswappedVideoList( $sort = 'popular', $limit = 10, $page = 1, $useMaster = false ) {
		wfProfileIn( __METHOD__ );

		if ( $useMaster ) {
			$db = wfGetDB( DB_MASTER );
		} else {
			$db = wfGetDB( DB_SLAVE );
		}

		// We want to make sure the video hasn't been removed, is not premium and does not exist
		// in the video_swap table
		$pageNS = NS_FILE;
		$canSwapProps = $this->canSwapPropLogic();
		$offset = ( $page - 1 ) * $limit;

		// Get the right sorting
		switch ( $sort ) {
			case 'popular': $order = 'views_total DESC';
				break;
			case 'trend'  : $order = 'views_30day DESC';
				break;
			default:        $order = 'added_at DESC';
		}

		$sql = <<<SQL
			SELECT video_title, added_at, added_by, page.page_id, props
			FROM video_info
			JOIN page ON video_title = page_title AND page_namespace = $pageNS
			LEFT JOIN page_wikia_props ON page.page_id = page_wikia_props.page_id
				AND $canSwapProps
			WHERE removed = 0 AND premium = 0 AND page_wikia_props.page_id is not null
			ORDER BY $order
			LIMIT $limit
			OFFSET $offset
SQL;

		// Select video info making sure to skip videos that have entries in the video_swap table
		$result = $db->query( $sql, __METHOD__ );

		// Build the return array
		$videoList = array();
		while ( $row = $db->fetchObject( $result ) ) {
			$videoList[] = array(
				'title' => $row->video_title,
				'addedAt' => $row->added_at,
				'addedBy' => $row->added_by,
				'pageId' => $row->page_id,
				'status' => $row->props,
			);
		}

		wfProfileOut( __METHOD__ );

		return $videoList;
	}

	/**
	 * Get the total number of unswapped videos
	 * @param boolean $useMaster - Whether to use the master DB to do this query
	 * @return int - The number of unswapped videos
	 */
	public function getUnswappedVideoTotal( $useMaster = false ) {
		wfProfileIn( __METHOD__ );

		$memcKey = $this->getMemcKeyTotalVideos();
		$total = $this->wg->Memc->get( $memcKey );
		if ( !is_numeric( $total ) ) {
			if ( $useMaster ) {
				$db = wfGetDB( DB_MASTER );
			} else {
				$db = wfGetDB( DB_SLAVE );
			}

			// We want to make sure the video hasn't been removed, is not premium and does not exist
			// in the video_swap table
			$pageNS = NS_FILE;
			$canSwapProps = $this->canSwapPropLogic();

			$sql = <<<SQL
				SELECT count(*) as total
				FROM video_info
				JOIN page ON video_title = page_title AND page_namespace = $pageNS
				LEFT JOIN page_wikia_props ON page.page_id = page_wikia_props.page_id
					AND $canSwapProps
				WHERE removed = 0 AND premium = 0 AND page_wikia_props.page_id is not null
SQL;

			// Select video info making sure to skip videos that have entries in the video_swap table
			$result = $db->query( $sql, __METHOD__ );

			// Get the total count of relavent videos
			$total = 0;
			while ( $row = $db->fetchObject( $result ) ) {
				$total = $row->total;

				// Should only be one result
				break;
			}

			$this->wg->Memc->set( $memcKey, $total, 60*60*24 );
		}

		wfProfileOut( __METHOD__ );

		return $total;
	}

	/**
	 * Get memcache key for total videos
	 * @return string
	 */
	public function getMemcKeyTotalVideos() {
		return wfMemcKey( 'licensedvideoswap', 'total_videos' );
	}

	/**
	 * Clear cache for total videos
	 */
	public function invalidateCacheTotalVideos() {
		$this->wg->Memc->delete( $this->getMemcKeyTotalVideos() );
	}

	/**
	 * Get a list of non-premium video that is available to swap
	 * Find the intersection between a list of video titles passed in and the current list of
	 * unswapped videos on the LVS page.
	 *
	 * @param array $videoList A list of video title strings
	 * @return array The list of video titles from $videoList that were still unswapped/kept
	 */
	public function intersectUnswappedVideo ( $videoList = array() ) {
		wfProfileIn( __METHOD__ );

		$db = wfGetDB( DB_SLAVE );

		// We want to make sure the video hasn't been removed, is not premium and does not exist
		// in the video_swap table
		$pageNS = NS_FILE;
		$canSwapProps = $this->canSwapPropLogic();

		$videoListString = implode(',', array_map( function($v) use ($db) {
														return $db->addQuotes($v);
												   },
												   $videoList )
								  );

		$sql = <<<SQL
			SELECT video_title
			FROM video_info
			JOIN page ON video_title = page_title AND page_namespace = $pageNS
			LEFT JOIN page_wikia_props ON page.page_id = page_wikia_props.page_id
				AND $canSwapProps
			WHERE removed = 0
			  AND premium = 0
			  AND page_wikia_props.page_id is not null
			  AND video_title IN ($videoListString)
SQL;

		// Select video info making sure to skip videos that have entries in the video_swap table
		$result = $db->query( $sql, __METHOD__ );

		$intersection = [];
		// Get the total count of relavent videos
		while ( $row = $db->fetchObject( $result ) ) {
			$intersection[$row->video_title] = 1;
		}

		wfProfileOut( __METHOD__ );

		return $intersection;
	}

	/**
	 * SQL logic for determining if a video should be visible and available, based on its
	 * page props.
	 *
	 * @return string
	 */
	private function canSwapPropLogic() {
		$statusProp = WPP_LVS_STATUS;
		$swappable  = '(props & '.self::STATUS_SWAPPABLE.' != 0)';
		$notSwapped = '(props & '.self::STATUS_SWAP.' = 0)';
		$notForever = '(props & '.self::STATUS_FOREVER.' = 0)';
		$notKept    = '(props & '.self::STATUS_KEEP.' = 0)';
		$new        = '(props & '.self::STATUS_NEW.' != 0)';

		return "propname = $statusProp AND $swappable AND $notSwapped AND $notForever AND ($notKept OR $new)";
	}

	/**
	 * Get a list of non-premium videos that are available to swap
	 *
	 * @param string $sort - The sort order for the video list (options: recent, popular, trend)
	 * @param integer $page - Which page to display. Each page contains self::VIDEOS_PER_PAGE videos
	 * @param boolean $useMaster
	 * @return array - Returns a list of video metadata
	 */
	public function getRegularVideoList( $sort, $page, $useMaster = false ) {
		wfProfileIn( __METHOD__ );

		// Get the play button image to overlay on the video
		$playButton = WikiaFileHelper::videoPlayButtonOverlay( self::THUMBNAIL_WIDTH, self::THUMBNAIL_HEIGHT );

		// Get the list of videos that haven't been swapped yet
		$videoList = $this->getUnswappedVideoList( $sort, self::VIDEOS_PER_PAGE, $page, $useMaster );

		// Reuse code from VideoHandlerHelper
		$helper = new VideoHandlerHelper();

		// Get a list of what videos the user has already looked at
		$visitedList = unserialize($this->wg->User->getOption( LicensedVideoSwapHelper::USER_VISITED_LIST ));

		// Go through each video and add additional detail needed to display the video
		$videos = array();
		foreach ( $videoList as $videoInfo ) {
			$suggestions = $this->getVideoSuggestions( $videoInfo['title'] );

			// Leave out this video if it has no suggestions
			if ( empty( $suggestions ) ) {
				continue;
			}

			$videoDetail = $helper->getVideoDetail( $videoInfo, self::THUMBNAIL_WIDTH, self::THUMBNAIL_HEIGHT, self::POSTED_IN_ARTICLES );
			if ( !empty($videoDetail) ) {
				$videoOverlay =  WikiaFileHelper::videoInfoOverlay( self::THUMBNAIL_WIDTH, $videoDetail['fileTitle'] );

				$videoDetail['videoPlayButton'] = $playButton;
				$videoDetail['videoOverlay'] = $videoOverlay;
				$videoDetail['videoSuggestions'] = $suggestions;

				$seeMoreLink = SpecialPage::getTitleFor( "WhatLinksHere" )->escapeLocalUrl();
				$seeMoreLink .= '/' . $this->app->wg->ContLang->getNsText( NS_FILE ). ':' . $videoDetail['title'];

				$videoDetail['seeMoreLink'] = $seeMoreLink;

				$videoDetail['confirmKeep'] = ( $this->isStatusKeep( $videoInfo['status'] ) && $this->isStatusNew( $videoInfo['status'] ) );
				$videoDetail['isNew'] = $this->isStatusNew( $videoInfo['status'] );

				// Unset the isNew flag if this user has already played this video
				if ( isset($visitedList[$videoInfo['title']]) ) {
					$videoDetail['isNew'] = false;
				}

				$videos[] = $videoDetail;
			} else {
				// Something is wrong with the existing video.  Mark this as having no suggestions
				// to hide it here.  Could mark it as skipped but then it would show up on the
				// history page and that would be confusing.
				$titleObj = Title::newFromText( $videoInfo['title'], NS_FILE );
				$articleId = $titleObj->getArticleID();

				wfSetWikiaPageProp( WPP_LVS_EMPTY_SUGGEST, $articleId, 1 );
			}
		}

		wfProfileOut( __METHOD__ );

		return $videos;
	}

	/**
	 * Get video suggestions
	 * @param $title - The title of the video
	 * @return array videos
	 */
	public function getVideoSuggestions( $title ) {
		wfProfileIn( __METHOD__ );

		// Find the article ID for this title
		$titleObj = Title::newFromText( $title, NS_FILE );
		$articleId = $titleObj->getArticleID();

		// See if we've already cached suggestions for this video
		$videos = wfGetWikiaPageProp( WPP_LVS_SUGGEST, $articleId );
		if ( !empty($videos) ) {
			$age = wfGetWikiaPageProp( WPP_LVS_SUGGEST_DATE, $articleId );

			// If we're under the TTL then return these results, otherwise
			// fall through and generate some new ones
			if ( time() - $age < self::SUGGESTIONS_TTL ) {
				wfProfileOut( __METHOD__ );
				return $videos;
			}
		}

		$videos = $this->suggestionSearch( $titleObj );

		wfProfileOut( __METHOD__ );
		return $videos;
	}

	/**
	 * Search for related video titles
	 * @param Title|string $title - Either a Title object or title text
	 * @param bool $test - Operate in test mode.  Allows commandline scripts to implement --test
	 * @param bool $verbose - Whether to output more debugging information
	 * @return array - A list of suggested videos
	 */
	public function suggestionSearch( $title, $test = false, $verbose = false ) {
		// Accept either a title string or title object here
		$titleObj = is_object( $title ) ? $title : Title::newFromText( $title, NS_FILE );
		$articleId = $titleObj->getArticleID();

		if ( !$test ) {
			wfSetWikiaPageProp( WPP_LVS_SUGGEST_DATE, $articleId, time() );
		}

		// flag for kept video
		$pageStatus = $this->getPageStatus( $articleId );
		$isKeptVideo = $this->isStatusKeep( $pageStatus );

		// get videos that have been suggested (kept videos)
		$historicalSuggestions = array_flip( $this->getHistoricalSuggestions( $articleId ) );

		// get current suggestions
		$suggestTitles = array();
		$suggest = wfGetWikiaPageProp( WPP_LVS_SUGGEST, $articleId );
		$suggestions = array();
		if ( !empty( $suggest ) ) {
			if ( $verbose ) {
				echo "\tExamining the ".count($suggest)." current match(es)\n";
			}

			foreach ( $suggest as $video ) {
				$suggestTitles[$video['title']] = 1;
				if ( $isKeptVideo && array_key_exists( $video['title'], $historicalSuggestions ) ) {
					if ( $verbose ) {
						echo "\t\t[FILTER] Match was already suggested in the past: '".$video['title']."'\n";
					}
					continue;
				}

				$suggestions[] = $video;
			}
		}

		$readableTitle = $titleObj->getText();
		$params = array( 'title' => $readableTitle );

		/* Comment this out until the minseconds/maxseconds params are handled correctly by
		   the searchVidoesByTitle method (MAIN-1276)
		$file = wfFindFile( $titleObj );
		if ( !empty( $file ) ) {
			$serializedMetadata = $file->getMetadata();
			if ( !empty( $serializedMetadata ) ) {
				$metadata = unserialize( $serializedMetadata );
				if ( !empty( $metadata['duration'] ) ) {
					$duration = $metadata['duration'];
					$params['minseconds'] = $duration - min( [ $duration, self::DURATION_DELTA ] );
					$params['maxseconds'] = $duration + min( [ $duration, self::DURATION_DELTA ] );
				}
			}
		}
		*/

		// get search results
		$videoRows = $this->app->sendRequest( 'WikiaSearchController', 'searchVideosByTitle', $params )
							   ->getData();

		if ( $verbose ) {
			echo "\tSearch found ".count($videoRows)." potential new match(es)\n";
		}

		$videos = array();
		$count = 0;
		$isNew = false;

		$titleTokenized = $this->getNormalizedTokens( $readableTitle );

		// Reuse code from VideoHandlerHelper
		$helper = new VideoHandlerHelper();

		// Get the play button image to overlay on the video
		$playButton = WikiaFileHelper::videoPlayButtonOverlay( self::THUMBNAIL_WIDTH, self::THUMBNAIL_HEIGHT );

		foreach ( $videoRows as $videoInfo ) {
			$rowTitle = preg_replace( '/^File:/', '',  $videoInfo['title'] );
			$videoRowTitleTokenized = $this->getNormalizedTokens( $rowTitle );

			$similarity = $this->getJaccard()->similarity( $titleTokenized, $videoRowTitleTokenized );
			if ( $similarity < self::MIN_JACCARD_SIMILARITY ) {
				if ( $verbose ) {
					echo "\t\t[FILTER] Below Jaccard similarity threshold ($similarity < ".self::MIN_JACCARD_SIMILARITY."): '$rowTitle'\n";
				}
				continue;
			}

			$videoTitle = preg_replace( '/.+File:/', '', urldecode( $videoInfo['url'] ) );

			// skip if the video has already been suggested (from kept videos)
			if ( $isKeptVideo ) {
				if ( array_key_exists( $videoTitle, $historicalSuggestions ) ) {
					if ( $verbose ) {
						echo "\t\t[FILTER] New suggestion was suggested previously: '$videoTitle'\n";
					}
					continue;
				} else {
					$isNew = true;
				}
			}

			// skip if the video exists in the current suggestions
			if ( array_key_exists( $videoTitle, $suggestTitles ) ) {
				if ( $verbose ) {
					echo "\t\t[FILTER] New suggestion is already suggested: '$videoTitle'\n";
				}
				continue;
			} else {
				$isNew = true;
			}

			// get video detail
			$videoDetail = $helper->getVideoDetailFromWiki( $this->wg->WikiaVideoRepoDBName,
															$videoInfo['title'],
															self::THUMBNAIL_WIDTH,
															self::THUMBNAIL_HEIGHT,
															self::POSTED_IN_ARTICLES );

			// Go to the next suggestion if we can't get any details for this one
			if ( empty( $videoDetail ) ) {
				if ( $verbose ) {
					echo "\t\t[FILTER] Can't find video detail for '$videoTitle'\n";
				}
				continue;
			}

			// get video overlay
			$videoOverlay =  WikiaFileHelper::videoInfoOverlay( self::THUMBNAIL_WIDTH, $videoDetail['fileTitle'] );
			$videoDetail['videoPlayButton'] = $playButton;
			$videoDetail['videoOverlay'] = $videoOverlay;

			$videos[] = $videoDetail;

			$count++;
			if ( $count >= self::NUM_SUGGESTIONS ) {
				break;
			}
		}

		// combine current suggestions and new suggestions
		$videos = array_slice( array_merge( $videos, $suggestions ), 0 , self::NUM_SUGGESTIONS );

		// If we're just testing don't set any page props
		if ( !$test ) {
			// Cache these suggestions
			if ( empty( $videos ) ) {
				wfSetWikiaPageProp( WPP_LVS_EMPTY_SUGGEST, $articleId, 1 );
			} else {
				wfDeleteWikiaPageProp( WPP_LVS_EMPTY_SUGGEST, $articleId );
				wfSetWikiaPageProp( WPP_LVS_SUGGEST, $articleId, $videos );

				// set page status
				if ( !$this->isStatusSwap( $pageStatus ) && !$this->isStatusForever( $pageStatus ) && $isNew ) {
					$this->setPageStatusNew( $articleId );
				}
			}
		}

		wfProfileOut( __METHOD__ );

		// The first video in the array is the top choice.
		return $videos;
	}

	/**
	 * Set flag in status
	 * @param integer $status
	 * @param integer $flag
	 */
	protected function setFlag( &$status, $flag ) {
		$status |= $flag;
	}

	/**
	 * Clear flag in status
	 * @param integer $status
	 * @param integer $flag
	 */
	protected function clearFlag( &$status, $flag ) {
		$status &= ~$flag;
	}

	/**
	 * Check if the flag is set in status
	 * @param integer $status
	 * @param integer $flag
	 * @return boolean
	 */
	protected function isFlagSet( $status, $flag ) {
		return ( $status & $flag );
	}

	/**
	 * Set the LVS status of the file page
	 * @param integer $articleId - The ID of a video's file page
	 * @param integer $value
	 */
	public function setPageStatus( $articleId, $value = 0 ) {
		wfSetWikiaPageProp( WPP_LVS_STATUS, $articleId, $value );
	}

	/**
	 * Set the LVS status info of the file page
	 * @param integer $articleId - The ID of a video's file page
	 * @param array $value
	 */
	public function setPageStatusInfo( $articleId, $value = array() ) {
		wfSetWikiaPageProp( WPP_LVS_STATUS_INFO, $articleId, $value );
	}

	/**
	 * Get normal swap status
	 * @return integer
	 */
	public function getStatusSwapNorm() {
		return ( self::STATUS_SWAP & ~self::STATUS_EXACT );
	}

	/**
	 * Get swap with exact match status
	 * @return integer
	 */
	public function getStatusSwapExact() {
		return ( self::STATUS_SWAP | self::STATUS_EXACT );
	}

	/**
	 * Get keep status
	 * @param bool $isForever
	 * @return integer $status
	 */
	public function getStatusKeep( $isForever = false ) {
		$status = self::STATUS_KEEP;
		if ( $isForever ) {
			$status |= self::STATUS_FOREVER;
		}
		return $status;
	}

	/**
	 * Set the LVS status info of the file page to swapped
	 * @param integer $articleId - The ID of a video's file page
	 * @param array $value
	 */
	public function setPageStatusInfoSwap( $articleId, $value = array() ) {
		$value['status'] = $this->getStatusSwapNorm();
		$value['created'] = time();
		$value['userid'] = $this->wg->User->getId();
		$this->setPageStatusInfo( $articleId, $value );
	}

	/**
	 * Set the LVS status info of the file page to swapped with an exact match
	 * @param integer $articleId - The ID of a video's file page
	 * @param array $value
	 */
	public function setPageStatusInfoSwapExact( $articleId, $value = array() ) {
		$value['status'] = $this->getStatusSwapExact();
		$value['created'] = time();
		$value['userid'] = $this->wg->User->getId();
		$this->setPageStatusInfo( $articleId, $value );
	}

	/**
	 * Set the LVS status info of the file page to kept
	 * @param integer $articleId - The ID of a video's file page
	 * @param array $value
	 * @param boolean $isForever
	 */
	public function setPageStatusInfoKeep( $articleId, $value = array(), $isForever = false ) {
		// set status info
		$value['status'] = $this->getStatusKeep( $isForever );
		$value['created'] = time();
		$value['userid'] = $this->wg->User->getId();
		$this->setPageStatusInfo( $articleId, $value );
	}

	/**
	 * Set the LVS status of the file page to swapped
	 * @param integer $newArticleId - The ID of the new video's file page
	 * @param integer $articleId - The ID of a video's file page
	 */
	public function setPageStatusSwap( $newArticleId, $articleId ) {
		$status = $this->getPageStatus( $articleId );
		$this->setFlag( $status, $this->getStatusSwapNorm() );
		$this->clearFlag( $status, self::STATUS_KEEP | self::STATUS_EXACT | self::STATUS_NEW | self::STATUS_FOREVER );
		$this->setPageStatus( $newArticleId, $status );
	}

	/**
	 * Set the LVS status of the file page to swapped with an exact match
	 * @param integer $newArticleId - The ID of the new video's file page
	 * @param integer $articleId - The ID of a video's file page
	 */
	public function setPageStatusSwapExact( $newArticleId, $articleId ) {
		$status = $this->getPageStatus( $articleId );
		$this->setFlag( $status, $this->getStatusSwapExact() );
		$this->clearFlag( $status, self::STATUS_KEEP | self::STATUS_NEW | self::STATUS_FOREVER );
		$this->setPageStatus( $newArticleId, $status );
	}

	/**
	 * Set the LVS status of the file page to kept
	 * @param integer $articleId - The ID of a video's file page
	 * @param boolean $isForever
	 */
	public function setPageStatusKeep( $articleId, $isForever = false ) {
		$status = $this->getPageStatus( $articleId );
		$this->setFlag( $status, $this->getStatusKeep( $isForever ) );
		$this->clearFlag( $status, self::STATUS_SWAP | self::STATUS_EXACT | self::STATUS_NEW );
		if ( !$isForever ) {
			$this->clearFlag( $status, self::STATUS_FOREVER );
		}
		$this->setPageStatus( $articleId, $status );
	}

	/**
	 * Set the LVS status of the file page to swappable
	 * @param integer $articleId - The ID of a video's file page
	 */
	public function setPageStatusSwappable( $articleId ) {
		$status = $this->getPageStatus( $articleId );
		$this->setFlag( $status, self::STATUS_SWAPPABLE );
		$this->setPageStatus( $articleId, $status );
	}

	/**
	 * Set the LVS status of the file page to new and swappable
	 * @param integer $articleId - The ID of a video's file page
	 */
	public function setPageStatusNew( $articleId ) {
		$status = $this->getPageStatus( $articleId );
		$this->setFlag( $status, self::STATUS_SWAPPABLE | self::STATUS_NEW );
		$this->setPageStatus( $articleId, $status );
	}

	/**
	 * Clear new status for the LVS status of the file page
	 * @param integer $articleId
	 */
	public function clearPageStatusNew( $articleId ) {
		$status = $this->getPageStatus( $articleId );
		$this->clearFlag( $status, self::STATUS_NEW );
		$this->setPageStatus( $articleId, $status );
	}

	/**
	 * Clear the LVS status of the file page - Status: keep, swap, exact, new, forever status
	 * @param integer $articleId
	 */
	public function clearPageStatus( $articleId ) {
		$status = $this->getPageStatus( $articleId );
		$this->clearFlag( $status, self::STATUS_KEEP | self::STATUS_SWAP | self::STATUS_EXACT | self::STATUS_NEW | self::STATUS_FOREVER );
		$this->setPageStatus( $articleId, $status );
	}

	/**
	 * delete the LVS status of the file page
	 * @param integer $articleId
	 */
	public function deletePageStatus( $articleId ) {
		wfDeleteWikiaPageProp( WPP_LVS_STATUS, $articleId );
	}

	/**
	 * Delete the LVS status info of the file page
	 * @param integer $articleId
	 */
	public function deletePageStatusInfo( $articleId ) {
		wfDeleteWikiaPageProp( WPP_LVS_STATUS_INFO, $articleId );
	}

	/**
	 * Get the status of the file page
	 * @param integer $articleId
	 * @return integer|null
	 */
	public function getPageStatus( $articleId ) {
		return wfGetWikiaPageProp( WPP_LVS_STATUS, $articleId );
	}

	/**
	 * Get the LVS status info of the file page
	 * @param integer $articleId
	 * @return array|null
	 */
	public function getPageStatusInfo( $articleId ) {
		return wfGetWikiaPageProp( WPP_LVS_STATUS_INFO, $articleId );
	}

	/**
	 * Check if the video is swapped from status info
	 * @param integer $articleId
	 * @return boolean $status
	 */
	public function isSwapped( $articleId ) {
		$pageStatus = $this->getPageStatusInfo( $articleId );
		$status = ( !empty( $pageStatus['status'] ) && $this->isStatusSwap( $pageStatus['status'] ) );

		return $status;
	}

	/**
	 * Check if the video is kept from status info
	 * @param integer $articleId
	 * @return boolean $status
	 */
	public function isKept( $articleId ) {
		$pageStatus = $this->getPageStatusInfo( $articleId );
		$status = ( !empty( $pageStatus['status'] ) && $this->isStatusKeep( $pageStatus['status'] ) );

		return $status;
	}

	/**
	 * Check if the video is kept forever from status info
	 * @param integer $articleId
	 * @return boolean $status
	 */
	public function isKeptForever( $articleId ) {
		$pageStatus = $this->getPageStatusInfo( $articleId );
		$status = ( !empty( $pageStatus['status'] )
					&& $this->isStatusKeep( $pageStatus['status'] ) && $this->isStatusForever( $pageStatus['status'] ) );

		return $status;
	}

	/**
	 * Check if the status is kept
	 * @param integer $status
	 * @return boolean
	 */
	public function isStatusKeep( $status ) {
		return $this->isFlagSet( $status, self::STATUS_KEEP );
	}

	/**
	 * Check if the status is swap
	 * @param integer $status
	 * @return boolean
	 */
	public function isStatusSwap( $status ) {
		return $this->isFlagSet( $status, self::STATUS_SWAP );
	}

	/**
	 * Check if the status is exact match
	 * @param integer $status
	 * @return boolean
	 */
	public function isStatusExact( $status ) {
		return $this->isFlagSet( $status, self::STATUS_EXACT );
	}

	/**
	 * Check if the status is swap and not exact match
	 * @param integer $status
	 * @return boolean
	 */
	public function isStatusSwapNorm( $status ) {
		return ( $this->isStatusSwap( $status ) && !$this->isStatusExact( $status ) );
	}

	/**
	 * Check if the status is swap and exact match
	 * @param integer $status
	 * @return boolean
	 */
	public function isStatusSwapExact( $status ) {
		return ( $this->isStatusSwap( $status ) && $this->isStatusExact( $status ) );
	}

	/**
	 * Check if the status is swappable (the video has suggestions)
	 * @param integer $status
	 * @return boolean
	 */
	public function isStatusSwappable( $status ) {
		return $this->isFlagSet( $status, self::STATUS_SWAPPABLE );
	}

	/**
	 * Check if the status is new (the video has new suggestions)
	 * @param integer $status
	 * @return boolean
	 */
	public function isStatusNew( $status ) {
		return $this->isFlagSet( $status, self::STATUS_NEW );
	}

	/**
	 * Check if the status is forever
	 * @param integer $status
	 * @return boolean
	 */
	public function isStatusForever( $status ) {
		return $this->isFlagSet( $status, self::STATUS_FOREVER );
	}

	/**
	 * Move suggestion data to new article for WPP_LVS_SUGGEST, WPP_LVS_SUGGEST_DATE
	 * @param integer $oldArticleId
	 * @param integer $newArticleId
	 */
	public function moveSuggestionData( $oldArticleId, $newArticleId ) {
		$this->moveWikiaPageProp( WPP_LVS_SUGGEST, $oldArticleId, $newArticleId );
		$this->moveWikiaPageProp( WPP_LVS_SUGGEST_DATE, $oldArticleId, $newArticleId );
	}

	/**
	 * Move prop in page_wikia_props table to new article
	 * @param integer $type
	 * @param integer $oldArticleId
	 * @param integer $newArticleId
	 */
	public function moveWikiaPageProp( $type, $oldArticleId, $newArticleId ) {
		$prop = wfGetWikiaPageProp( $type, $oldArticleId );
		if ( !empty( $prop ) ) {
			wfDeleteWikiaPageProp( $type, $oldArticleId );
			wfSetWikiaPageProp( $type, $newArticleId, $prop );
		}
	}

	/**
	 * Add log to RecentChange
	 * @param Title $title
	 * @param string $action
	 * @param string $reason
	 */
	public function addLog( $title, $action, $reason = '' ) {
		$user = $this->wg->User;
		RecentChange::notifyLog( wfTimestampNow(), $title, $user, '', '', RC_EDIT, $action, $title, $reason, '' );
	}

	/**
	 * Add redirect link to the article
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
	 * Remove redirect link (last revision)
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
	 * Undelete page (local file)
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
	 * Get pagination
	 * @param integer $totalVideos
	 * @param integer $currentPage
	 * @param string $selectedSort
	 * @return string $pagination
	 */
	public function getPagination( $totalVideos, $currentPage, $selectedSort ) {
		$pagination = '';
		if ( $totalVideos > self::VIDEOS_PER_PAGE ) {
			$pages = Paginator::newFromArray( array_fill( 0, $totalVideos, '' ), self::VIDEOS_PER_PAGE );
			$pages->setActivePage( $currentPage - 1 );

			$linkToSpecialPage = SpecialPage::getTitleFor( "LicensedVideoSwap" )->escapeLocalUrl();
			$pagination = $pages->getBarHTML( $linkToSpecialPage.'?currentPage=%s&sort='.$selectedSort );
		}

		return $pagination;
	}

	/**
	 * Lazy-loads dependency
	 * @return \NlpTools\Stemmers\PorterStemmer
	 */
	protected function getStemmer() {
		if ( $this->stemmer === null ) {
			$this->stemmer = new PorterStemmer;
		}
		return $this->stemmer;
	}

	/**
	 * Lazy-loads dependency
	 * @return \NlpTools\Tokenizers\WhitespaceAndPunctuationTokenizer
	 */
	protected function getTokenizer() {
		if ( $this->tokenizer === null ) {
			$this->tokenizer = new WhitespaceAndPunctuationTokenizer;
		}
		return $this->tokenizer;
	}

	/**
	 * Lazy-loads dependency
	 * @return \NlpTools\Similarity\JaccardIndex
	 */
	protected function getJaccard() {
		if ( $this->jaccard === null ) {
			$this->jaccard = new JaccardIndex;
		}
		return $this->jaccard;
	}

	/**
	 * This gets all important tokens by tokenizing, stemming, and then stripping punctuation tokens
	 * @param string $str
	 * @return array
	 */
	protected function getNormalizedTokens( $str ) {
		return array_filter( $this->getStemmer()->stemAll( $this->getTokenizer()->tokenize( $str ) ),
				function( $val ) { return preg_match( '/[[:punct:]]/', $val ) == 0; } );
	}

	/**
	 * Get list of swapped or kept videos that we can undo
	 * @param $context
	 * @return array $videoList
	 */
	public function getUndoList( $context ) {
		$db = wfGetDB( DB_SLAVE );
		$result = $db->select(
			array( 'page_wikia_props' ),
			array( '*' ),
			array( 'propname' => WPP_LVS_STATUS_INFO ),
			__METHOD__
		);

		$videoList = array();
		while( $row = $db->fetchObject( $result ) ) {
			// Don't continue if we can't load the article
			$article = Article::newFromID( $row->page_id );
			if ( empty( $article ) ) {
				continue;
			}

			// The props hold all the information about the swap/keep
			$props = unserialize( $row->props );

			// Get the username and link to the user page
			$userName = $userLink = '';
			if ( !empty($props['userid']) ) {
				$userObj = User::newFromId( $props['userid'] );
				if ( $userObj ) {
					$userName = $userObj->getName();
					$userLink = $userObj->getUserPage()->getLocalURL();
				}
			}

			// Get the date in the proper format
			if ( empty($props['created']) ) {
				$createDate = '';
			} else {
				$createDate = $context->getLanguage()->userTimeAndDate( $props['created'], $context->getUser() );
			}

			// Get a few versions of the title text
			$titleObj = $article->getTitle();
			$dbKey = urlencode( $titleObj->getDBKey() );
			$titleURL = $titleObj->getLocalURL();

			// Create some links needed for linking to the file page and undoing swaps
			$titleLink = '<a href="'.$titleURL.'">'.$titleObj->getText().'</a>';
			$undoLink = $this->wg->Server."/wikia.php?controller=LicensedVideoSwapSpecial&method=restoreVideo&format=json&videoTitle={$dbKey}";
			$undoText = wfMessage('lvs-undo-swap')->plain();

			// Generate the proper log message and undo link for the swap/keep type
			if ( $this->isStatusSwapNorm( $props['status'] ) ) {
				$newTitleLink = '';
				$newDbKey = '';
				$redirect = $article->getRedirectTarget();
				if ( !empty( $redirect ) ) {
					$newDbKey = urlencode( $redirect->getDBKey() );
					$redirectURL = $redirect->getLocalURL();
					$newTitleLink = '<a href="'.$redirectURL.'">'.$redirect->getText().'</a>';
				}
				$logMessage = wfMessage( 'lvs-history-swapped', $titleLink, $newTitleLink )->plain();
				$undoLink .= "&newTitle=".$newDbKey;
			} else if ( $this->isStatusSwapExact( $props['status'] ) ) {
				$logMessage = wfMessage( 'lvs-history-swapped-exact', $titleLink )->plain();
			} else {
				$logMessage = wfMessage( 'lvs-history-kept', $titleLink )->plain();
				$undoText = wfMessage( 'lvs-undo-keep' )->plain();
			}

			$video = array(
				'pageId'      => $row->page_id,
				'logMessage'  => $logMessage,
				'undoLink'    => $undoLink,
				'undoText'    => $undoText,
				'userName'    => $userName,
				'userLink'    => $userLink,
				'created'     => empty( $props['created'] ) ? '' : $props['created'], // Used for sorting below
				'createDate'  => $createDate,
				'undo'        => $this->wg->Server."/wikia.php?controller=LicensedVideoSwapSpecial&method=restoreVideo&format=json&videoTitle={$dbKey}",
			);

			$videoList[] = $video;
		}

		usort($videoList, function ($a, $b) { return strcmp($b['created'], $a['created']); });
		return $videoList;
	}

	/**
	 * Get historical suggested videos from page status (WPP_LVS_STATUS_INFO)
	 * @param integer $articleId
	 * @return array $suggestedVideos
	 */
	public function getHistoricalSuggestions( $articleId ) {
		$pageStatusInfo = $this->getPageStatusInfo( $articleId );
		$suggestedVideos = empty( $pageStatusInfo['suggested'] ) ? array() : $pageStatusInfo['suggested'];

		return $suggestedVideos;
	}

	/**
	 * Get valid videos - list of video title
	 * @param array $videos
	 * @return array $validVideos
	 */
	public function getValidVideos( $videos ) {
		$validVideos = array();
		foreach ( $videos as $videoTitle ) {
			$title = urldecode( $videoTitle );
			$file = WikiaFileHelper::getVideoFileFromTitle( $title );
			if ( !empty( $file ) ) {
				$validVideos[] = $file->getTitle()->getDBKey();
			}
		}

		return $validVideos;
	}

	/**
	 * Get total number of new videos for the user
	 * @return integer $total[$userId]
	 */
	public function getTotalNewVideos() {
		wfProfileIn( __METHOD__ );

		$userId = $this->wg->User->getId();
		$memcKey = $this->getMemcKeyTotalNewVideos();
		$total = $this->wg->Memc->get( $memcKey );
		if ( !is_array( $total ) || !array_key_exists( $userId, $total ) ) {
			$statusNew = self::STATUS_NEW;
			$pageStatus = WPP_LVS_STATUS;
			$visitedDate = $this->wg->User->getOption( self::USER_VISITED_DATE );
			if ( empty( $visitedDate ) ) {
				$sqlJoin = '';
			} else {
				$sqlJoin = "AND p2.props > $visitedDate";
			}

			$db = wfGetDB( DB_SLAVE );

			$sql = <<<SQL
				SELECT count(*) total
				FROM page_wikia_props p1
				LEFT JOIN page_wikia_props p2 ON p1.page_id = p2.page_id AND p2.propname = 20 $sqlJoin
				WHERE p1.propname = $pageStatus AND (p1.props & $statusNew != 0) AND p2.page_id is not null
SQL;

			$result = $db->query( $sql, __METHOD__ );

			$total[$userId] = 0;
			while ( $row = $db->fetchObject( $result ) ) {
				$total[$userId] = $row->total;
				break;
			}

			$this->wg->Memc->set( $memcKey, $total, 60*60*24 );
		}

		wfProfileOut( __METHOD__ );

		return $total[$userId];

	}

	/**
	 * Get memcache key for total new videos
	 * @return string
	 */
	public function getMemcKeyTotalNewVideos() {
		return wfMemcKey( 'licensedvideoswap', 'total_new_videos' );
	}

	/**
	 * Clear cache for total new videos
	 * @param integer|null $userId - if userId is null, delete whole cache value
	 */
	public function invalidateCacheTotalNewVideos( $userId = null ) {
		if ( empty( $userId ) ) {
			$this->wg->Memc->delete( $this->getMemcKeyTotalNewVideos() );
		} else {
			$memcKey = $this->getMemcKeyTotalNewVideos();
			$total = $this->wg->Memc->get( $memcKey );
			if ( is_array( $total ) && array_key_exists( $userId, $total ) ) {
				unset( $total[$userId] );
				$this->wg->Memc->set( $memcKey, $total, 60*60*24 );
			}
		}
	}

	/**
	 * Get alert badge for AdminDashboard extension
	 * @return string
	 */
	public function getAlertBadge() {
		$badge = '';
		$newVideos = $this->getTotalNewVideos();
		if ( !empty( $newVideos ) ) {
			$badgeParams = array(
				'type' => 'default',
				'vars' => array( 'number' => $newVideos ),
			);
			$badge = \Wikia\UI\Factory::getInstance()->init( 'alert_badge' )->render( $badgeParams );
		}

		return $badge;
	}

	/**
	 * Get redirect url - when user swap or keep last video of the page
	 * @param integer $currentPage
	 * @param string $sort
	 * @return string $url
	 */
	public function getRedirectUrl( $currentPage, $sort ) {
		if ( $currentPage > 1 ) {
			$currentPage--;
		}

		$params = array(
			'currentPage' => $currentPage,
			'sort' => $sort,
		);
		$url = SpecialPage::getTitleFor( 'LicensedVideoSwap' )->getFullURL( $params );

		return $url;
	}

}
