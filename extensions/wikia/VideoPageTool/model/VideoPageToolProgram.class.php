<?php

/**
 * VideoPageToolProgram Class
 */
class VideoPageToolProgram extends WikiaModel {

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

	public function __construct( $data = array() ) {
		parent::__construct();

		foreach ( $data as $key => $value ) {
			$this->$key = $value;
		}
	}

	/**
	 * get program id
	 * @return integer
	 */
	public function getProgramId() {
		return $this->programId;
	}

	/**
	 * get language
	 * @return string
	 */
	public function getLanguage() {
		return $this->language;
	}

	/**
	 * get publish date
	 * @return string [timestamp]
	 */
	public function getPublishDate() {
		return $this->publishDate;
	}

	/**
	 * get formatted publish date
	 * @return string
	 */
	public function getFormattedPublishDate() {
		return $this->wg->lang->timeanddate( $this->publishDate, true );
	}

	/**
	 * check if program is published
	 * @return boolean
	 */
	public function isPublished() {
		return (bool) $this->isPublished;
	}

	/**
	 * check if program exists
	 * @return boolean
	 */
	public function exists() {
		return !empty( $this->getProgramId() );
	}

	/**
	 * set program id
	 * @param integer $value
	 */
	protected function setProgramId( $value ) {
		$this->programId = $value;
	}

	/**
	 * set language
	 * @param string $value
	 */
	protected function setLanguage( $value ) {
		$this->language = $value;
	}

	/**
	 * set public date
	 * @param string $value [timestamp]
	 */
	protected function setPublishDate( $value ) {
		$this->publishDate = $value;
	}

	/**
	 * set isPublished
	 * @param boolean $isPublished
	 */
	protected function setIsPublished( $value ) {
		$this->isPublished = (int) $value;
	}

	/**
	 * get program object from language and publish date
	 * @param string $language
	 * @param integer $publishDate
	 * @return object|null $program
	 */
	public static function newProgram( $language, $publishDate ) {
		wfProfileIn( __METHOD__ );

		$app = F::App();

		$memKey = self::getMemcKey( $language, $publishDate );
		$programData = $app->wg->Memc->get( $memKey );
		if ( is_array( $programData ) ) {
			$program = new self( $programData );
		} else {
			$db = wfGetDB( DB_SLAVE );

			$row = $db->selectRow(
				array( 'vpt_program' ),
				array(
					'program_id',
					'language',
					'unix_timestamp(publish_date) as publish_date',
					'is_published',
				),
				array(
					'language' => $language,
					'publish_date' => date( 'Y-m-d', $publishDate ),
				),
				__METHOD__
			);

			$program = null;
			if ( $row ) {
				$program = self::newFromRow( $row );
				$program->saveToCache();
			}
		}

		wfProfileOut( __METHOD__ );

		return $program;
	}

	/**
	 * get program object from row
	 * @param object $row
	 * @return array $program
	 */
	protected static function newFromRow( $row ) {
		$data = array();
		foreach ( static::$fields as $fieldName => $varName ) {
			$data[$varName] = $row->$fieldName;
		}

		$class = get_class();
		$program = new $class( $data );

		return $program;
	}

	/**
	 * Add to database
	 * @return integer|false $result - return program id if the program is inserted
	 */
	protected function addToDatabase() {
		wfProfileIn( __METHOD__ );

		$result = false;

		if ( wfReadOnly() ) {
			wfProfileOut( __METHOD__ );
			return $result;
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

		if ( $db->affectedRows() > 0 ) {
			$this->setProgramId( $db->insertId() );
			$this->saveToCache();
			$result = true;
		}

		$db->commit();

		wfProfileOut( __METHOD__ );

		return $result;
	}

	/**
	 * Update program to database
	 * @return boolean $affected
	 */
	protected function updateProgramToDatabase() {
		wfProfileIn( __METHOD__ );

		if ( wfReadOnly() ) {
			wfProfileOut( __METHOD__ );
			return false;
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

		$affected = ( $db->affectedRows() > 0 );

		$db->commit();

		// clear cache
		if ( $affected ) {
			$this->invalidateCache();
		}

		wfProfileOut( __METHOD__ );

		return $affected;
	}

	/**
	 * get memcache key
	 * @param string $language
	 * @param string $publishDate [timestamp]
	 * @return string
	 */
	protected static function getMemcKey( $language, $publishDate ) {
		return wfMemcKey( 'videopagetool', 'program', $language, $publishDate );
	}

	/**
	 * save to cache
	 */
	protected function saveToCache() {
		$cache = array();
		foreach ( static::$fields as $varName ) {
			$cache[$varName] = $this->$varName;
		}

		$this->wg->Memc->set( self::getMemcKey( $this->language, $this->publishDate ), $cache, 60*60*24*7 );
	}

	/**
	 * clear cache
	 */
	protected function invalidateCache() {
		$this->wg->Memc->delete( self::getMemcKey( $this->language, $this->publishDate ) );
	}

	/**
	 * add program
	 * @return boolean
	 */
	public function addProgram() {
		return $this->addToDatabase();
	}

	/**
	 * Publish program
	 * @return boolean
	 */
	public function publishProgram() {
		$this->setIsPublished( true );

		return $this->updateProgramToDatabase();
	}

	/**
	 * Unpublish program
	 * @return boolean
	 */
	public function unpublishProgram() {
		$this->setIsPublished( false );

		return $this->updateProgramToDatabase();
	}

	/**
	 * Get assets by section
	 * @param string $section
	 * @return array $assets
	 */
	public function getAssetsBySection( $section ) {
		$assets = VideoPageToolAsset::getAssetsBySection( $this->programId, $section );
		return $assets;
	}

}
