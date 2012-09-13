<?php
/**
 * This service provides methods for querying for media
 */
class MediaQueryService extends Service {

	const MEDIA_TYPE_VIDEO = 'video';
	const MEDIA_TYPE_IMAGE = 'image';

	/**
	 * Get list of images which:
	 *  - are used on pages (in content namespaces) matching given query
	 *  - match given query
	 */
	public static function search($query, $limit = 50) {
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

		if (!empty($data['query']['search'])) {
			$dbr = wfGetDB(DB_SLAVE);
			$query_arr = array();

			// get images used on pages returned by API query
			foreach ($data['query']['search'] as $aResult) {
				$query_arr[] = sprintf($query_select, $dbr->strencode(str_replace(' ', '_', $aResult['title'])), $aResult['ns']);
			}

			$query_sql = implode($query_glue, $query_arr);
			$res = $dbr->query($query_sql, __METHOD__);

			if($res->numRows() > 0) {
				while( $row = $res->fetchObject() ) {
					if ( ! WikiaFileHelper::isTitleVideo( $row->il_to, false ) ) {
						$images[] = $row->il_to;
						if (count($images) == $limit) {
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

	public static function searchInTitle($query, $page=1, $limit=8) {

		global $wgCityId, $wgExternalDatawareDB;

		$dbr = wfGetDB( DB_SLAVE, array(), $wgExternalDatawareDB );
		$dbquerylike = $dbr->buildLike( $dbr->anyString(), mb_strtolower( $query ), $dbr->anyString() );
		$res = $dbr->select(
			array( 'pages' ),
			array( 'count(page_id) as count ' ),
			array(
				'page_wikia_id' => $wgCityId,
				"page_title_lower $dbquerylike" ,
				'page_namespace' => NS_FILE,
				'page_status' => 0 ),
			__METHOD__
		);

		$row = $dbr->fetchRow($res);

		$results = array(
			'total' => $row['count'],
			'pages' => ceil( $row['count'] / $limit ),
			'page'=> $page
		);

		$res = $dbr->select(
			array( 'pages' ),
			array( ' page_title ' ),
			array(
				'page_wikia_id' => $wgCityId,
				"page_title_lower $dbquerylike",
				'page_namespace' => NS_FILE,
				'page_status' => 0 ),
			__METHOD__ ,
			array (
				"LIMIT" => $limit,
				"OFFSET" => ($page*$limit-$limit) )
		);

		while($row = $dbr->fetchObject($res)) {
			$results['images'][] = array('title' => $row->page_title);
		}

		return $results;
	}

	public function __construct() {
		$this->app = F::app();
	}

	protected function getArticleMediaMemcKey(Title $title) {
		return $this->app->wf->MemcKey( 'MQSArticleMedia', '1.0', $title->getDBkey() );
	}

	public function unsetCache( $title ) {
		$this->app->wg->memc->delete( $this->getArticleMediaMemcKey( $title ) );
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

	public function getMediaFromArticle(Title $title, $type = null, $limit = null) {
		wfProfileIn(__METHOD__);

		$memcKey = $this->getArticleMediaMemcKey( $title );
		$titles = $this->app->wg->memc->get( $memcKey );
		if ( empty( $titles ) ) {
			$articleId = $title->getArticleId();
			if ( $articleId ) {
					$db = $this->app->wf->GetDB( DB_SLAVE );
					$result = $db->select(
							array('imagelinks'),
							array('il_to'),
							array("il_from = " . $articleId),
							__METHOD__,
							array( "ORDER BY" => "il_to" )
					);

					$titles = array();

					while ($row = $db->fetchObject( $result ) ) {
						$media = F::build('Title', array($row->il_to, NS_FILE), 'newFromText');
						$file = wfFindFile( $media );
						if ( !empty( $file ) ) {
							if ( $file->canRender() ) {
								$titles[] = array('title' => $row->il_to,
										'type' => WikiaFileHelper::isTitleVideo( $media ) ? self::MEDIA_TYPE_VIDEO : self::MEDIA_TYPE_IMAGE);
							}
						}
					}
					$this->app->wg->memc->set($memcKey, $titles);
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
	 * @param $limit
	 *
	 * @return Title[]
	 */
	public static function getRecentlyUploaded($limit) {
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

		if (!empty($res['query']['logevents'])) {
			foreach($res['query']['logevents'] as $entry) {
				// ignore Video:foo entries from VideoEmbedTool
				if( $entry['ns'] == NS_IMAGE && !WikiaFileHelper::isTitleVideo($entry['title']) ) {
					$image = Title::newFromText($entry['title']);
					if (!empty($image)) {
						// skip badges upload (RT #90607)
						if (!empty($wgEnableAchievementsExt) && Ach_isBadgeImage($image->getText())) {
							continue;
						}

						// use keys to remove duplicates
						$images[$image->getDBkey()] = $image;

						// limit number of results
						if (count($images) == $limit) {
							break;
						}
					}
				}
			}

			// use numeric keys
			if (is_array($images)) {
				$images = array_values($images);
			}
		}

		wfProfileOut(__METHOD__);
		return $images;
	}

	/*
	 * adaptor for getRecentlyUploaded to format as mediaTable
	 */
	public static function getRecentlyUploadedAsMediaTable($limit) {
		$output = array();
		$list = static::getRecentlyUploaded($limit);
		if(empty($list)) {
			return $output;
		}
		foreach( $list as $title ) {
			$output[] = array(
				'title' => $title,
				'type'  => WikiaFileHelper::isTitleVideo( $title ) ? self::MEDIA_TYPE_VIDEO : self::MEDIA_TYPE_IMAGE
			);
		}
		return $output;

	}

	/**
	 * get list of all videos (order by timestamp)
	 * @param integer $limit
	 * @return array $videoList
	 */
	public function getVideoList( $onlyPremium = false, $limit = 10000 ) {
		$this->app->wf->ProfileIn( __METHOD__ );

		$memKey = $this->getMemKeyVideoList( $onlyPremium );
		$videoList = $this->app->wg->Memc->get( $memKey );
		if ( !is_array($videoList) ) {
			$db = $this->app->wf->GetDB( DB_SLAVE );

			$excludeList = array( 'png', 'gif', 'bmp', 'jpg', 'jpeg', 'ogg', 'ico', 'svg', 'mp3', 'wav', 'midi' );
			$sqlWhere = implode( "','", $excludeList );

			if ( $onlyPremium ) {
				$sqlSelect = '';
				$sqlUnion = '';
				$sqlOrderBy = '';
			} else {
				$sqlSelect = ", '' as ts";
				$sqlUnion = <<<SQL
					UNION ALL
					SELECT img_name as name, img_timestamp as ts
					FROM image
					WHERE img_media_type = 'VIDEO'
SQL;
				$sqlOrderBy = 'ORDER BY ts DESC';
			}

			// check for limit
			$sqlLimit = ( empty($limit) ) ? '' : "LIMIT $limit";

			$sql = <<<SQL
				SELECT  il_to as name $sqlSelect
				FROM `imagelinks`
				WHERE NOT EXISTS ( SELECT 1 FROM image WHERE img_media_type = 'VIDEO' AND img_name = il_to )
					AND LOWER(il_to) != 'placeholder'
					AND LOWER(SUBSTRING_INDEX(il_to, '.', -1)) NOT IN ( '$sqlWhere' )
				$sqlUnion
				$sqlOrderBy
				$sqlLimit
SQL;

			$result = $db->query( $sql, __METHOD__ );

			$videoList = array();
			while( $row = $db->fetchObject($result) ) {
				$title = F::build( 'Title', array( $row->name, NS_FILE ), 'newFromText' );
				$file = $this->app->wf->FindFile( $title );
				if ( $file instanceof File && $file->exists()
					&& F::build( 'WikiaFileHelper', array($title), 'isTitleVideo' ) ) {
					$videoList[] = array(
						'name' => $row->name,
						'timestamp' => $file->getTimestamp(),
					);
				}
			}

			// sort by timestamp
			uasort( $videoList, array($this, 'sortByMostRecent') );

			$this->app->wg->Memc->set( $memKey, $videoList, 60*60*24 );
		}

		$this->app->wf->ProfileOut( __METHOD__ );

		return $videoList;
	}

	// get memcache key for video list
	protected function getMemKeyVideoList( $onlyPremium = false ) {
		return $this->app->wf->MemcKey( 'videos', 'video_list', 'v2', intval($onlyPremium) );
	}

	// sort by most recently added
	protected function sortByMostRecent( $a, $b ) {
		$result = ( $a['timestamp'] < $b['timestamp'] ) ? 1 : -1;
		return $result;
	}

	// get number of total videos
	public function getTotalVideos() {
		$this->app->wf->ProfileIn( __METHOD__ );

		$memKey = $this->getMemKeyTotalVideos();
		$totalVideos = $this->app->wg->Memc->get( $memKey );
		if ( !is_numeric($totalVideos) ) {
			$videoList = $this->getVideoList();
			$totalVideos = count( $videoList );

			$this->app->wg->Memc->set( $memKey, $totalVideos, 60*60*24 );
		}

		$this->app->wf->ProfileOut( __METHOD__ );
		return $totalVideos;
	}

	//get memcache key for total videos
	protected function getMemKeyTotalVideos() {
		return $this->app->wf->MemcKey( 'videos', 'total_videos', 'v2' );
	}

	public function clearCacheVideoList() {
		$this->app->wg->Memc->delete( $this->getMemKeyVideoList() );
	}

	public function clearCachePremiumVideoList() {
		$this->app->wg->Memc->delete( $this->getMemKeyVideoList( true ) );
	}

	public function clearCacheTotalVideos() {
		$this->app->wg->Memc->delete( $this->getMemKeyTotalVideos() );
	}

	public function clearCacheSortedVideos() {
		if ( !empty($this->app->wg->EnableSpecialVideosExt) ) {
			/**
			 * @var $specialVideos SpecialVideosHelper
			 */
			$specialVideos = F::build( 'SpecialVideosHelper' );
			$specialVideos->clearCacheSortedVideos();
		}
	}

	public function clearCacheSortedPremiumVideos() {
		if ( !empty($this->app->wg->EnableSpecialVideosExt) ) {
			/**
			 * @var $specialVideos SpecialVideosHelper
			 */
			$specialVideos = F::build( 'SpecialVideosHelper' );
			$specialVideos->clearCacheSortedPremiumVideos();
		}
	}

	public function clearAllCacheVideos() {
		$this->clearCacheVideoList();
		$this->clearCacheTotalVideos();
		$this->clearCacheSortedVideos();
	}

	/**
	 * @param $title Title
	 */
	public function invalidateAllCacheVideos( $title ) {
		if ( $title->getNamespace() == NS_FILE ) {
			$file = wfFindFile( $title );
			if ( $file instanceof File && $file->exists() && F::build( 'WikiaFileHelper', array( $file ), 'isFileTypeVideo' ) ) {
				$this->clearAllCacheVideos();
			}
		}
	}

	// Hook: clear cache when file is uploaded
	/**
	 * @static
	 * @param $file LocalFile
	 * @param $reupload
	 * @param $hasDescription
	 * @return bool
	 */
	public static function onFileUpload( $file, $reupload, $hasDescription ) {
		$title = $file->getTitle();
		if ( $title instanceof Title && F::build( 'WikiaFileHelper', array( $file ), 'isFileTypeVideo' ) ) {
			/**
			 * @var $mediaService MediaQueryService
			 */
			$mediaService = F::build( __CLASS__ );
			if ( $file->isLocal() ) {
				$mediaService->clearCacheVideoList();
			} else {
				$mediaService->clearCachePremiumVideoList();
			}

			if ( !$reupload ) {
				$mediaService->clearCacheVideoList();
				$mediaService->clearCacheTotalVideos();
			}

			$mediaService->clearCacheSortedVideos();
		}

		return true;
	}

	// Hook: clear cache for premium videos
	public static function onArticleSaveComplete( $article, $user, $revision, $status ) {
		$insertedImages = Wikia::getVar( 'imageInserts' );
		$imageDeletes = Wikia::getVar( 'imageDeletes' );

		$changedImages = $imageDeletes;
		foreach( $insertedImages as $img ) {
			$changedImages[ $img['il_to'] ] = true;
		}

		foreach( $changedImages as $imageDBName => $dummy ) {
			$title = F::build( 'Title', array( NS_FILE, $imageDBName ), 'makeTitle' );
			if ( $title instanceof Title ) {
				$file = wfFindFile( $title );
				if ( $file instanceof File && $file->exists() && !$file->isLocal()
					&& F::build( 'WikiaFileHelper', array( $file ), 'isFileTypeVideo' ) ) {
					/**
					 * @var $mediaService MediaQueryService
					 */
					$mediaService = F::build( __CLASS__ );
					$mediaService->clearCachePremiumVideoList();
					$mediaService->clearCacheVideoList();
					$mediaService->clearCacheTotalVideos();
					$mediaService->clearCacheSortedPremiumVideos();
					break;
				}
			}
		}

		return true;
	}

	/**
	 * Clear cache when file is deleted
	 *
	 * @static
	 * @param $file LocalFile
	 * @param $oldimage
	 * @param $article
	 * @param $user User
	 * @param $reason
	 * @return bool
	 */
	public static function onFileDeleteComplete( &$file, $oldimage, $article, $user, $reason ) {
		$title = $file->getTitle();
		if ( $title instanceof Title && F::build( 'WikiaFileHelper', array( $file ), 'isFileTypeVideo' ) ) {
			/**
			 * @var $mediaService MediaQueryService
			 */
			$mediaService = F::build( __CLASS__ );
			if ( $file->isLocal() ) {
				$mediaService->clearAllCacheVideos();
			}
		}

		return true;
	}

	// Hook: clear cache when file is restored
	public static function onFileUndeleteComplete( $title, $versions, $user, $comment ) {
		/**
		 * @var $mediaService MediaQueryService
		 */
		$mediaService = F::build( __CLASS__ );
		$mediaService->invalidateAllCacheVideos( $title );

		return true;
	}

	// Hook: clear cache when file is renamed
	public static function onFileRenameComplete( &$form , &$oldTitle , &$newTitle ) {
		/**
		 * @var $mediaService MediaQueryService
		 */
		$mediaService = F::build( __CLASS__ );
		$mediaService->invalidateAllCacheVideos( $newTitle );

		return true;
	}

}
