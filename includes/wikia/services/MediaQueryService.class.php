<?php
/**
 * This service provides methods for querying for media
 */
class MediaQueryService extends WikiaService {

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

	public function searchInTitle( $query, $page=1, $limit=8 ) {
		$this->wf->ProfileIn(__METHOD__);

		$totalImages = $this->getTotalImages( $query );

		$results = array(
			'total' => $totalImages,
			'pages' => ceil( $totalImages / $limit ),
			'page'=> $page
		);

		$dbr = $this->wf->GetDB( DB_SLAVE );

		$dbquerylike = $dbr->buildLike( $dbr->anyString(), mb_strtolower( $query ), $dbr->anyString() );

		$res = $dbr->select(
			array( 'image' ),
			array( 'img_name' ),
			array(
				"img_name $dbquerylike" ,
				"img_media_type in ('".MEDIATYPE_BITMAP."','".MEDIATYPE_DRAWING."')",
			),
			__METHOD__ ,
			array (
				"ORDER BY" => 'img_timestamp DESC',
				"LIMIT" => $limit,
				"OFFSET" => ($page*$limit-$limit) )
		);

		while($row = $dbr->fetchObject($res)) {
			$results['images'][] = array('title' => $row->img_name);
		}

		$this->wf->ProfileOut(__METHOD__);

		return $results;
	}

	public function getTotalImages( $name = '' ) {
		$this->wf->ProfileIn(__METHOD__);

		$memKey = $this->getMemKeyTotalImages( $name );
		$totalImages = $this->wg->Memc->get( $memKey );
		if ( !is_numeric($totalImages) ) {
			$db = $this->wf->GetDB( DB_SLAVE );

			$sqlWhere = array(
				"img_media_type in ('".MEDIATYPE_BITMAP."','".MEDIATYPE_DRAWING."')",
			);

			if ( !empty($name) ) {
				$dbquerylike = $db->buildLike( $db->anyString(), mb_strtolower( $name ), $db->anyString() );
				$sqlWhere[] = "img_name $dbquerylike";
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

		$this->wf->ProfileIn(__METHOD__);

		return $totalImages;
	}

	protected function getMemKeyTotalImages( $name = '' ) {
		if ( !empty($name) ) {
			$name = md5( $name );
		}

		return $this->wf->MemcKey( 'media', 'total_images', $name );
	}

	protected function getArticleMediaMemcKey(Title $title) {
		return $this->wf->MemcKey( 'MQSArticleMedia', '1.4', $title->getDBkey() );
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

	public function getMediaFromArticle(Title $title, $type = null, $limit = null) {
		wfProfileIn(__METHOD__);

		$memcKey = $this->getArticleMediaMemcKey( $title );
		$titles = $this->wg->memc->get( $memcKey );
		if ( empty( $titles ) ) {
			$articleId = $title->getArticleId();
			if ( $articleId ) {
					$db = $this->wf->GetDB( DB_SLAVE );
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
						$articleService = F::build('ArticleService', array( $media->getArticleID() ));
						$file = wfFindFile( $media );
						if ( !empty( $file ) ) {
							if ( $file->canRender() ) {
								$isVideo = WikiaFileHelper::isFileTypeVideo( $file );
								if( $isVideo ) {
									/** @var $videoHandler VideoHandler */
									$videoHandler = $file->getHandler();
									$thumb = $file->transform( array('width'=> 320), 0 );
								}
								else {
									$videoHandler = false;
								}
								$titles[] = array(
									'title' => $media->getText(),
									'desc' => $articleService->getTextSnippet( 256 ),
									'type' => ( $isVideo ? self::MEDIA_TYPE_VIDEO : self::MEDIA_TYPE_IMAGE ),
									'meta' => ( $videoHandler ? array_merge( $videoHandler->getMetadata(true), $videoHandler->getEmbedSrcData() ) : array() ),
									'thumbUrl' => ( !empty($thumb) ? $thumb->getUrl() : false ));
							}
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

	/**
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
	 * @param string $sort [recent/popular/trend]
	 * @param string $filter [all/premium]
	 * @param integer $limit
	 * @param integer $page
	 * @return array $videoList
	 */
	public function getVideoList( $sort = 'recent', $filter = 'all', $limit = 0, $page = 1 ) {
		$this->wf->ProfileIn( __METHOD__ );

		$db = $this->wf->GetDB( DB_SLAVE );

		$sqlWhere = array();
		$sqlOptions = array();

		// check for filter
		if ( $filter == 'premium' ) {
			$sqlWhere['premium'] = 1;
		}

		// check for limit
		if ( !empty($limit) ) {
			$sqlOptions['LIMIT'] = $limit;
			if ( !empty($page) ) {
				$sqlOptions['OFFSET'] = ($page * $limit) - $limit;
			}
		}

		// check for sorting
		if ( $sort == 'popular' ) {
			$sqlOptions['ORDER BY'] = 'views_total DESC';
		} else if ( $sort == 'trend' ) {
			$sqlOptions['ORDER BY'] = 'views_30day DESC';
		} else {
			$sqlOptions['ORDER BY'] = 'added_at DESC';
		}

		$result = $db->select(
			array( 'video_info' ),
			array( 'video_title, added_at, added_by' ),
			$sqlWhere,
			__METHOD__,
			$sqlOptions
		);

		$videoList = array();
		while( $row = $db->fetchObject($result) ) {
			$videoList[] = array(
				'title' => $row->video_title,
				'addedAt' => $row->added_at,
				'addedBy' => $row->added_by,
			);
		}

		$this->wf->ProfileOut( __METHOD__ );

		return $videoList;
	}

	/**
	 * get number of total videos
	 * @return integer $totalVideos
	 */
	public function getTotalVideos() {
		$this->wf->ProfileIn( __METHOD__ );

		$memKey = $this->getMemKeyTotalVideos();
		$totalVideos = $this->wg->Memc->get( $memKey );
		if ( !is_numeric($totalVideos) ) {
			$db = $this->wf->GetDB( DB_SLAVE );

			if ( !VideoInfoHelper::videoInfoExists() ) {
				$excludeList = array( 'png', 'gif', 'bmp', 'jpg', 'jpeg', 'ogg', 'ico', 'svg', 'mp3', 'wav', 'midi' );
				$sqlWhere = implode( "','", $excludeList );

				$sql =<<<SQL
					SELECT il_to as name
					FROM imagelinks
					WHERE NOT EXISTS ( SELECT 1 FROM image WHERE img_media_type = 'VIDEO' AND img_name = il_to )
						AND LOWER(il_to) != 'placeholder'
						AND LOWER(SUBSTRING_INDEX(il_to, '.', -1)) NOT IN ( '$sqlWhere' )
					UNION ALL
					SELECT img_name as name
					FROM image
					WHERE img_media_type = 'VIDEO'
					LIMIT 10000
SQL;
				$result = $db->query( $sql, __METHOD__ );

				$totalVideos = 0;
				while ( $row = $db->fetchObject($result) ) {
					$title = F::build( 'Title', array( $row->name, NS_FILE ), 'newFromText' );
					$file = $this->wf->FindFile( $title );
					if ( $file instanceof File && $file->exists()
						&& F::build( 'WikiaFileHelper', array($title), 'isTitleVideo' ) ) {
						$totalVideos++;
					}
				}
			} else {
				$row = $db->selectRow(
					array( 'video_info' ),
					array( 'count(video_title) cnt' ),
					array(),
					__METHOD__
				);

				$totalVideos = ($row) ? $row->cnt : 0 ;
			}
			$totalVideos = $this->wg->Lang->formatNum($totalVideos);

			$this->wg->Memc->set( $memKey, $totalVideos, 60*60*24 );
		}

		$this->wf->ProfileOut( __METHOD__ );

		return $totalVideos;
	}

	//get memcache key for total videos
	protected function getMemKeyTotalVideos() {
		return $this->wf->MemcKey( 'videos', 'total_videos', 'v3' );
	}

	public function clearCacheTotalVideos() {
		$this->wg->Memc->delete( $this->getMemKeyTotalVideos() );
	}

	/**
	 * get number of total premium videos
	 * @return integer $totalVideos
	 */
	public function getTotalPremiumVideos() {
		$this->wf->ProfileIn( __METHOD__ );

		$memKey = $this->getMemKeyTotalPremiumVideos();
		$totalVideos = $this->wg->Memc->get( $memKey );
		if ( !is_numeric($totalVideos) ) {
			$db = $this->wf->GetDB( DB_SLAVE );

			$row = $db->selectRow(
				array( 'video_info' ),
				array( 'count(video_title) cnt' ),
				array( 'premium' => 1 ),
				__METHOD__
			);

			$totalVideos = ($row) ? $row->cnt : 0 ;

			$this->wg->Memc->set( $memKey, $totalVideos, 60*60*24 );
		}

		$this->wf->ProfileOut( __METHOD__ );

		return $totalVideos;
	}

	/**
	 * Get memcache key for total premium videos
	 */
	protected function getMemKeyTotalPremiumVideos() {
		return $this->wf->MemcKey( 'videos', 'total_premium_videos', 'v3' );
	}

	public function clearCacheTotalPremiumVideos() {
		$this->wg->Memc->delete( $this->getMemKeyTotalPremiumVideos() );
	}

	/**
	 * get total video views by title
	 * @param string $title
	 * @return integer $videoViews
	 */
	public static function getTotalVideoViewsByTitle( $title ) {
		$app = F::app();

		$app->wf->ProfileIn( __METHOD__ );

		$memKey = $app->wf->MemcKey( 'videos', 'total_video_views' );
		$videoList = $app->wg->Memc->get( $memKey );
		if ( !is_array($videoList) ) {
			if ( !VideoInfoHelper::videoInfoExists() ) {
				$videoList = F::build( 'DataMartService', array(), 'getVideoListViewsByTitleTotal' );
			} else {
				$db = $app->wf->GetDB( DB_SLAVE );

				$result = $db->select(
					array( 'video_info' ),
					array( 'video_title, views_total' ),
					array(),
					__METHOD__
				);

				$videoList = array();
				while ( $row = $db->fetchObject($result) ) {
					$hashTitle = md5( $row->video_title );
					$videoList[$hashTitle] = $row->views_total;
				}

				$app->wg->Memc->set( $memKey, $videoList, 60*60*24 );
			}
		}

		$hashTitle = md5( $title );
		$videoViews = ( isset($videoList[$hashTitle]) ) ? $videoList[$hashTitle] : 0;

		$app->wf->ProfileOut( __METHOD__ );

		return $videoViews;
	}

}
