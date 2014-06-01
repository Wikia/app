<?php

/**
 * VideoPageToolAsset Class
 */
class VideoPageToolAsset extends WikiaModel {

	protected $assetId;
	protected $programId;
	protected $section;
	protected $order;
	protected $data;
	protected $updatedBy;
	protected $updatedAt;

	protected static $dataFields;
	protected static $fields = array(
		'asset_id'   => 'assetId',
		'program_id' => 'programId',
		'section'    => 'section',
		'order'      => 'order',
		'data'       => 'data',
		'updated_by' => 'updatedBy',
		'updated_at' => 'updatedAt',
	);

	/**
	 * Get asset id
	 * @return integer
	 */
	public function getAssetId() {
		return $this->assetId;
	}

	/**
	 * Get program id
	 * @return integer
	 */
	public function getProgramId() {
		return $this->programId;
	}

	/**
	 * Get section
	 * @return string
	 */
	public function getSection() {
		return $this->section;
	}

	/**
	 * Get order
	 * @return integer
	 */
	public function getOrder() {
		return $this->order;
	}

	/**
	 * Get data
	 * @return string
	 */
	public function getData() {
		return $this->data;
	}

	/**
	 * Get updated by
	 * @return integer [userId]
	 */
	public function getUpdatedBy(){
		return $this->updatedBy;
	}

	/**
	 * Get updated at
	 * @return string [timestamp]
	 */
	public function getUpdatedAt(){
		return $this->updatedAt;
	}

	/**
	 * Get formatted updated at
	 * @return string
	 */
	public function getFormattedUpdatedAt() {
		return $this->wg->lang->timeanddate( $this->updatedAt, true );
	}

	/**
	 * Check if asset exists
	 * @return boolean
	 */
	public function exists() {
		return ( $this->getAssetId() > 0 );
	}

	/**
	 * Set asset id
	 * @param type $value
	 */
	protected function setAssetId( $value ) {
		$this->assetId = $value;
	}

	/**
	 * Set program id
	 * @param integer $value
	 */
	protected function setProgramId( $value ) {
		$this->programId = $value;
	}

	/**
	 * Set section
	 * @param string $value
	 */
	protected function setSection( $value ) {
		$this->section = $value;
	}

	/**
	 * Set order
	 * @param integer $value
	 */
	protected function setOrder( $value ) {
		$this->order = $value;
	}

	/**
	 * Set data
	 * @param array $value
	 */
	public function setData( $value ) {
		foreach ( STATIC::$dataFields as $field ) {
			if ( property_exists( $this, $field ) && array_key_exists( $field, $value ) ) {
				$this->$field = $value[$field];
			}
		}
	}

	/**
	 * set updated at
	 * @param string $value [timestamp]
	 */
	public function setUpdatedAt( $value ) {
		$this->updatedAt = $value;
	}

	/**
	 * set updated by
	 * @param integer $value [userId]
	 */
	public function setUpdatedBy( $value ) {
		$this->updatedBy = $value;
	}

	/**
	 * Get class name from section
	 * @param string $section
	 * @return string $className
	 */
	public static function getClassNameFromSection( $section ) {
		$className = get_class().ucfirst( $section );

		return $className;
	}

	/**
	 * Get asset object from program id, section and order
	 * @param integer $programId
	 * @param string $section
	 * @param integer $order
	 * @return Object|null $asset
	 */
	public static function newAsset( $programId, $section, $order ) {
		wfProfileIn( __METHOD__ );

		$className = self::getClassNameFromSection( $section );
		$asset = new $className( $programId, $section, $order );

		if ( empty( $programId ) || empty( $section ) || empty( $order ) ) {
			wfProfileOut( __METHOD__ );
			return null;
		}

		$asset->setProgramId( $programId );
		$asset->setSection( $section );
		$asset->setOrder( $order );

		$memKey = $asset->getMemcKey();
		$data = $asset->wg->Memc->get( $memKey );
		if ( is_array( $data ) ) {
			$asset->loadFromCache( $data );
		} else {
			$result = $asset->loadFromDatabase();
			if ( $result ) {
				$asset->saveToCache();
			}
		}

		wfProfileOut( __METHOD__ );

		return $asset;
	}

	/**
	 * Get asset object from a row from table
	 * @param array $row
	 * @return object $asset
	 */
	public static function newFromRow( $row ) {
		$className = self::getClassNameFromSection( $row->section );
		$asset = new $className();
		$asset->loadFromRow( $row );

		return $asset;
	}

	/**
	 * Load data from database
	 * @return boolean
	 */
	protected function loadFromDatabase() {
		wfProfileIn( __METHOD__ );

		$db = wfGetDB( DB_SLAVE );

		$row = $db->selectRow(
			array( 'vpt_asset' ),
			array( '*, unix_timestamp(updated_at) as updated_at' ),
			array(
				'program_id' => $this->programId,
				'section' => $this->section,
				'`order`' => $this->order,
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
		$this->setSerializedData( $this->data );
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
	 * Update asset to the database
	 * @return Status
	 */
	protected function updateToDatabase() {
		wfProfileIn( __METHOD__ );

		if ( wfReadOnly() ) {
			wfProfileOut( __METHOD__ );
			return Status::newFatal( wfMessage( 'videos-error-readonly' )->plain() );
		}

		$db = wfGetDB( DB_MASTER );

		$data = $this->serializeData();

		$db->update(
			'vpt_asset',
			array(
				'data' => $data,
				'updated_by' => $this->updatedBy,
				'updated_at' => $db->timestamp( $this->updatedAt ),
			),
			array(
				'program_id' => $this->programId,
				'section' => $this->section,
				'`order`' => $this->order,
			),
			__METHOD__
		);

		$affected = $db->affectedRows();

		wfProfileOut( __METHOD__ );

		return Status::newGood( $affected );
	}

	/**
	 * Add asset to database
	 * @return Status
	 */
	protected function addToDatabase() {
		wfProfileIn( __METHOD__ );

		if ( wfReadOnly() ) {
			wfProfileOut( __METHOD__ );
			return Status::newFatal( wfMessage( 'videos-error-readonly' )->plain() );
		}

		$db = wfGetDB( DB_MASTER );

		$assetId = $db->nextSequenceValue( 'video_vpt_asset_seq' );

		if ( empty( $this->updatedAt ) ) {
			$this->updatedAt = $db->timestamp();
		}

		$data = $this->serializeData();

		$db->insert(
			'vpt_asset',
			array(
				'asset_id' => $assetId,
				'program_id' => $this->programId,
				'section' => $this->section,
				'`order`' => $this->order,
				'data' => $data,
				'updated_by' => $this->updatedBy,
				'updated_at' => $db->timestamp( $this->udpatedAt ),
			),
			__METHOD__,
			'IGNORE'
		);

		$affected = $db->affectedRows();
		if ( $affected > 0 ) {
			$this->setAssetId( $db->insertId() );
		}

		wfProfileOut( __METHOD__ );

		return Status::newGood( $affected );
	}

	/**
	 * Save asset
	 * @return Status
	 */
	public function save() {
		wfProfileIn( __METHOD__ );

		$status = $this->saveToDatabase();
		if ( $status->isGood() ) {
			$this->saveToCache();
		}

		wfProfileOut( __METHOD__ );

		return $status;
	}

	/**
	 * Save asset to database
	 * @return Status
	 */
	public function saveToDatabase() {
		wfProfileIn( __METHOD__ );

		if ( empty( $this->programId ) || empty( $this->section ) || empty( $this->order ) ) {
			wfProfileOut( __METHOD__ );
			return Status::newFatal( wfMessage( 'videopagetool-error-missing-parameter' )->plain() );
		}

		if ( $this->exists() ) {
			$status = $this->updateToDatabase();
		} else {
			$status = $this->addToDatabase();
			if ( $status->isGood() && $status->value == 0 ) {
				$status = $this->updateToDatabase();
			}
		}

		if ( $status->isGood() ) {
			$this->invalidateCache();
			$this->invalidateCacheAssetsBySection( $this->programId, $this->section );
		}

		wfProfileOut( __METHOD__ );

		return $status;
	}

	/**
	 * Serialize data
	 * @return array
	 */
	protected function serializeData() {
		$data = array();
		foreach ( STATIC::$dataFields as $field ) {
			$data[$field] = $this->$field;
		}

		return json_encode( $data );
	}

	/**
	 * Unserialize and set to data
	 * @param type $serializedData
	 */
	protected function setSerializedData( $serializedData ) {
		$data = json_decode( $serializedData, true );
		$this->setData( $data );
	}

	/**
	 * Get memcache key
	 * @return string
	 */
	protected function getMemcKey() {
		return wfMemcKey( 'videopagetool', 'asset', $this->programId, $this->section, $this->order );
	}

	/**
	 * Save to cache
	 */
	public function saveToCache() {
		foreach ( self::$fields as $varName ) {
			$cache[$varName] = $this->$varName;
		}

		$this->wg->Memc->set( $this->getMemcKey(), $cache, 60*60*24*7 );
	}

	/**
	 * Clear cache
	 */
	protected function invalidateCache() {
		$this->wg->Memc->delete( $this->getMemcKey() );
	}

	/**
	 * Get program object
	 * @return VideoPageToolProgram
	 */
	public function getProgram() {
		$program = VideoPageToolProgram::newFromId( $this->programId );

		return $program;
	}

	/**
	 * Get assets by section
	 * @param integer $programId
	 * @param string $section
	 * @return array An array of VideoPageToolAsset objects
	 */
	public static function getAssetsBySection( $programId, $section ) {
		wfProfileIn( __METHOD__ );

		$app = F::App();

		$memKey = self::getMemcKeyAssetsBySection( $programId, $section );
		$data = $app->wg->Memc->get( $memKey );
		if ( !is_array( $data ) ) {
			$db = wfGetDB( DB_SLAVE );

			$result = $db->select(
				array( 'vpt_asset' ),
				array( '*, unix_timestamp(updated_at) as updated_at' ),
				array(
					'program_id' => $programId,
					'section' => $section,
				),
				__METHOD__,
				array( 'ORDER BY' => '`order`' )
			);

			$data = array();
			while ( $row = $db->fetchObject( $result ) ) {
				$data[] = $row;
			}

			$app->wg->Memc->set( $memKey, $data, 60*60*24 );
		}

		$assets = array();
		foreach ( $data as $row ) {
			$assets[$row->order] = self::newFromRow( $row );
		}

		wfProfileOut( __METHOD__ );

		return $assets;
	}

	/**
	 * Get memcache key for assets by section
	 * @param integer $programId
	 * @param string $section
	 * @return string
	 */
	protected static function getMemcKeyAssetsBySection( $programId, $section ) {
		return wfMemcKey( 'videopagetool', 'assets', $programId, $section );
	}

	/**
	 * Clear cache for assets by section
	 * @param integer $programId
	 * @param string $section
	 */
	protected function invalidateCacheAssetsBySection( $programId, $section ) {
		$this->wg->Memc->delete( self::getMemcKeyAssetsBySection( $programId, $section ) );
	}

	/**
	 * Get asset data (used in template)
	 * @param array $thumbOptions
	 * @return array $assetData
	 */
	public function getAssetData( $thumbOptions = array() ) {
		$user = User::newFromId( $this->updatedBy );
		$assetData['updatedBy'] = $user->getName();
		$assetData['updatedAt'] = $this->getFormattedUpdatedAt();

		return $assetData;
	}

	/**
	 * Get default asset data (used in template)
	 * @return array $assetData
	 */
	public static function getDefaultAssetData() {
		$app = F::app();
		$assetData['updatedBy'] = $app->wg->user->getName();
		$assetData['updatedAt'] = $app->wg->lang->timeanddate( wfTimestamp(), true );

		return $assetData;
	}

	/**
	 * Format form data
	 * @param integer $requiredRows
	 * @param array $formValues
	 * @param string $errMsg
	 * @return array $data
	 */
	public static function formatFormData( $requiredRows, $formValues, &$errMsg ) {
		$data = array();
		for ( $i = 0; $i < $requiredRows; $i++ ) {
			foreach ( STATIC::$dataFields as $formFieldName => $varName ) {
				// validate form
				$helper = new VideoPageToolHelper();
				$helper->validateFormField( $formFieldName, $formValues[$formFieldName][$i], $errMsg );

				// format data
				$order = $i + 1;	// because input data start from 0
				$data[$order][$varName] = $formValues[$formFieldName][$i];
			}
		}

		return $data;
	}

}
