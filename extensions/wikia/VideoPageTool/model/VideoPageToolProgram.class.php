<?php

/**
 * VideoPageToolProgram Class
 */
class VideoPageToolProgram extends WikiaModel {

	const OBJECT_CACHE_TTL = 604800; // One week
	const DATE_CACHE_TTL = 86400;    // One day

	protected $programId = 0;
	protected $language = 'en';
	protected $publishDate;
	protected $isPublished = 0;

	protected static $fields = array(
		'program_id'   => 'programId',
		'language'     => 'language',
		'publish_date' => 'publishDate',
		'is_published' => 'isPublished',
	);

	/**
	 * Get program id
	 * @return integer
	 */
	public function getProgramId() {
		return $this->programId;
	}

	/**
	 * Get language
	 * @return string
	 */
	public function getLanguage() {
		return $this->language;
	}

	/**
	 * Get publish date
	 * @return string [timestamp]
	 */
	public function getPublishDate() {
		return $this->publishDate;
	}

	/**
	 * Get formatted publish date
	 * @return string
	 */
	public function getFormattedPublishDate() {
		return $this->wg->lang->timeanddate( $this->publishDate, true );
	}

	/**
	 * Check if program is published
	 * @return boolean
	 */
	public function isPublished() {
		return (bool) $this->isPublished;
	}

	/**
	 * Check if program exists
	 * @return boolean
	 */
	public function exists() {
		return ( $this->getProgramId() > 0 );
	}

	/**
	 * Set program id
	 * @param integer $value
	 */
	protected function setProgramId( $value ) {
		$this->programId = $value;
	}

	/**
	 * Set language
	 * @param string $value
	 */
	protected function setLanguage( $value ) {
		$this->language = $value;
	}

	/**
	 * Set public date
	 * @param string $value [timestamp]
	 */
	protected function setPublishDate( $value ) {
		$this->publishDate = $value;
	}

	/**
	 * Set isPublished
	 * @param $value
	 */
	protected function setIsPublished( $value ) {
		$this->isPublished = (int) $value;
	}

	/**
	 * Given a language, finds the program object nearest (or equal to) to today's date
	 * @param $lang
	 * @return object
	 */
	public static function newProgramNearestToday( $lang ) {
		wfProfileIn( __METHOD__ );

		// Figure out what the nearest date to today is
		$nearestDate = self::getNearestDate( $lang );
		if ($nearestDate) {
			// Load the program with this nearest date
			$program = self::newProgram( $lang, $nearestDate );

			wfProfileOut( __METHOD__ );
			return $program;
		} else {
			return null;
		}
	}

	/**
	 * Get program object from language and publish date
	 * @param string $language
	 * @param integer $publishDate
	 * @return object $program
	 */
	public static function newProgram( $language, $publishDate ) {
		wfProfileIn( __METHOD__ );

		$program = new self();
		$program->setLanguage( $language );
		$program->setPublishDate( $publishDate );

		$memKey = $program->getMemcKey();
		$data = $program->wg->Memc->get( $memKey );
		if ( is_array( $data ) ) {
			$program->loadFromCache( $data );
		} else {
			$result = $program->loadFromDatabase();
			if ( $result ) {
				$program->saveToCache();
			}
		}

		wfProfileOut( __METHOD__ );

		return $program;
	}

 	/**
	 * Get program object from a row from table
	 * @param array $row
	 * @return array $program
	 */
	public static function newFromRow( $row ) {
		$program = new self();
		$program->loadFromRow( $row );
		return $program;
	}

	/**
	 * Load data from database
	 */
	protected function loadFromDatabase() {
		wfProfileIn( __METHOD__ );

		$db = wfGetDB( DB_SLAVE );

		$row = $db->selectRow(
			array( 'vpt_program' ),
			array( '*, unix_timestamp(publish_date) as publish_date' ),
			array(
				'language' => $this->language,
				'publish_date' => date( 'Y-m-d', $this->publishDate ),
			),
			__METHOD__
		);

		if ( $row ) {
			$this->loadFromRow( $row );
			wfProfileOut( __METHOD__ );
			return true;
		}

		wfProfileOut( __METHOD__ );

		return false;
	}

	/**
	 * Load data from a row from the table
	 * @param array $row
	 */
	protected function loadFromRow( $row ) {
		foreach ( static::$fields as $fieldName => $varName ) {
			$this->$varName = $row->$fieldName;
		}
	}

	/**
	 * Load data from cache
	 * @param array $cache
	 */
	protected function loadFromCache( $cache ) {
		foreach ( static::$fields as $varName ) {
			$this->$varName = $cache[$varName];
		}
	}

	/**
	 * Returns the nearest program date to today for a given language
	 * @param $language
	 * @return null|string
	 */
	protected function getNearestDate( $language ) {
		wfProfileIn( __METHOD__ );

		$date = date('Y-m-d');
		$nearestKey = wfMemcKey( 'videopagetool', 'nearest-date', $language, $date );
		$nearestDate = F::app()->wg->Memc->get( $nearestKey );

		if ( !$nearestDate ) {
			$db = wfGetDB( DB_SLAVE );

			$row = $db->selectRow(
				array( 'vpt_program' ),
				array( 'unix_timestamp(publish_date) as publish_date' ),
				array(
					'language' => $language,
					'publish_date <= '.$db->addQuotes(date( 'Y-m-d' )),
				),
				__METHOD__,
				array( 'ORDER BY' => 'publish_date DESC' )
			);

			if ( $row ) {
				$nearestDate = $row->publish_date;

				// Cache this for at most one day
				F::app()->wg->Memc->set( $nearestKey, $nearestDate, self::DATE_CACHE_TTL );
			}
		}

		wfProfileOut( __METHOD__ );

		return $nearestDate;
	}

	/**
	 * Add program to database
	 * @return Status
	 */
	protected function addToDatabase() {
		wfProfileIn( __METHOD__ );

		if ( wfReadOnly() ) {
			wfProfileOut( __METHOD__ );
			return Status::newFatal( wfMessage( 'videos-error-readonly' )->plain() );
		}

		$db = wfGetDB( DB_MASTER );

		$programId = $db->nextSequenceValue( 'video_vpt_program_seq' );

		$db->insert(
			'vpt_program',
			array(
				'program_id' => $programId,
				'language' => $this->language,
				'publish_date' => $db->timestamp( $this->publishDate ),
				'is_published' => $this->isPublish,
			),
			__METHOD__,
			'IGNORE'
		);

		$affected = $db->affectedRows();
		if ( $affected > 0 ) {
			$this->setProgramId( $db->insertId() );
		}

		wfProfileOut( __METHOD__ );

		return Status::newGood( $affected );
	}

	/**
	 * Update program to database
	 * @return Status
	 */
	protected function updateToDatabase() {
		wfProfileIn( __METHOD__ );

		if ( wfReadOnly() ) {
			wfProfileOut( __METHOD__ );
			return Status::newFatal( wfMessage( 'videos-error-readonly' )->plain() );
		}

		$db = wfGetDB( DB_MASTER );

		$db->update(
			'vpt_program',
			array( 'is_published' => $this->isPublished ),
			array(
				'language' => $this->language,
				'publish_date' => $db->timestamp( $this->publishDate ),
			),
			__METHOD__
		);

		$affected = $db->affectedRows();

		wfProfileOut( __METHOD__ );

		return Status::newGood( $affected );
	}

	/**
	 * Get memcache key
	 * @return string
	 */
	protected function getMemcKey() {
		return wfMemcKey( 'videopagetool', 'program', $this->language, $this->publishDate );
	}

	/**
	 * Save to cache
	 */
	protected function saveToCache() {
		$cache = array();
		foreach ( static::$fields as $varName ) {
			$cache[$varName] = $this->$varName;
		}

		$this->wg->Memc->set( $this->getMemcKey(), $cache, self::OBJECT_CACHE_TTL );
	}

	/**
	 * Clear cache
	 */
	protected function invalidateCache() {
		$this->wg->Memc->delete( $this->getMemcKey() );
	}

	/**
	 * Publish program
	 * @return boolean
	 */
	public function publishProgram() {
		$this->setIsPublished( true );

		return $this->updateToDatabase();
	}

	/**
	 * Unpublish program
	 * @return boolean
	 */
	public function unpublishProgram() {
		$this->setIsPublished( false );

		return $this->updateToDatabase();
	}

	/**
	 * get list of programs
	 * @param string $language
	 * @param string $startDate [yyyy-mm-dd]
	 * @param string $endDate [yyyy-mm-dd]
	 * @return array $programs [array( date => status ); date = yyyy-mm-dd; status = 0 (not published)/ 1 (published)]
	 */
	public static function getPrograms( $language, $startDate, $endDate ) {
		wfProfileIn( __METHOD__ );

		$app = F::app();

		$memKey = self::getMemcKeyPrograms( $language, $startDate );
		$programs = $app->wg->Memc->get( $memKey );
		if ( empty( $programs )) {
			$db = wfGetDB( DB_SLAVE );

			$result = $db->select(
				array( 'vpt_program' ),
				array( "date_format( publish_date, '%Y-%m-%d' ) publish_date, is_published" ),
				array(
					'language' => $language,
					"publish_date >= '$startDate'",
					"publish_date < '$endDate'",
				),
				__METHOD__,
				array( 'ORDER BY' => 'publish_date' )
			);

			$programs = array();
			while ( $row = $db->fetchObject($result) ) {
				$programs[$row->publish_date] = $row->is_published;
			}

			$app->wg->Memc->set( $memKey, $programs, 60*60*24 );
		}

		wfProfileOut( __METHOD__ );

		return $programs;
	}

	/**
	 * get memcache key for programs
	 * @param string $language
	 * @param string $startDate [yyyy-mm-dd]
	 * @return string
	 */
	public static function getMemcKeyPrograms( $language, $startDate ) {
		return wfMemcKey( 'videopagetool', 'programs', $language, $startDate );
	}

	/**
	 * clear cache for programs
	 * @param string $language
	 * @param string $startDate [yyyy-mm-dd]
	 */
	protected function invalidateCachePrograms( $language, $startDate = '' ) {
		if ( empty( $startDate ) ) {
			$startDate = date( 'Y-m-d', strtotime( 'first day of this month', $this->publishDate ) );
		}

		$this->wg->Memc->delete( self::getMemcKeyPrograms( $language, $startDate ) );
	}

	/**
	 * Get assets by section
	 * @param string $section
	 * @return array $assets
	 */
	public function getAssetsBySection( $section ) {
		$assets = array();
		if ( $this->exists() ) {
			$assets = VideoPageToolAsset::getAssetsBySection( $this->programId, $section );
		}
		return $assets;
	}

	/**
	 * Save assets by section
	 * @param string $section
	 * @param array $assets
	 * @param boolean $setPublish
	 * @return Status
	 */
	public function saveAssetsBySection( $section, $assets, $setPublish = false ) {
		wfProfileIn( __METHOD__ );

		if ( empty( $this->language ) || empty( $this->publishDate ) ) {
			wfProfileOut( __METHOD__ );
			return Status::newFatal( wfMessage( 'videopagetool-error-missing-parameter' )->plain() );
		}

		$db = wfGetDB( DB_MASTER );

		$db->begin();

		$status = Status::newGood();

		// save program
		if ( !$this->exists() ) {
			$status = $this->addToDatabase();
		} else if ( $setPublish ) {
			$status = $this->updateToDatabase();
		}

		if ( !$status->isGood() ) {
			$db->rollback();
			wfProfileOut( __METHOD__ );
			return $status;
		}

		// save assets
		$time = time();
		$userId = $this->wg->User->getId();
		$assetList = array();
		foreach ( $assets as $order => $asset ) {
			$assetObj = VideoPageToolAsset::newAsset( $this->programId, $section, $order );
			$assetObj->setData( $asset );
			$assetObj->setUpdatedAt( $time );
			$assetObj->setUpdatedBy( $userId );

			$status = $assetObj->save();
			if ( !$status->isGood() ) {
				$db->rollback();
				wfProfileOut( __METHOD__ );
				return $status;
			}

			$assetList[$order] = $assetObj;
		}

		$db->commit();

		// save cache
		$this->saveToCache();
		$this->invalidateCachePrograms( $section );

		foreach ( $assetList as $assetObj ) {
			$assetObj->saveToCache();
		}

		wfProfileOut( __METHOD__ );

		return $status;
	}

	/**
	 * Format form data
	 * @param string $section
	 * @param integer $requiredRows
	 * @param array $formValues
	 * @param string $errMsg
	 * @return array $data
	 */
	public function formatFormData( $section, $requiredRows, $formValues, &$errMsg ) {
		$className = VideoPageToolAsset::getClassNameFromSection( $section );
		$data = $className::formatFormData( $requiredRows, $formValues, $errMsg );

		return $data;
	}

}
