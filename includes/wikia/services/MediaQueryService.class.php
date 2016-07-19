<?php

use \Wikia\Cache\AsyncCache;

/**
 * This service provides methods for querying for media
 */
class MediaQueryService extends WikiaService {

	const MEDIA_TYPE_VIDEO = 'video';
	const MEDIA_TYPE_IMAGE = 'image';

	const SORT_RECENT_FIRST   = 'recent';
	const SORT_POPULAR_FIRST  = 'popular';
	const SORT_TRENDING_FIRST = 'trend';

	const DB_RECENT_COLUMN    = 'added_at';
	const DB_POPULAR_COLUMN   = 'views_total';
	const DB_TRENDING_COLUMN  = 'views_7day';

	private $mediaCache = array();

	/**
	 * Get list of images which:
	 *  - are used on pages (in content namespaces) matching given query
	 *  - match given query
	 *
	 * @param string $query A query to send to search
	 * @param int $limit Limit the results returned
	 * @return array An array of image DB keys
	 */
	public static function search( $query, $limit = 50 ) {
		global $wgContentNamespaces;
		wfProfileIn(__METHOD__);

		$images = array();

		$query_select = "SELECT il_to FROM imagelinks JOIN page ON page_id=il_from WHERE page_title = '%s' and page_namespace = %s";
		$query_glue = ' UNION DISTINCT ';

		// get articles and images matching given query (using API)
		$data = ApiService::call(array(
			'action' => 'query',
			'list' => 'search',
			'srnamespace' => implode( '|', array_merge( $wgContentNamespaces, array( NS_FILE ) ) ),
			'srlimit' => $limit,
			'srsearch' => $query,
		));

		if ( !empty($data['query']['search']) ) {
			$dbr = wfGetDB(DB_SLAVE);
			$query_arr = array();

			// get images used on pages returned by API query
			foreach ( $data['query']['search'] as $aResult ) {
				$query_arr[] = sprintf($query_select, $dbr->strencode(str_replace(' ', '_', $aResult['title'])), $aResult['ns']);
			}

			$query_sql = implode($query_glue, $query_arr);
			$res = $dbr->query($query_sql, __METHOD__);

			if ( $res->numRows() > 0 ) {
				while ( $row = $res->fetchObject() ) {
					if ( ! WikiaFileHelper::isTitleVideo( $row->il_to, false ) ) {
						$images[] = $row->il_to;
						if ( count($images) == $limit ) {
							break;
						}
					}
				}
			}
			$dbr->freeResult($res);
		}

		wfProfileOut(__METHOD__);
		return $images;
	}

	/**
	 * Search for images who's name contains the string given
	 *
	 * @param string $query The substring to search for
	 * @param int $page The page of results to return
	 * @param int $limit The number of results per page
	 * @return array An array of image DB keys
	 */
	public function searchInTitle( $query, $page=1, $limit=8 ) {
		wfProfileIn(__METHOD__);

		$totalImages = $this->getTotalImages( $query );

		$results = array(
			'total' => $totalImages,
			'pages' => ceil( $totalImages / $limit ),
			'page'=> $page
		);

		$dbr = wfGetDB( DB_SLAVE );

		$dbquerylikeLower = $dbr->buildLike( $dbr->anyString(), mb_strtolower( $query ), $dbr->anyString() );
		$dbquerylike = $dbr->buildLike( $dbr->anyString(), $query, $dbr->anyString() );

		$res = $dbr->select(
			array( 'image' ),
			array( 'img_name' ),
			array(
				"lower(img_name) $dbquerylikeLower or img_name $dbquerylike" ,
				"img_media_type in ('".MEDIATYPE_BITMAP."','".MEDIATYPE_DRAWING."')",
			),
			__METHOD__ ,
			array (
				"ORDER BY" => 'img_timestamp DESC',
				"LIMIT" => $limit,
				"OFFSET" => ($page*$limit-$limit) )
		);

		while ( $row = $dbr->fetchObject($res) ) {
			$results['images'][] = array('title' => $row->img_name);
		}

		wfProfileOut(__METHOD__);

		return $results;
	}

	/**
	 * Return the total number of images that contain the substring given
	 * @param string $name The substring counted image names should contain
	 * @return int The number of images found
	 */
	public function getTotalImages( $name = '' ) {
		wfProfileIn(__METHOD__);

		$memKey = $this->getMemKeyTotalImages( $name );
		$totalImages = $this->wg->Memc->get( $memKey );
		if ( !is_numeric($totalImages) ) {
			$db = wfGetDB( DB_SLAVE );

			$sqlWhere = array(
				"img_media_type in ('".MEDIATYPE_BITMAP."','".MEDIATYPE_DRAWING."')",
			);

			if ( !empty($name) ) {
				$dbquerylikeLower = $db->buildLike( $db->anyString(), mb_strtolower( $name ), $db->anyString() );
				$dbquerylike = $db->buildLike( $db->anyString(), $name, $db->anyString() );
				$sqlWhere[] = "lower(img_name) $dbquerylikeLower or img_name $dbquerylike";
			}

			$row = $db->selectRow(
				array( 'image' ),
				array( 'count(*) as cnt' ),
				$sqlWhere,
				__METHOD__
			);

			$totalImages = ( $row ) ? $row->cnt : 0 ;

			$this->wg->Memc->set( $memKey, $totalImages, 60*60*5 );
		}

		wfProfileOut(__METHOD__);

		return $totalImages;
	}

	protected function getMemKeyTotalImages( $name = '' ) {
		if ( !empty($name) ) {
			$name = md5( strtolower($name) );
		}

		return wfMemcKey( 'media', 'total_images', $name );
	}

	protected function getArticleMediaMemcKey( Title $title ) {
		return wfMemcKey( 'MQSArticleMedia', '1.4', $title->getDBkey() );
	}

	public function unsetCache( $title ) {
		$this->wg->memc->delete( $this->getArticleMediaMemcKey( $title ) );
	}

	/**
	 * @static
	 * @param WikiPage $article
	 * @param $editInfo
	 * @param $changed
	 * @return bool
	 */
	public static function onArticleEditUpdates( &$article, &$editInfo, $changed ) {
		// article links are updated, so we invalidate the cache
		$title = $article->getTitle();
		$mqs = new self( );
		$mqs->unsetCache( $title );
		return true;
	}

	/**
	 * Get essential information about media.  This includes:
	 *
	 *   title - The display name of the media Title passed in
	 *   desc - A section of the description for this image
	 *   type - Whether this is an image or a video, one of:
	 *          * MediaQueryService::MEDIA_TYPE_VIDEO
	 *          * MediaQueryService::MEDIA_TYPE_IMAGE
	 *   meta - Metadata for the media
	 *   thumbURL - Thumbnail URL for the media
	 *
	 * @param Title $media
	 * @param int $length Trim the returned article snippet to this character length
	 * @return array The associative array of data for this media Title
	 */
	public function getMediaData( Title $media, $length = 256 ) {
		return $this->getMediaDataFromCache( $media, $length );
	}

	private function getMediaDataFromCache( Title $media, $length = 256 ) {
		wfProfileIn(__METHOD__);

		if ( !isset($this->mediaCache[ $media->getDBKey() ] ) ) {
			$file = wfFindFile( $media );
			if ( !empty( $file ) && $file->canRender() ) {
				$articleService = new ArticleService( $media );

				$isVideo = WikiaFileHelper::isFileTypeVideo( $file );
				if ( $isVideo ) {
					/** @var $videoHandler VideoHandler */
					$videoHandler = $file->getHandler();
					$thumb = $file->transform( array('width'=> 320), 0 );
				}
				else {
					$videoHandler = false;
				}
				$this->mediaCache[ $media->getDBKey() ] = array(
					'title' => $media->getText(),
					'desc' => $articleService->getTextSnippet( $length ),
					'type' => ( $isVideo ? self::MEDIA_TYPE_VIDEO : self::MEDIA_TYPE_IMAGE ),
					'meta' => ( $videoHandler ? array_merge( $videoHandler->getVideoMetadata(true), $videoHandler->getEmbedSrcData() ) : array() ),
					'thumbUrl' => ( !empty($thumb) ? $thumb->getUrl() : false
				));
			}
			else {
				$this->mediaCache[ $media->getDBKey() ] = false;
			}
		}

		wfProfileOut(__METHOD__);
		return $this->mediaCache[ $media->getDBKey() ];
	}

	/**
	 * Find media used in an article
	 *
	 * @param Title $title
	 * @param string $type Whether to return videos or images.  If null, both are returned.
	 *                     If given, the following values are accepted:
	 *                     * One of MediaQueryService::MEDIA_TYPE_VIDEO
	 *                     * MediaQueryService::MEDIA_TYPE_IMAGE
	 * @param int $limit
	 * @return array|Mixed
	 */
	public function getMediaFromArticle( Title $title, $type = null, $limit = null ) {
		wfProfileIn(__METHOD__);

		$memcKey = $this->getArticleMediaMemcKey( $title );
		$titles = $this->wg->memc->get( $memcKey );
		if ( empty( $titles ) ) {
			$articleId = $title->getArticleId();
			if ( $articleId ) {
					$db = wfGetDB( DB_SLAVE );
					$result = $db->select(
							array('imagelinks'),
							array('il_to'),
							array("il_from = " . $articleId),
							__METHOD__,
							array( "ORDER BY" => "il_to" )
					);

					$titles = array();

					while ( $row = $db->fetchObject( $result ) ) {
						$media = Title::newFromText($row->il_to, NS_FILE);

						$mediaData = $this->getMediaDataFromCache( $media );
						if ( $mediaData !== false ) {
							$titles[] = $mediaData;
						}
					}
					$this->wg->memc->set($memcKey, $titles);
			}
		}
		if ( ! is_array($titles) ) $titles = array();

		if ( ( count($titles) > 0 ) && $type ) {
			$titles = array_filter($titles, function ($item) use ($type) {
				return $type == $item['type'];
			});
		}
		if ( $limit && ( $limit > 0 ) ) {
			$titles = array_slice( $titles, 0, $limit);
		}
		wfProfileOut(__METHOD__);
		return $titles;
	}

	/**
	 * Get list of recently uploaded files (RT #79288)
	 *
	 * @param $limit Limit the number of files returned to this number
	 *
	 * @return array An array of Title objects
	 */
	public static function getRecentlyUploaded( $limit ) {
		global $wgEnableAchievementsExt;
		wfProfileIn(__METHOD__);

		$images = false;

		// get list of recent log entries (type = 'upload')
		// limit*2 because of possible duplicates in log caused by image reuploads
		$res = ApiService::call(array(
			'action' => 'query',
			'list' => 'logevents',
			'letype' => 'upload',
			'leprop' => 'title',
			'lelimit' => $limit * 2,
		));

		if ( !empty($res['query']['logevents']) ) {
			foreach ( $res['query']['logevents'] as $entry ) {
				// ignore Video:foo entries from VideoEmbedTool
				if ( $entry['ns'] == NS_IMAGE && !WikiaFileHelper::isTitleVideo($entry['title']) ) {
					$image = Title::newFromText($entry['title']);
					if ( !empty($image) ) {
						// skip badges upload (RT #90607)
						if ( !empty($wgEnableAchievementsExt) && Ach_isBadgeImage($image->getText()) ) {
							continue;
						}

						// use keys to remove duplicates
						$images[$image->getDBkey()] = $image;

						// limit number of results
						if ( count($images) == $limit ) {
							break;
						}
					}
				}
			}

			// use numeric keys
			if ( is_array($images) ) {
				$images = array_values($images);
			}
		}

		wfProfileOut(__METHOD__);
		return $images;
	}

	/**
	 * Adaptor for getRecentlyUploaded to format as mediaTable.  Returns an array of associative arrays.
	 * The keys for the associative arrays are:
	 *
	 *   - title : The media name
	 *   - type : The media type, one of:
	 *            * One of MediaQueryService::MEDIA_TYPE_VIDEO
	 *            * MediaQueryService::MEDIA_TYPE_IMAGE
	 *
	 * @param int $limit Limit the number of items returned to this number
	 * @return array An array of arrays.
	 */
	public static function getRecentlyUploadedAsMediaTable( $limit ) {
		$output = array();
		$list = static::getRecentlyUploaded($limit);
		if ( empty($list) ) {
			return $output;
		}
		foreach ( $list as $title ) {
			$output[] = array(
				'title' => $title,
				'type'  => WikiaFileHelper::isTitleVideo( $title ) ? self::MEDIA_TYPE_VIDEO : self::MEDIA_TYPE_IMAGE
			);
		}
		return $output;

	}

	/**
	 * Get list of videos based on a few filters ($type, $providers, $category)
	 * and sort options ($sort, $limit, $page).
	 *
	 * @param string $type What type of videos to return.  Valid options are:
	 *                     - all     : Show all videos (DEFAULT)
	 *                     - premium : Show only premium videos
	 * @param integer $limit Limit the number of videos to return
	 * @param integer $page Specify a page of results (DEFAULT $page = 1)
	 * @param array $providers An array of content providers.  Only videos hosted by these providers
	 *                        will be returned (DEFAULT all providers)
	 * @param array|string $categories - category names.  Only videos tagged with these categories will be returned
	 *                         (DEFAULT any category)
	 * @return array $videoList
	 */
	public function getVideoList( $type = 'all', $limit = 0, $page = 1, $providers = [], $categories = [], $sort = self::SORT_RECENT_FIRST ) {
		wfProfileIn( __METHOD__ );

		// Setup the base query cache for a minimal amount of time
		$query = (new WikiaSQL())->cache( 5 )
			->SELECT( 'video_title' )
				->FIELD( 'provider' )
				->FIELD( 'added_at' )
				->FIELD( 'added_by' )
				->FIELD( 'duration' )
				->FIELD( 'views_total' )
				->DISTINCT( 'video_title' )
			->FROM( 'video_info' )
			->WHERE( 'removed' )->EQUAL_TO( 0 );

		switch ( $sort ) {
			case self::SORT_RECENT_FIRST:
				$query->ORDER_BY( self::DB_RECENT_COLUMN )->DESC();
				break;

			case self::SORT_POPULAR_FIRST:
				$query->ORDER_BY( self::DB_POPULAR_COLUMN )->DESC();
				break;

			case self::SORT_TRENDING_FIRST:
				$query->ORDER_BY( self::DB_TRENDING_COLUMN )->DESC();
				break;

			default:
				throw new InvalidArgumentException( "\$sort was none of '" . self::SORT_RECENT_FIRST . "', '"
					. self::SORT_POPULAR_FIRST . "', '" . self::SORT_TRENDING_FIRST . "'." );
				break;
		}


		if ( $categories ) {
				$query->JOIN( 'page' )->ON( 'video_title', 'page_title' )
					  ->JOIN( 'categorylinks' )->ON( 'page_id', 'cl_from' )
					  ->AND_( 'cl_to' )->IN( $categories )
					  ->AND_( 'page_namespace' )->EQUAL_TO( NS_FILE );
		}

		if ( $providers ) {
			$query->AND_( 'provider' )->IN( $providers );
		}

		if ( $type == 'premium' ) {
			$query->AND_( 'premium' )->EQUAL_TO( 1 );
		}

		if ( $limit ) {
			$query->LIMIT( $limit );
			if ( $page && $page > 1 ) {
				$query->OFFSET( ($page - 1) * $limit );
			}
		}

		$db = wfGetDB( DB_SLAVE );

		$videoList = $query->runLoop( $db, function( &$videoList, $row ) {
			$videoList[] = [
				'title'      => $row->video_title,
				'provider'   => $row->provider,
				'addedAt'    => $row->added_at,
				'addedBy'    => $row->added_by,
				'duration'   => $row->duration,
				// SUS-78 | Not used in template but used by API clients - GameGuides App
				'viewsTotal' => $row->views_total
			];
		});

		wfProfileOut( __METHOD__ );

		// Make sure we're returning an array
		return empty( $videoList ) ? [] : $videoList;
	}

	/**
	 * Get total number of videos in this wiki
	 *
	 * @return integer
	 */
	public function getTotalVideos() {
		wfProfileIn( __METHOD__ );

		$memKey = $this->getMemKeyTotalVideos();
		$totalVideos = $this->wg->Memc->get( $memKey );
		if ( !is_numeric($totalVideos) ) {
			$db = wfGetDB( DB_SLAVE );

			$row = $db->selectRow(
				array( 'video_info' ),
				array( 'count(video_title) cnt' ),
				array( 'removed' => 0 ),
				__METHOD__
			);

			$totalVideos = ($row) ? $row->cnt : 0 ;

			$this->wg->Memc->set( $memKey, $totalVideos, 60*60*24 );
		}

		wfProfileOut( __METHOD__ );

		return $totalVideos;
	}

	// Get memcache key for getTotalVideos
	protected function getMemKeyTotalVideos() {
		return wfMemcKey( 'videos', 'total_videos', 'v4' );
	}

	/**
	 * Clear the cache of total video count for this wiki
	 */
	public function clearCacheTotalVideos() {
		$this->wg->Memc->delete( $this->getMemKeyTotalVideos() );
	}

	/**
	 * Get number of total premium videos
	 * @return integer $totalVideos
	 */
	public function getTotalPremiumVideos() {
		wfProfileIn( __METHOD__ );

		$memKey = $this->getMemKeyTotalPremiumVideos();
		$totalVideos = $this->wg->Memc->get( $memKey );
		if ( !is_numeric($totalVideos) ) {
			$db = wfGetDB( DB_SLAVE );

			$row = $db->selectRow(
				array( 'video_info' ),
				array( 'count(video_title) cnt' ),
				array(
					'premium' => 1,
					'removed' => 0,
				),
				__METHOD__
			);

			$totalVideos = ($row) ? $row->cnt : 0 ;

			$this->wg->Memc->set( $memKey, $totalVideos, 60*60*24 );
		}

		wfProfileOut( __METHOD__ );

		return $totalVideos;
	}

	/**
	 * Get number of total videos in a given category
	 *
	 * @param string $category Category name
	 * @return integer
	 */
	public function getTotalVideosByCategory ( $category ) {

		wfProfileIn( __METHOD__ );

		$db = wfGetDB( DB_SLAVE );
		$memKey = $this->getMemKeyTotalVideosByCategory( $category );

		$totalViews = (new WikiaSQL())->cache( 60*60*6, $memKey )
			->SELECT( 'count(video_title) cnt' )
			->FROM( 'video_info' )
			->WHERE('removed' )->EQUAL_TO( 0 )
			->JOIN( 'page' )->ON( 'video_title', 'page_title' )
			->JOIN( 'categorylinks' )->ON( 'page_id', 'cl_from' )
				->AND_( 'cl_to' )->EQUAL_TO( $category )
				->AND_( 'page_namespace' )->EQUAL_TO( NS_FILE )
			->run( $db, function ( $result ) {
				$row = $result->fetchObject( $result );
				return $row->cnt;
			});

		wfProfileOut( __METHOD__ );

		return $totalViews;
	}

	protected function getMemKeyTotalVideosByCategory( $category ) {
		return wfMemcKey( 'videos', 'total_videos', $category );
	}

	/**
	 * Clear the cache of total videos for a given category
	 *
	 * @param $category The category name
	 */
	public function clearCacheTotalVideosByCategory( $category ) {
		$this->wg->Memc->delete( $this->getMemKeyTotalVideosByCategory( $category ) );
	}

	/**
	 * Get memcache key for total premium videos
	 */
	protected function getMemKeyTotalPremiumVideos() {
		return wfMemcKey( 'videos', 'total_premium_videos', 'v3' );
	}

	/**
	 * Clear the cache of total premium video count
	 */
	public function clearCacheTotalPremiumVideos() {
		$this->wg->Memc->delete( $this->getMemKeyTotalPremiumVideos() );
	}

	/**
	 * Get memcache key for total video views
	 * @TODO: Remove $async once EnableAsyncVideoViewCache is removed - @see VID-2103
	 *
	 * @param $async bool
	 * @return string
	 */
	public static function getMemKeyTotalVideoViews( $async = false ) {
		if ( $async ) {
			return wfMemcKey( 'videos', 'total_video_views', 'v4', 'async' );
		}
		return wfMemcKey( 'videos', 'total_video_views', 'v4' );
	}

	/**
	 * Get total video views by title
	 *
	 * @param string $title
	 * @return integer $videoViews
	 */
	public static function getTotalVideoViewsByTitle( $title ) {
		$app = F::app();

		wfProfileIn( __METHOD__ );

		$cacheTtl = 7200; // 2 hours for caching the result in memcache
		// 24hr allowance for returning stale results until new cache is built
		// Adjusted to increase the caching benefit for infrequently viewed videos
		$staleCacheTtl = 86400;
		$asyncCacheEnabled = !empty( $app->wg->EnableAsyncVideoViewCache );

		$hashTitle = md5( $title );
		$memKeyBase = self::getMemKeyTotalVideoViews( $asyncCacheEnabled );

		// @TODO: Remove EnableAsyncVideoViewCache and the else clause,
		// after verifying the async caching solution works (@see VID-2103)
		if ( $asyncCacheEnabled ) {
			$cacheKey = $memKeyBase . '-' . $hashTitle;
			$videoViews = ( new AsyncCache() )
				->key( $cacheKey )
				->ttl( $cacheTtl )
				->callback( [__CLASS__, 'getTotalVideoViewsByTitleFromDb'], [ $title ] )
				->staleOnMiss( $staleCacheTtl )
				->value();
		} else {
			$cacheKey = $memKeyBase . '-' . substr( $hashTitle, 0, 2 );
			$videoList = $app->wg->Memc->get( $cacheKey );
			if ( !isset( $videoList[ $hashTitle ] ) ) {
				$viewCount = VideoInfoHelper::getTotalViewsFromTitle( $title );
				$videoList[ $hashTitle ] = $viewCount;
				$app->wg->Memc->set( $cacheKey, $videoList, $cacheTtl );
			}
			$videoViews = $videoList[ $hashTitle ];
		}

		wfProfileOut( __METHOD__ );

		return $videoViews;
	}

	/**
	 * Get total video view count from DB, given video title
	 *
	 * @param string $title Video title
	 * @return integer
	 */
	public static function getTotalVideoViewsByTitleFromDb( $title ) {
		$db = wfGetDB( DB_SLAVE );

		$totalViews = ( new WikiaSQL() )
			->SELECT( 'views_total' )
			->FROM( 'video_info' )
			->WHERE( 'video_title' )->EQUAL_TO( $title )
			->run( $db, function ( $result ) {
					$row = $result->fetchObject( $result );
					return $row->views_total;
				});

		Wikia\Logger\WikiaLogger::instance()->info( 'Video view query to db', [
			'method' => __METHOD__,
			'title' => $title,
			'totalViews' => $totalViews,
		] );

		return $totalViews;
	}

}
