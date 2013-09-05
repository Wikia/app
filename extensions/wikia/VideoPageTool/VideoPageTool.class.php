<?php

/**
 * VideoPageTool Class
 */
abstract class VideoPageTool extends WikiaModel {

	protected static $SECTION_ID = 1;
	protected static $REQUIRED_ROWS = 1;

	protected $section;
	protected $language;
	protected $publishDate;

	abstract public function getDefaultData();
	abstract public function validateForm( $formValues );
	abstract protected function getAssetData( $data );

	public function __construct( $language, $publishDate ) {
		parent::__construct();

		$this->section = STATIC::$SECTION_ID;
		$this->language = $language;
		$this->publishDate = $publishDate;
	}

	/**
	 * get class from section
	 * @param string $section [featured/trending/fan]
	 * @param string $language
	 * @param string $publishDate (timestamp)
	 * @return Class|null
	 */
	public static function newFromSection( $section, $language, $publishDate ) {
		if ( !empty( $section ) && !empty( $language ) && !empty( $publishDate ) ) {
			$class = __CLASS__.ucwords( $section );
			if ( class_exists( $class ) ) {
				return new $class( $language, $publishDate );
			}
		}

		return null;
	}

	/**
	 * get data
	 * @return array $data (default data or program assets)
	 */
	public function getData() {
		$program = $this->getProgram();
		if ( empty( $program ) ) {
			return $this->getDefaultData();
		}

		$assets = $this->getProgramAssets( $program['programId'] );
		if ( empty( $assets ) ) {
			return $this->getDefaultData();
		}

		$data = array();
		foreach( $assets as $asset ) {
			$user = User::newFromId( $asset['updatedBy'] );
			$data[$asset['order']] = $this->getAssetData( $asset['data'] );
			$data[$asset['order']]['updatedBy'] = $user->getName();
			$data[$asset['order']]['updatedAt'] = $asset['updatedAt'];
		}

		return $data;
	}

	/**
	 * Save data
	 * @param array $data
	 * @return boolean
	 */
	public function saveData( $data ) {
		wfProfileIn( __METHOD__ );

		if ( wfReadOnly() ) {
			wfProfileOut( __METHOD__ );
			return false;
		}

		$program = $this->getProgram();
		if ( empty( $program['programId'] ) ) {
			// add program
			$isPublish = 0;
			$programId = $this->addProgramToDatabase( $isPublish );
			if ( empty( $programId ) ) {
				wfProfileOut( __METHOD__ );
				return false;
			}
		} else {
			$programId = $program['programId'];
		}

		$updatedBy = $this->wg->User->getId();
		$updatedAt = time();

		$assets = $this->getProgramAssets( $programId );
		if ( empty( $assets ) ) {
			// add assets
			$result = $this->addProgramAssetsToDatabase( $programId, STATIC::$SECTION_ID, $data, $updatedBy, $updatedAt );
		} else {
			// update assets
			$result = $this->updateProgramAssetsToDatabase( $programId, STATIC::$SECTION_ID, $data, $updatedBy, $updatedAt );
		}

		wfProfileOut( __METHOD__ );

		return $result;
	}

	/**;
	 * Get program assets by section
	 * @param integer $programId
	 * @return type
	 */
	protected function getProgramAssets( $programId ) {
		wfProfileIn( __METHOD__ );

		$memKey = $this->getMemKeyProgramAssets( $programId );
		$assets = $this->wg->Memc->get( $memKey );
		if ( empty( $assets ) ) {
			$db = wfGetDB( DB_SLAVE );

			$result = $db->select(
				array( 'vpt_asset' ),
				array( '*' ),
				array(
					'program_id' => $programId,
					'section' => $this->section,
				),
				__METHOD__
			);

			$assets = array();
			while ( $row = $db->fetchObject( $result ) ) {
				$assets[] = array(
					'assetId' => $row->asset_id,
					'programId' => $row->program_id,
					'section' => $row->section,
					'order' => $row->order,
					'data' => json_decode( $row->data, true ),
					'updatedBy' => $row->updated_by,
					'updatedAt' => $row->updated_at,
				);
			}

			$this->wg->Memc->set( $memKey, $assets, 60*60*24 );
		}

		wfProfileOut( __METHOD__ );

		return $assets;
	}

	/**
	 * get memcache key for program assets per section
	 * @param integer $programId
	 * @return string
	 */
	protected function getMemKeyProgramAssets( $programId ) {
		return wfMemcKey( 'videopagetool', 'program_assets', $programId, $this->section );
	}

	/**
	 * clear cache for program assets per section
	 * @param integer $programId
	 */
	protected function clearCacheProgramAssets( $programId ) {
		$this->wg->Memc->delete( $this->getMemKeyProgramAssets( $programId, $this->section ) );
	}

	/**
	 * Add program assets to database per section
	 * @param integer $programId
	 * @param integer $section
	 * @param array $data
	 * @param integer $updatedBy
	 * @param string $updatedAt
	 * @return boolean
	 */
	protected function addProgramAssetsToDatabase( $programId, $section, $data, $updatedBy, $updatedAt ) {
		wfProfileIn( __METHOD__ );

		if ( wfReadOnly() ) {
			wfProfileOut( __METHOD__ );
			return false;
		}

		$db = wfGetDB( DB_MASTER );

		$values = array();
		foreach ( $data as $key => $asset ) {
			$values[] = array(
				'program_id' => $programId,
				'section' => $section,
				'`order`' => ( $key + 1 ),
				'data' => json_encode( $asset ),
				'updated_by' => $updatedBy,
				'updated_at' => $db->timestamp( $updatedAt ),
			);
		}

		$result = $db->insert(
			'vpt_asset',
			$values,
			__METHOD__,
			'IGNORE'
		);

		$db->commit();

		wfProfileOut( __METHOD__ );

		return $result;
	}

	/**
	 * Update program assets to database
	 * @param integer $programId
	 * @param integer $section
	 * @param array $data
	 * @param integer $updatedBy
	 * @param string $updatedAt
	 * @return boolean
	 */
	protected function updateProgramAssetsToDatabase( $programId, $section, $data, $updatedBy, $updatedAt ) {
		wfProfileIn( __METHOD__ );

		if ( wfReadOnly() ) {
			wfProfileOut( __METHOD__ );
			return false;
		}

		$db = wfGetDB( DB_MASTER );

		$orders = array();
		$sqlSet = 'SET data = CASE `order` ';
		foreach ( $data as $key => $asset ) {
			$orders[$key] = $key + 1;
			$sqlSet .= "WHEN $orders[$key] THEN ".$db->addQuotes( json_encode( $asset ) )." ";
		}
		$sqlSet .= "END";
		$sqlSet .= ", updated_by = $updatedBy, updated_at = '".$db->timestamp( $updatedAt )."'";

		$sql = "UPDATE vpt_asset $sqlSet WHERE program_id = $programId and section = $section and `order` in (".implode( ',', $orders ).")";

		$result = (bool) $db->query( $sql, __METHOD__ );

		$db->commit();

		// clear cache
		if ( $result ) {
			$this->clearCacheProgramAssets( $programId, $section );
		}

		wfProfileOut( __METHOD__ );

		return $result;
	}

	/**
	 * Add asset to database
	 * @param integer $programId
	 * @param integer $section
	 * @param integer $order
	 * @param array $data
	 * @param integer $updatedBy
	 * @param string $updatedAt
	 * @return integer|false $result - return asset id if the asset is inserted
	 */
	protected function addAssetToDatabase( $programId, $section, $order, $data, $updatedBy, $updatedAt ) {
		wfProfileIn( __METHOD__ );

		$result = false;

		if ( wfReadOnly() ) {
			wfProfileOut( __METHOD__ );
			return $result;
		}

		$db = wfGetDB( DB_MASTER );

		$assetId = $db->nextSequenceValue( 'video_vpt_asset_seq' );

		$db->insert(
			'vpt_asset',
			array(
				'asset_id' => $assetId,
				'program_id' => $programId,
				'section' => $section,
				'order' => $order,
				'data' => json_encode( $data ),
				'updated_by' => $updatedBy,
				'updated_at' => $db->timestamp( $updatedAt ),
			),
			__METHOD__,
			'IGNORE'
		);

		if ( $db->affectedRows() > 0 ) {
			$result = $db->insertId();
		}

		$db->commit();

		wfProfileOut( __METHOD__ );

		return $result;
	}

	/**
	 * Update asset to database
	 * @param integer $programId
	 * @param integer $section
	 * @param integer $order
	 * @param array $data
	 * @param integer $updatedBy
	 * @param string $updatedAt
	 * @return boolean $affected
	 */
	protected function updateAssetToDatabase( $programId, $section, $order, $data, $updatedBy, $updatedAt ) {
		wfProfileIn( __METHOD__ );

		if ( wfReadOnly() ) {
			wfProfileOut( __METHOD__ );
			return false;
		}

		$db = wfGetDB( DB_MASTER );

		$db->update(
			'vpt_asset',
			array(
				'data' => json_encode( $data ),
				'updated_by' => $updatedBy,
				'updated_at' => $db->timestamp( $updatedAt ),
			),
			array(
				'program_id' => $programId,
				'section' => $section,
				'order' => $order,
			),
			__METHOD__
		);

		$affected = ( $db->affectedRows() > 0 );

		$db->commit();

		wfProfileOut( __METHOD__ );

		return $affected;
	}

	/**
	 * get program
	 * @param integer $isPublish
	 * @return array|null $program
	 */
	protected function getProgram() {
		wfProfileIn( __METHOD__ );

		$memKey = $this->getMemKeyProgram();
		$program = $this->wg->Memc->get( $memKey );
		if ( empty( $program ) ) {
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
					'language' => $this->language,
					'publish_date' => date( 'Y-m-d', $this->publishDate ),
				),
				__METHOD__
			);

			$program = null;
			if ( $row ) {
				$program = array(
					'programId' => $row->program_id,
					'language' => $row->language,
					'publishDate' => $row->publish_date,
					'isPublished' => $row->is_published,

				);
			}

			$this->wg->Memc->set( $memKey, $program, 60*60*24 );
		}

		wfProfileOut( __METHOD__ );

		return $program;
	}

	/**
	 * get memcache key for program
	 * @return string
	 */
	protected function getMemKeyProgram() {
		return wfMemcKey( 'videopagetool', 'program', $this->language, $this->publishDate );
	}

	/**
	 * clear cache for program
	 */
	protected function clearCacheProgram() {
		$this->wg->Memc->delete( $this->getMemKeyProgram() );
	}

	/**
	 * Add program to database
	 * @param integer $isPublish
	 * @return integer|false $result - return program id if the program is inserted
	 */
	protected function addProgramToDatabase( $isPublish ) {
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
				'is_published' => $isPublish,
			),
			__METHOD__,
			'IGNORE'
		);

		if ( $db->affectedRows() > 0 ) {
			$result = $db->insertId();
		}

		$db->commit();

		wfProfileOut( __METHOD__ );

		return $result;
	}

	/**
	 * Update program to database
	 * @param integer $isPublish
	 * @return boolean $affected
	 */
	protected function updateProgramToDatabase( $isPublish ) {
		wfProfileIn( __METHOD__ );

		if ( wfReadOnly() ) {
			wfProfileOut( __METHOD__ );
			return false;
		}

		$db = wfGetDB( DB_MASTER );

		$db->update(
			'vpt_program',
			array(
				'is_published' => $isPublish,
			),
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
			$this->clearCacheProgram();
		}

		wfProfileOut( __METHOD__ );

		return $affected;
	}

	/**
	 * Publish program
	 * @return boolean $affected
	 */
	public function publishProgram() {
		$isPublish = 1;
		$affected = $this->updateProgramToDatabase( $isPublish );

		return $affected;
	}

}
