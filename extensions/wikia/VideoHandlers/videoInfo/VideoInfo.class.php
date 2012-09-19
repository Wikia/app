<?php

/**
 * VideoInfo Class
 * @author Liz Lee, Saipetch Kongkatong
 */
class VideoInfo extends WikiaModel {

	protected $videoTitle = 0;
	protected $addedAt = 0;
	protected $addedBy = 0;
	protected $premium = 0;
	protected $duration = 0;
	protected $hdfile = 0;
	protected $removed = 0;

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
	 * get video title
	 * @return string videoTitle
	 */
	public function getVideoTitle() {
		return $this->videoTitle;
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
	 * update data in the database
	 * @param array $updateValue [ array( field => value ) ]
	 * [ field = added_at, added_by, duration, premium ,hdfile, removed ]
	 */
	protected function updateDatabase( $updateValue ) {
		$this->wf->ProfileIn( __METHOD__ );

		if ( !$this->wf->ReadOnly() && !empty($this->videoTitle) ) {
			$db = $this->wf->GetDB( DB_MASTER );

			$db->update(
				'video_info',
				$updateValue,
				array( 'video_title' => $this->videoTitle ),
				__METHOD__
			);

			$db->commit();
		}

		$this->wf->ProfileOut( __METHOD__ );
	}

	/**
	 * add video to database
	 */
	protected function addToDatabase() {
		$this->wf->ProfileIn( __METHOD__ );

		if ( !$this->wf->ReadOnly() ) {
			$db = $this->wf->GetDB( DB_MASTER );

			if ( empty($this->addedAt) ) {
				$this->addedAt = $db->timestamp();
			}

			$db->insert(
				'video_info',
				array(
					'video_title' => $this->videoTitle,
					'added_at' => $this->addedAt,
					'added_by' => $this->addedBy,
					'duration' => $this->duration,
					'premium' => $this->premium,
					'hdfile' => $this->hdfile,
					'removed' => $this->removed,
				),
				__METHOD__,
				'IGNORE'
			);

			$affected = (bool) $db->affectedRows();

			$db->commit();
		}

		$this->wf->ProfileOut( __METHOD__ );

		return $affected;
	}

	/**
	 * remove video from database
	 */
	protected function removeFromDatabase() {
		$this->wf->ProfileIn( __METHOD__ );

		if ( !$this->wf->ReadOnly() ) {
			$db = $this->wf->GetDB( DB_MASTER );

			$db->delete(
				'video_info',
				array( 'video_title' => $this->videoTitle ),
				__METHOD__
			);

			$db->commit();
		}

		$this->wf->ProfileOut( __METHOD__ );
	}

	/**
	 * create video_info table if not exists
	 */
	public function createTableVideos() {
		$this->wf->ProfileIn( __METHOD__ );

		if ( !$this->wf->ReadOnly() ) {
			$db = $this->wf->GetDB( DB_MASTER );

			if ( !$db->tableExists( 'video_info' ) ) {
				$sql =<<<SQL
					CREATE TABLE IF NOT EXISTS `video_info` (
						`video_title` varchar(255) CHARACTER SET latin1 COLLATE latin1_bin NOT NULL DEFAULT '',
						`added_at` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
						`added_by` int(10) unsigned NOT NULL DEFAULT '0',
						`duration` int(10) unsigned NOT NULL DEFAULT '0',
						`premium` tinyint(1) NOT NULL DEFAULT '0',
						`hdfile` tinyint(1) NOT NULL DEFAULT '0',
						`removed` tinyint(1) NOT NULL DEFAULT '0',
						`views_30day` int(10) unsigned DEFAULT '0',
						`views_total` int(10) unsigned DEFAULT '0',
						PRIMARY KEY (`video_title`),
						KEY `added_at` (`added_at`, `duration`),
						KEY `premium` (`premium`, `added_at`),
						KEY `hdfile` (`hdfile`, `added_at`)
					) ENGINE=InnoDB DEFAULT CHARSET=latin1;
SQL;

				$db->query( $sql, __METHOD__ );
				$db->commit(__METHOD__);
			}
		}

		$this->wf->ProfileOut( __METHOD__ );
	}

	/**
	 * get video object from title
	 * @param string $videoTitle
	 * @return object $video
	 */
	public static function newFromTitle( $videoTitle ) {
		$app = F::App();

		$app->wf->ProfileIn( __METHOD__ );

		$db = $app->wf->GetDB( DB_SLAVE );

		$row = $db->selectRow(
			'video_info',
			'*',
			array( 'video_title' => $videoTitle ),
			__METHOD__
		);

		$video = null;
		if ( $row ) {
			$video = self::newFromRow( $row );
		}

		$app->wf->ProfileOut( __METHOD__ );

		return $video;
	}

	/**
	 * get video object from row
	 * @param object $row
	 * @return array video
	 */
	public static function newFromRow( $row ) {
		$data = array(
			'videoTitle' => $row->video_title,
			'addedAt' => $row->added_at,
			'addedBy' => $row->added_by,
			'duration' => $row->duration,
			'premium' => $row->premium,
			'hdfile' => $row->hdfile,
			'removed' => $row->removed,
		);

		$video = F::build( __CLASS__, array($data) );

		return $video;
	}


	public function addVideo() {
		return $this->addToDatabase();
	}

	public function addPremiumVideo( $userId ) {
		$this->addedAt = $this->wf->Timestamp( TS_MW );
		if ( !empty($userId) ) {
			$this->addedBy = $userId;
		}

		return $this->addToDatabase();
	}

	public function reuploadVideo() {
		$addedAt = $this->wf->Timestamp( TS_MW );
		$data = array(
			'added_at' => $addedAt,
			'added_by' => $this->addedBy,
			'duration' => $this->duration,
			'premium' => $this->premium,
			'hdfile' => $this->hdfile,
			'removed' => $this->removed,
		);

		$this->updateDatabase( $data );
	}

	public function renameVideo( $newVideoTitle ) {
		$data = array(
			'video_title' => $newVideoTitle,
		);

		$this->updateDatabase( $data );
	}

	public function restoreVideo() {
		$data = array(
			'removed' => 0,
		);

		$this->updateDatabase( $data );
	}

	public function removeVideo() {
		$data = array(
			'removed' => 1,
		);

		$this->updateDatabase( $data );
	}

	public function deleteVideo() {
		$this->removeFromDatabase();
	}

}
