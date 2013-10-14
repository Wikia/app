<?php

/**
 * VideoInfo Class
 * @author Liz Lee, Saipetch Kongkatong
 */
class VideoInfo extends WikiaModel {

	const SCHEMA_VERSION = 2;

	protected $videoTitle = 0;
	protected $provider = '';
	protected $addedAt = 0;
	protected $addedBy = 0;
	protected $premium = 0;
	protected $duration = 0;
	protected $hdfile = 0;
	protected $removed = 0;
	protected $featured = 0;

	protected static $fields = array(
		'videoTitle',
		'provider',
		'addedAt',
		'addedBy',
		'premium',
		'duration',
		'hdfile',
		'removed',
		'featured',
	);

	public function __construct( $data = array() ) {
		foreach ( $data as $key => $value ) {
			$this->$key = $value;
		}

		parent::__construct();
	}

	/**
	 * set video title
	 * @param string $videoTitle
	 */
	public function setVideoTitle( $videoTitle ) {
		$this->videoTitle = $videoTitle;
	}

	/**
	 * Set the provider name
	 * @param string $provider The name of the provider for this video (e.g., 'ooyala', 'anyclip')
	 */
	public function setProvider( $provider ) {
		$this->provider = $provider;
	}

	/**
	 * set video removed value
	 * @param boolean $value
	 */
	public function setRemoved( $value = true ) {
		$this->removed = (int) $value;
	}

	/**
	 * set added at
	 * @param integer $value
	 */
	public function setAddedAt( $value ) {
		$this->addedAt = $value;
	}

	/**
	 * get video title
	 * @return string videoTitle
	 */
	public function getVideoTitle() {
		return $this->videoTitle;
	}

	/**
	 * Return the video provider for this video
	 * @return string The video provider string
	 */
	public function getProvider() {
		return $this->provider;
	}

	public function getAddedAt() {
		return $this->addedAt;
	}

	public function getAddedBy() {
		return $this->addedBy;
	}

	public function getDuration() {
		return $this->duration;
	}

	/**
	 * check if it is premium video
	 * @return boolean
	 */
	public function isPremium() {
		return ( $this->premium == 1 );
	}

	/**
	 * check if it is hd file
	 * @return boolean
	 */
	public function isHdfile() {
		return ( $this->hdfile == 1 );
	}

	/**
	 * check if it is removed
	 * @return boolean
	 */
	public function isRemoved() {
		return ( $this->removed == 1 );
	}

	/**
	 * check if it is featured video
	 * @return boolean
	 */
	public function isFeatured() {
		return ( $this->featured == 1 );
	}

	/**
	 * Update data in the database
	 * @return boolean - Returns true if rows were updated, false if no rows were updated
	 */
	protected function updateDatabase() {
		wfProfileIn( __METHOD__ );

		$affected = false;
		if ( !wfReadOnly() && !empty($this->videoTitle) ) {
			$db = wfGetDB( DB_MASTER );

			$db->update(
				'video_info',
				array(
					'provider' => $this->provider,
					'added_at' => $this->addedAt,
					'added_by' => $this->addedBy,
					'duration' => $this->duration,
					'premium' => $this->premium,
					'hdfile' => $this->hdfile,
					'removed' => $this->removed,
					'featured' => $this->featured,
				),
				array( 'video_title' => $this->videoTitle ),
				__METHOD__
			);

			$affected = $db->affectedRows() > 0;

			$db->commit();

			if ( $affected ) {
				$this->saveToCache();
			}
		}

		wfProfileOut( __METHOD__ );

		return $affected;
	}

	/**
	 * add video to database
	 * @return boolean $affected
	 */
	protected function addToDatabase() {
		wfProfileIn( __METHOD__ );

		$affected = false;
		if ( !wfReadOnly() ) {
			$db = wfGetDB( DB_MASTER );

			if ( empty($this->addedAt) ) {
				$this->addedAt = $db->timestamp();
			}

			$db->insert(
				'video_info',
				array(
					'video_title' => $this->videoTitle,
					'provider' => $this->provider,
					'added_at' => $this->addedAt,
					'added_by' => $this->addedBy,
					'duration' => $this->duration,
					'premium' => $this->premium,
					'hdfile' => $this->hdfile,
					'removed' => $this->removed,
					'featured' => $this->featured,
				),
				__METHOD__,
				'IGNORE'
			);

			$affected = $db->affectedRows() > 0;

			$db->commit();

			if ( $affected ) {
				$this->saveToCache();
			}
		}

		wfProfileOut( __METHOD__ );

		return $affected;
	}

	/**
	 * remove video from database
	 */
	protected function removeFromDatabase() {
		wfProfileIn( __METHOD__ );

		if ( !wfReadOnly() ) {
			$db = wfGetDB( DB_MASTER );

			$db->delete(
				'video_info',
				array( 'video_title' => $this->videoTitle ),
				__METHOD__
			);

			$db->commit();

			$this->invalidateCache();
		}

		wfProfileOut( __METHOD__ );
	}

	/**
	 * Create the video_info table if it does not exist
	 */
	public function createTableVideoInfo() {
		wfProfileIn( __METHOD__ );

		if ( !wfReadOnly() ) {
			$db = wfGetDB( DB_MASTER );

			$sql =<<<SQL
				CREATE TABLE IF NOT EXISTS `video_info` (
					`video_title` varchar(255) CHARACTER SET latin1 COLLATE latin1_bin NOT NULL DEFAULT '',
					`provider` varchar(255),
					`added_at` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
					`added_by` int(10) unsigned NOT NULL DEFAULT '0',
					`duration` int(10) unsigned NOT NULL DEFAULT '0',
					`premium` tinyint(1) NOT NULL DEFAULT '0',
					`hdfile` tinyint(1) NOT NULL DEFAULT '0',
					`removed` tinyint(1) NOT NULL DEFAULT '0',
					`featured` tinyint(1) NOT NULL DEFAULT '0',
					`views_30day` int(10) unsigned DEFAULT '0',
					`views_total` int(10) unsigned DEFAULT '0',
					PRIMARY KEY (`video_title`),
					KEY `added_at` (`added_at`, `duration`),
					KEY `premium` (`premium`, `added_at`),
					KEY `hdfile` (`hdfile`, `added_at`),
					KEY `featured` (`featured`, `added_at`)
				) ENGINE=InnoDB DEFAULT CHARSET=latin1;
SQL;

			$db->query( $sql, __METHOD__ );
			$db->commit( __METHOD__ );
		}

		wfProfileOut( __METHOD__ );
	}

	// Define SQL needed to update the video_info table
	protected $versions = array(
		1 => "
			ALTER TABLE video_info
			ADD featured tinyint(1) NOT NULL DEFAULT 0 AFTER removed,
			ADD INDEX featured (featured, added_at)
		",
		2 => "
			ALTER TABLE video_info
			ADD provider varchar(255) AFTER video_title,
			ADD INDEX provider (provider, added_at)
		",
	);

	/**
	 * Perform an ALTER TABLE operation on the video_info table, given a specific schema version.  Note
	 * that this will only perform single, consecutive updates, e.g., to update from version 3 to version 5 of the
	 * schema, you must update first to 4 then update to 5.
	 *
	 * @param int $version The schema version to update to.  Defaults to SCHEMA_VERSION
	 */
	public function alterTableVideoInfo( $version = VideoInfo::SCHEMA_VERSION ) {
		wfProfileIn( __METHOD__ );

		if ( !wfReadOnly() ) {
			$db = wfGetDB( DB_MASTER );

			if ( $db->tableExists( 'video_info' ) ) {
				if ( isset($this->versions[$version]) ) {
					$sql = $this->versions[$version];
					$db->query( $sql, __METHOD__ );
					$db->commit( __METHOD__ );
				}
			} else {
				$this->createTableVideoInfo();
			}
		}

		wfProfileOut( __METHOD__ );
	}

	/**
	 * get video object from title
	 * @param string $videoTitle
	 * @return object $video
	 */
	public static function newFromTitle( $videoTitle ) {
		$app = F::App();

		wfProfileIn( __METHOD__ );

		$memKey = self::getMemcKey( $videoTitle );
		$videoData = $app->wg->Memc->get( $memKey );
		if ( is_array($videoData) ) {
			$video = new self( $videoData );
		} else {
			$db = wfGetDB( DB_SLAVE );

			$row = $db->selectRow(
				'video_info',
				'*',
				array( 'video_title' => $videoTitle ),
				__METHOD__
			);

			$video = null;
			if ( $row ) {
				$video = self::newFromRow( $row );
				$video->saveToCache();
			}
		}

		wfProfileOut( __METHOD__ );

		return $video;
	}

	/**
	 * get video object from row
	 * @param object $row
	 * @return array video
	 */
	protected static function newFromRow( $row ) {
		$data = array(
			'videoTitle' => $row->video_title,
			'provider' => $row->provider,
			'addedAt' => $row->added_at,
			'addedBy' => $row->added_by,
			'duration' => $row->duration,
			'premium' => $row->premium,
			'hdfile' => $row->hdfile,
			'removed' => $row->removed,
			'featured' => $row->featured,
		);

		$class = get_class();
		$video = new $class($data);

		return $video;
	}


	/**
	 * add video
	 * @return boolean
	 */
	public function addVideo() {
		return $this->addToDatabase();
	}

	/**
	 * add premium video
	 * @param integer $userId
	 * @return boolean
	 */
	public function addPremiumVideo( $userId ) {
		wfProfileIn( __METHOD__ );

		$this->addedAt = wfTimestamp( TS_MW );
		if ( !empty($userId) ) {
			$this->addedBy = $userId;
		}

		$affected = $this->addToDatabase();

		// create file page when adding premium video to wiki
		$videoHandlerHelper = new VideoHandlerHelper();
		$status = $videoHandlerHelper->addCategoryVideos( $this->videoTitle, $this->addedBy );

		wfProfileOut( __METHOD__ );

		return $affected;
	}

	/**
	 * reupload video
	 * @return boolean
	 */
	public function reuploadVideo() {
		$addedAt = wfTimestamp( TS_MW );
		$this->setAddedAt( $addedAt );

		return $this->updateDatabase();
	}

	/**
	 * restore video
	 * @return boolean
	 */
	public function restoreVideo() {
		$this->setRemoved( false );

		return $this->updateDatabase();
	}

	/**
	 * remove video
	 * @return boolean
	 */
	public function removeVideo() {
		$this->setRemoved();

		return $this->updateDatabase();
	}

	/**
	 * delete video
	 */
	public function deleteVideo() {
		$this->removeFromDatabase();
	}

	/**
	 * get memcache key
	 * @param string $videoTitle
	 * @return string
	 */
	protected static function getMemcKey( $videoTitle ) {
		return wfMemcKey( 'video_info', 'v1', md5($videoTitle) );
	}

	/**
	 * save to cache
	 */
	protected function saveToCache() {
		foreach ( self::$fields as $field ) {
			$cache[$field] = $this->$field;
		}

		$this->wg->Memc->set( self::getMemcKey( $this->getVideoTitle() ), $cache, 60*60*24*7 );
	}

	/**
	 * clear cache
	 */
	protected function invalidateCache() {
		$this->wg->Memc->delete( self::getMemcKey( $this->getVideoTitle() ) );
	}

}
