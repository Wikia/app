<?php

/**
 * VideoInfo Class
 * @author Liz Lee, Saipetch Kongkatong
 */
class VideoInfo extends WikiaModel {

	protected $videoTitle = 0;
	protected $videoId = '';
	protected $provider = '';
	protected $addedAt = 0;
	protected $addedBy = 0;
	protected $duration = 0;
	protected $hdfile = 0;
	protected $removed = 0;
	protected $featured = 0;

	protected static $fields = array(
		'videoTitle',
		'videoId',
		'provider',
		'addedAt',
		'addedBy',
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
	 * Set video id
	 * @param string $videoId
	 */
	public function setVideoId( $videoId ) {
		$this->videoId = $videoId;
	}

	/**
	 * Set the provider name
	 * @param string $provider The name of the provider for this video (e.g., 'youtube')
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
	 * Get video title
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

	/**
	 * Get video id
	 * @return string
	 */
	public function getVideoId() {
		return $this->videoId;
	}

	/**
	 * Get datetime when user added the video
	 * @return string
	 */
	public function getAddedAt() {
		return $this->addedAt;
	}

	/**
	 * Get the id of user who added the video
	 * @return integer
	 */
	public function getAddedBy() {
		return $this->addedBy;
	}

	/**
	 * Get duration in second
	 * @return integer
	 */
	public function getDuration() {
		return $this->duration;
	}

	/**
	 * Check if it is premium video
	 * @return boolean
	 * @deprecated
	 */
	public function isPremium() {
		return false;
	}

	/**
	 * Check if it is hd file
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
	 * Check if it is featured video
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
					'video_id' => $this->videoId,
					'provider' => $this->provider,
					'added_at' => $this->addedAt,
					'added_by' => $this->addedBy,
					'duration' => $this->duration,
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
					'video_id' => $this->videoId,
					'provider' => $this->provider,
					'added_at' => $this->addedAt,
					'added_by' => $this->addedBy,
					'duration' => $this->duration,
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
			'videoId' => $row->video_id,
			'provider' => $row->provider,
			'addedAt' => $row->added_at,
			'addedBy' => $row->added_by,
			'duration' => $row->duration,
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

		// SUS-81: allow other features to clear their video_info-related caches
		Hooks::run( 'VideoInfoSaveToCache', [ $this ] );
	}

	/**
	 * clear cache
	 */
	protected function invalidateCache() {
		$this->wg->Memc->delete( self::getMemcKey( $this->getVideoTitle() ) );

		// SUS-81: allow other features to clear their video_info-related caches
		Hooks::run( 'VideoInfoInvalidateCache', [ $this ] );
	}
}
