<?php

/**
 * VideoPageToolProgram Class
 *
 * Cache key functions used:
 *
 *  - getMemcKey() : Key for caching this program object
 *  - getMemcKeyNearestDate() : Key for caching program with date nearest to the date passed
 *  - getMemcKeyCompletedSections() : Key for caching the distinct list of section numbers for a program
 *  - getMemcKeyPrograms() : Key for caching a list of program IDs for a language for a specific month
 *
 * All caches can be cleared via function:
 *
 *   invalidateCache()
 *
 */
class VideoPageToolProgram extends WikiaModel {

	const OBJECT_CACHE_TTL = 604800; // One week
	const DATE_CACHE_TTL = 86400;    // One day
	const CACHE_VERSION = 1;

	protected $programId = 0;
	protected $language = 'en';
	protected $publishDate;
	protected $isPublished = 0;
	protected $publishedBy;
	protected $dbw = null;

	protected static $fields = array(
		'program_id'   => 'programId',
		'language'     => 'language',
		'publish_date' => 'publishDate',
		'is_published' => 'isPublished',
		'published_by' => 'publishedBy',
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
	 * Get published by
	 * @return integer [userId]
	 */
	public function getPublishedBy() {
		return $this->publishedBy;
	}

	/**
	 * Get formatted publish date
	 * @return string
	 */
	public function getFormattedPublishDate() {
		return $this->wg->lang->date( $this->publishDate );
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
	 * Set published by
	 * @param integer $value [userId]
	 */
	protected function setPublishedBy( $value ) {
		$this->publishedBy = $value;
	}

	/**
	 * Set isPublished
	 * @param $value
	 */
	protected function setIsPublished( $value ) {
		$this->isPublished = (int) $value;
	}

	/**
	 * Given a language, finds the program object nearest (or equal to) to the date (default = today's date)
	 * @param string $lang
	 * @param string $date [timestamp]
	 * @return VideoPageToolProgram|null $program
	 */
	public static function loadProgramNearestDate( $lang, $date = '' ) {
		wfProfileIn( __METHOD__ );

		// Figure out what the nearest date to today is
		$nearestDate = self::getNearestDate( $lang, $date );
		if ( $nearestDate ) {
			// Load the program with this nearest date
			$program = self::newProgram( $lang, $nearestDate );

			wfProfileOut( __METHOD__ );
			return $program;
		} else {
			return null;
		}
	}

	/**
	 * Returns the nearest program date to the date for a given language (default = today's date)
	 *
	 * This function will only cache the nearest date if the starting point ($timestamp) is not given and
	 * defaults to today.  This is the only way to reliably clear this cache (otherwise we would have clear
	 * cache for every date in the future in case a request cached something there.  Since the user facing
	 * side always assumes the default date, this case will be cached and will be performant
	 *
	 * @param string $language
	 * @param string $timestamp
	 * @return string
	 */
	protected static function getNearestDate( $language, $timestamp = '' ) {
		wfProfileIn( __METHOD__ );

		$app = F::app();

		if ( $timestamp ) {
			// If there was a specific timestamp given, look it up directly, don't cache it
			$date = date( 'Y-m-d', $timestamp );
			$nearestDate = '';
			// For the edit page (time stamp given), we want to look for nearest date
			// not including today.
			$publishDateOperator = '<';
		} else {
			// If no timestamp was given, assume today and use a cache
			$date = date( 'Y-m-d', time() );
			$nearestKey = self::getMemcKeyNearestDate( $language );
			$nearestDate = $app->wg->Memc->get( $nearestKey );
			$publishDateOperator = '<=';
		}

		if ( empty($nearestDate) ) {
			$db = wfGetDB( DB_SLAVE );

			$sql_conditions = array(
				'language' => $language,
				"publish_date $publishDateOperator ".$db->addQuotes( $date ),
			);

			// If there's a timestamp, the request is coming from the VPT
			// admin and we want to get the nearest published or non-published
			// program. If there is no timestamp, it's coming from the Video
			// Home Page and we only want the nearest published program.
			if ( !$timestamp ) {
				$sql_conditions["is_published"] = 1;
			}

			$row = $db->selectRow(
				array( 'vpt_program' ),
				array( 'unix_timestamp(publish_date) as publish_date' ),
				$sql_conditions,
				__METHOD__,
				array( 'ORDER BY' => 'publish_date DESC' )
			);

			if ( $row ) {
				$nearestDate = $row->publish_date;

				// Cache this for at most one day.  Don't cache if we were given a specific
				// timestamp
				if ( isset($nearestKey) ) {
					$app->wg->Memc->set( $nearestKey, $nearestDate, self::DATE_CACHE_TTL );
				}
			}
		}

		wfProfileOut( __METHOD__ );

		return $nearestDate;
	}

	/**
	 * Get the memcached key for storing the nearest published date
	 * @param string $lang - Look for published content dates in this language
	 * @return string - A string to use as the memcached string
	 */
	protected static function getMemcKeyNearestDate( $lang ) {
		return wfMemcKey( 'videopagetool', 'nearest-date', $lang, date( 'Y-m-d' ) );
	}

	/**
	 * Invalidate the cache holding the program with a date nearest to today.
	 *
	 * @param $lang
	 */
	protected function invalidateNearestDate( $lang ) {
		$this->wg->Memc->delete( self::getMemcKeyNearestDate( $lang ) );
	}

	/**
	 * Get program object from language and publish date
	 * @param string $language
	 * @param integer $publishDate
	 * @return VideoPageToolProgram
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
				$program->invalidateCache();
				$program->saveToCache();
			}
		}

		wfProfileOut( __METHOD__ );

		return $program;
	}

 	/**
	 * Get program object from a row from table
	 * @param ResultWrapper $row
	 * @return VideoPageToolProgram
	 */
	public static function newFromRow( $row ) {
		$program = new self();
		$program->loadFromRow( $row );
		return $program;
	}

	public static function newFromId( $id ) {
		wfProfileIn( __METHOD__ );
		$program  = new self();

		$db = wfGetDB( DB_SLAVE );

		$row = ( new WikiaSQL() )
			->SELECT( '*' )
				->FIELD( 'unix_timestamp(publish_date)' )->AS_( 'publish_date' )
			->FROM( 'vpt_program' )
			->WHERE( 'program_id' )->EQUAL_TO( $id )
			->run( $db, function( $result ) {
				/** @var ResultWrapper $result */
				return $result->fetchObject();
			});

		if ( $row ) {
			$program->loadFromRow( $row );
		}

		wfProfileOut( __METHOD__ );
		return $program;
	}

	/**
	 * Load data from database
	 * @return boolean
	 */
	protected function loadFromDatabase() {
		wfProfileIn( __METHOD__ );

		$db = wfGetDB( DB_SLAVE );

		$row = ( new WikiaSQL() )
			->SELECT( '*' )
				->FIELD( 'unix_timestamp(publish_date)' )->AS_( 'publish_date' )
			->FROM( 'vpt_program' )
			->WHERE( 'language' )->EQUAL_TO( $this->language )
			->AND_( 'publish_date' )->EQUAL_TO( date( 'Y-m-d', $this->publishDate ) )
			->run( $db, function( $result ) {
				/** @var ResultWrapper $result */
				return $result->fetchObject();
			});

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
	 * @param ResultWrapper $row
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
			// This is a quick check to make sure $published_by (which is a
			// new column added to the vpt_program table) is in the cache.
			// This helps the transition as the cache is filled with new
			// data which will from here on out include this field.
			// This should be removed a few days following the release on 1/22/14.
			if ( array_key_exists( $varName, $cache ) ) {
				$this->$varName = $cache[$varName];
			} else {
				$this->$varName = null;
			}
		}
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

		$db = $this->getMasterDB();

		$db->insert(
			'vpt_program',
			array(
				'language'     => $this->language,
				'publish_date' => date( 'Y-m-d', $this->publishDate ),
				'is_published' => $this->isPublished,
			),
			__METHOD__,
			'IGNORE'
		);

		$affected = $db->affectedRows();
		if ( $affected > 0 ) {
			$this->setProgramId( $db->insertId() );
		} else {
			// If this already exists in the DB, load the row so we have the program ID
			$this->loadFromDatabase();
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

		// Make sure we've got a publishedBy value here
		if ( empty( $this->getPublishedBy ) ) {
			$this->setPublishedBy( $this->wg->User->getId() );
		}

		$db = $this->getMasterDB();

		( new WikiaSQL() )
			->UPDATE( 'vpt_program' )
				->SET( 'is_published', $this->isPublished )
				->SET( 'published_by', $this->publishedBy )
			->WHERE( 'program_id' )->EQUAL_TO( $this->programId )
			->run( $db );

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
	 * Clear all program caches
	 */
	public function invalidateCache() {
		$this->invalidateCacheCompletedSections();
		$this->invalidateCachePrograms( $this->language );
		$this->invalidateNearestDate( $this->language );
		$this->wg->Memc->delete( $this->getMemcKey() );
	}

	/**
	 * Publish program
	 * @return Status
	 */
	public function publishProgram() {
		$this->setIsPublished( true );
		$this->setPublishedBy( $this->wg->User->getId() );

		$db = $this->getMasterDB();
		$status = $this->save();
		$db->commit();

		if ( $status->isGood() && $status->value > 0 ) {
			$this->invalidateCache();
		}

		return $status;
	}

	/**
	 * Unpublish program
	 * @return Status
	 */
	public function unpublishProgram() {
		$this->setIsPublished( false );

		$db = $this->getMasterDB();
		$status = $this->save();
		$db->commit();

		if ( $status->isGood() && $status->value > 0 ) {
			$this->invalidateCache();
		}

		return $status;
	}

	/**
	 * Get the list of programs for the month starting at $startDate
	 * @param string $language
	 * @param string $startDate [yyyy-mm-dd]
	 * @return array [array( date => status ); date = yyyy-mm-dd; status = 0 (not published)/ 1 (published)]
	 */
	public static function getProgramsForMonth( $language, $startDate ) {
		wfProfileIn( __METHOD__ );

		$app = F::app();

		$memKey = self::getMemcKeyPrograms( $language, $startDate );
		$programs = $app->wg->Memc->get( $memKey );
		if ( empty( $programs ) ) {
			$db = wfGetDB( DB_SLAVE );

			$result = $db->select(
				array( 'vpt_program' ),
				array( "date_format( publish_date, '%Y-%m-%d' ) publish_date, is_published" ),
				array(
					'language' => $language,
					"publish_date >= '$startDate'",
					"publish_date < '$startDate' + INTERVAL 1 MONTH",
				),
				__METHOD__,
				array( 'ORDER BY' => 'publish_date' )
			);

			$programs = array();
			while ( $row = $db->fetchObject( $result ) ) {
				$programs[$row->publish_date] = $row->is_published;
			}

			$app->wg->Memc->set( $memKey, $programs, 60*60*24 );
		}

		wfProfileOut( __METHOD__ );

		return $programs;
	}

	/**
	 * Get memcache key for programs
	 * @param string $language
	 * @param string $startDate [yyyy-mm-dd]
	 * @return string
	 */
	protected static function getMemcKeyPrograms( $language, $startDate ) {
		return wfMemcKey( 'videopagetool', 'programs', $language, $startDate );
	}

	/**
	 * Clear cache for programs
	 * @param string $language
	 * @param string [yyyy-mm-dd]
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
	 * @return array
	 */
	public function getAssetsBySection( $section ) {
		$assets = array();
		if ( $this->exists() ) {
			$assets = VideoPageToolAsset::getAssetsBySection( $this->programId, $section );
		}
		return $assets;
	}

	/**
	 * Get all assets associated with this program
	 * @return array
	 */
	public function getAssets() {
		$assets = [];
		if ( $this->exists() ) {
			$assets = VideoPageToolAsset::getAssets( $this->programId );
		}
		return $assets;
	}

	/**
	 * Save assets by section
	 * @param string $section
	 * @param array $assets
	 * @return Status
	 */
	public function saveAssetsBySection( $section, $assets ) {
		wfProfileIn( __METHOD__ );

		if ( empty( $this->language ) || empty( $this->publishDate ) ) {
			wfProfileOut( __METHOD__ );
			return Status::newFatal( wfMessage( 'videopagetool-error-missing-parameter' )->plain() );
		}

		$db = $this->getMasterDB();

		$db->begin();

		$status = Status::newGood();

		// save program
		$this->save();

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
			if ( empty( $asset ) ) {
				$status = $assetObj->delete();
			} else {
				$assetObj->setData( $asset );
				$assetObj->setUpdatedAt( $time );
				$assetObj->setUpdatedBy( $userId );

				$status = $assetObj->save();
			}

			if ( !$status->isGood() ) {
				$db->rollback();
				wfProfileOut( __METHOD__ );
				return $status;
			}

			if ( !empty( $asset ) ) {
				$assetList[$order] = $assetObj;
			}
		}

		$db->commit();

		// save cache
		$this->invalidateCache();
		$this->saveToCache();

		foreach ( $assetList as $assetObj ) {
			/** @var VideoPageToolAsset $assetObj */
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
	 * @return array
	 */
	public function formatFormData( $section, $requiredRows, $formValues, &$errMsg ) {
		$className = VideoPageToolAsset::getClassNameFromSection( $section );
		$data = $className::formatFormData( $requiredRows, $formValues, $errMsg );

		return $data;
	}

	/**
	 * Check if the program is ready to be published
	 * @param array $sections - required sections
	 * @return boolean
	 */
	public function isPublishable( $sections ) {
		sort( $sections );
		return ( $sections == $this->getCompletedSections( $sections ) );
	}

	/**
	 * Get list of completed sections
	 * @param array $sections - required sections
	 * @return array - completed sections
	 */
	public function getCompletedSections( $sections ) {
		wfProfileIn( __METHOD__ );

		$memcKey = $this->getMemcKeyCompletedSections();
		$list = $this->wg->Memc->get( $memcKey );
		if ( !is_array( $list ) ) {
			$db = wfGetDB( DB_SLAVE );

			$result = $db->select(
				array( 'vpt_asset' ),
				array( 'distinct section' ),
				array(
					'vpt_asset.program_id' => $this->programId,
					'vpt_asset.section' => $sections,
				),
				__METHOD__,
				array( 'ORDER BY' => 'section' )
			);

			$list = array();
			while ( $row = $db->fetchObject( $result ) ) {
				$list[] = $row->section;
			}

			$this->wg->Memc->set( $memcKey, $list, 60*60*24 );
		}

		wfProfileOut( __METHOD__ );

		return $list;
	}

	/**
	 * Get memcache key for completed sections
	 * @return string
	 */
	protected function getMemcKeyCompletedSections() {
		return wfMemcKey( 'videopagetool', 'completed_sections', self::CACHE_VERSION, $this->programId );
	}

	/**
	 * Clear cache for completed sections
	 */
	protected function invalidateCacheCompletedSections() {
		$this->wg->Memc->delete( $this->getMemcKeyCompletedSections() );
	}

	public function save() {
		wfProfileIn( __METHOD__ );

		// save program
		if ( $this->exists() ) {
			$status = $this->updateToDatabase();
		} else {
			$status = $this->addToDatabase();
		}

		
		wfProfileOut( __METHOD__ );
		return $status;
	}

	/**
	 * Removes the current program from the database
	 * @param boolean $cascade Whether or not to cascade this delete to also delete dependent assets
	 */
	public function delete( $cascade = false ) {
		wfProfileIn( __METHOD__ );

		if ( $this->exists() ) {
			// Delete all dependent assets if we get the $cascade option
			if ( $cascade ) {
				$assets = $this->getAssets();
				foreach ( $assets as $asset ) {
					/** @var VideoPageToolAsset $asset */
					$asset->delete();
				}
			}

			$this->deleteFromDatabase();
			$this->invalidateCache();
		}

		wfProfileOut( __METHOD__ );
	}

	/**
	 * A simple wrapper around wfGetDB that caches the connection to local master db. Needed mostly for the ease of
	 * unit testing mocking (as the delete method is called outside the test, in tearDown method)
	 * @return master database connection
	 */
	protected function getMasterDB() {
		if ( empty( $this->dbw ) ) {
			$this->dbw = wfGetDB( DB_MASTER );
		}
		return $this->dbw;
	}

	protected function deleteFromDatabase() {

		( new WikiaSQL() )
			->DELETE( 'vpt_program' )
			->WHERE( 'program_id' )->EQUAL_TO( $this->programId )
			->run( $this->getMasterDB() );
	}
}
