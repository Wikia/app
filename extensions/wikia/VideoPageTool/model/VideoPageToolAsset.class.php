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

	public function __construct( $data = array() ) {
		parent::__construct();

		foreach ( $data as $key => $value ) {
			$this->$key = $value;
		}
	}

	/**
	 * get asset id
	 * @return integer
	 */
	public function getAssetId() {
		return $this->assetId;
	}

	/**
	 * get program id
	 * @return integer
	 */
	public function getProgramId() {
		return $this->programId;
	}

	/**
	 * get section
	 * @return string
	 */
	public function getSection() {
		return $this->section;
	}

	/**
	 * get order
	 * @return integer
	 */
	public function getOrder() {
		return $this->order;
	}

	/**
	 * get data
	 * @return string
	 */
	public function getData() {
		return $this->data;
	}

	/**
	 * get updated by [userId]
	 * @return integer
	 */
	public function getUpdatedBy(){
		return $this->updatedBy;
	}

	/**
	 * get updated at [timestamp]
	 * @return string
	 */
	public function getUpdatedAt(){
		return $this->updatedAt;
	}

	/**
	 * get formatted updated at
	 * @return string
	 */
	public function getFormattedUpdatedAt() {
		return $this->wg->lang->timeanddate( $this->updatedAt, true );
	}

	public static function newFromSection( $section ) {
		$className = get_class().ucfirst( $section );

		return new $className();
	}

	protected static function newFromRow( $row ) {
		$className = get_class().ucfirst( $row->section );
		$asset = new $className();

		foreach ( static::$fields as $fieldName => $varName ) {
			$asset->$varName = $row->$fieldName;
		}
		$asset->unserializeData( $asset->data );

		return $asset;
	}

	/**
	 * update to the database
	 * @return boolean $affected
	 */
	protected function updateToDatabase() {
		wfProfileIn( __METHOD__ );

		$affected = false;
		if ( !wfReadOnly() ) {
			$db = wfGetDB( DB_MASTER );

			$data = $this->serializeData();

			$db->update(
				'vpt_asset',
				array(
					'program_id' => $this->programId,
					'section' => $this->section,
					'order' => $this->order,
					'data' => $data,
					'updated_by' => $this->updatedBy,
					'updated_at' => $this->udpatedAt,
				),
				array(
					'program_id' => $this->programId,
					'section' => $this->section,
					'order' => $this->order,
				),
				__METHOD__
			);

			$affected = ( $db->affectedRows() > 0 );

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

			if ( empty($this->updatedAt) ) {
				$this->updatedAt = $db->timestamp();
			}

			$data = $this->serializeData();

			$db->insert(
				'vpt_asset',
				array(
					'program_id' => $this->programId,
					'section' => $this->section,
					'order' => $this->order,
					'data' => $data,
					'updated_by' => $this->updatedBy,
					'updated_at' => $this->udpatedAt,
				),
				__METHOD__,
				'IGNORE'
			);

			$affected = ( $db->affectedRows() > 0 );

			$db->commit();

			if ( $affected ) {
				$this->saveToCache();
			}
		}

		wfProfileOut( __METHOD__ );

		return $affected;
	}

	public function save() {
		wfProfileIn( __METHOD__ );

		if ( empty( $this->programId ) || empty( $this->section ) || empty( $this->order ) ) {
			wfProfileOut( __METHOD__ );
			return false;
		}

		if ( $this->exists ) {
			$result = $this->updateToDatabase();
		} else {
			$result = $this->addToDatabase();
		}

		if ( $result ) {
			$this->saveToCache();
			$this->invalidateCacheAssetsBySection( $this->programId, $this->section );
		}

		wfProfileOut( __METHOD__ );

		return $result;
	}

	/**
	 * serialize data
	 * @return array
	 */
	protected function serializeData() {
		$data = array();
		foreach ( STATIC::$dataFields as $field ) {
			$data[$field] = $this->$field;
		}
		return serialize( $data );
	}

	/**
	 * Unserialize data
	 * @param type $serializedData
	 */
	protected function unserializeData( $serializedData ) {
		$data = json_decode( $serializedData, true );
		foreach ( STATIC::$dataFields as $field ) {
			if ( property_exists( $this, $field ) ) {
				$this->$field = $data[$field];
			}
		}
	}

	/**
	 * get memcache key
	 * @param integer $assetId
	 * @return string
	 */
	protected static function getMemcKey( $assetId ) {
		return wfMemcKey( 'videopagetool', 'asset', $assetId );
	}

	/**
	 * save to cache
	 */
	protected function saveToCache() {
		foreach ( self::$fields as $varName ) {
			$cache[$varName] = $this->$varName;
		}

		$this->wg->Memc->set( self::getMemcKey( $this->assetId ), $cache, 60*60*24*7 );
	}

	/**
	 * clear cache
	 */
	protected function invalidateCache() {
		$this->wg->Memc->delete( self::getMemcKey( $this->assetId ) );
	}

	/**
	 * get program object
	 * @return VideoPageToolProgram
	 */
	public function getProgram() {
		$program = VideoPageToolProgram::newFromId( $this->programId );

		return $program;
	}

	/**
	 * Get assets by section
	 * @param integer $programId
	 * @param integer $sectionId
	 * @return type
	 */
	public static function getAssetsBySection( $programId, $sectionId ) {
		wfProfileIn( __METHOD__ );

		$app = F::App();

		$memKey = self::getMemcKeyAssetsBySection( $programId, $sectionId );
		$data = $app->wg->Memc->get( $memKey );
		if ( !is_array( $data ) ) {
			$db = wfGetDB( DB_SLAVE );

			$result = $db->select(
				array( 'vpt_asset' ),
				array( '*' ),
				array(
					'program_id' => $programId,
					'section' => $sectionId,
				),
				__METHOD__
			);

			$data = array();
			while ( $row = $db->fetchObject( $result ) ) {
				$data[] = $row;
			}

			$app->wg->Memc->set( $memKey, $data, 60*60*24 );
		}

		$assets = array();
		foreach( $data as $row ) {
			$assets[] = self::newFromRow( $row );
		}

		wfProfileOut( __METHOD__ );

		return $assets;
	}

	/**
	 * get memcache key for assets by section
	 * @param integer $programId
	 * @return string
	 */
	protected static function getMemcKeyAssetsBySection( $programId, $section ) {
		return wfMemcKey( 'videopagetool', 'assets', $programId, $section );
	}

	/**
	 * clear cache for assets by section
	 * @param integer $programId
	 */
	protected function invalidateCacheAssetsBySection( $programId, $section ) {
		$this->wg->Memc->delete( self::getMemcKeyAssetsBySection( $programId, $section ) );
	}

	/**
	 * get asset data (used in template)
	 * @return array $assetData
	 */
	public function getAssetData() {
		$user = User::newFromId( $this->updatedBy );
		$assetData['updatedBy'] = $user->getName();
		$assetData['updatedAt'] = $this->getFormattedUpdatedAt();

		return $assetData;
	}

	/**
	 * get default asset data (used in template)
	 * @return array $assetData
	 */
	public static function getDefaultAssetData() {
		$app = F::app();
		$assetData['updatedBy'] = $app->wg->user->getName();
		$assetData['updatedAt'] = $app->wg->lang->timeanddate( wfTimestamp(), true );

		return $assetData;
	}

}
