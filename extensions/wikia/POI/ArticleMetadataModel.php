<?php

class ArticleMetadataModel {

	const QUEST_ID = "quest_id";
	const FINGERPRINTS = "fingerprints";
	const ABILITY_ID = "ability_id";
	const MAP_REGION = "map_region";

	const ARTICLE_PROP_NAME = WPP_PALANTIR_METADATA;

	protected $articleId = 0;
	protected $articleTitle = null;
	protected $dbVersion = DB_SLAVE;

	protected $metadata = [
		self::QUEST_ID => "",
		self::MAP_REGION => "",
		self::ABILITY_ID => "",
		self::FINGERPRINTS => [],
	];

	protected $solr_mapping = [
		self::QUEST_ID => "metadata_quest_id_s",
		self::ABILITY_ID => "metadata_ability_id_s",
		self::FINGERPRINTS => "metadata_fingerprint_ids_ss",
		self::MAP_REGION => "metadata_map_region_s"
	];

	protected function extractTitle(){
		$this->articleTitle = Title::newFromID( $this->articleId );
		if ( is_null( $this->articleTitle ) ) {
			throw new TitleNotFoundException();
		}
	}

	public function __construct( $articleId, $useMaster = false ) {
		$this->articleId = (int) $articleId;
		$this->extractTitle();
		if ( $useMaster ) {
			$this->dbVersion = DB_MASTER;
		}
		$this->load();
	}

	/**
	 * @return array
	 */
	public function getSolrMapping() {
		return $this->solr_mapping;
	}

	/**
	 * Creates new object if article exists
	 * @param $title string
	 * @return ArticleMetadataModel|null
	 */
	public static function newFromString( $title ) {
		$titleObject = Title::newFromText( $title );
		if ( !$titleObject || !$titleObject->exists() ) {
			throw new TitleNotFoundException();
		}
		return new self( $titleObject->getArticleId() );
	}


	/**
	 * Load data from database - page_wikia_props
	 * from prop name defined in self::article_prop_name
	 */
	public function load() {
		$data = $this->getWikiaProp( self::ARTICLE_PROP_NAME, $this->articleId );
		foreach ( $this->metadata as $meta_key => $meta_val ) {
			if ( isset( $data[$meta_key] ) && !empty( $data[$meta_key] ) ) {
				$this->metadata[$meta_key] = $data[$meta_key];
			}
		}
	}

	protected function getWikiaProp($propName, $articleId) {
		return wfGetWikiaPageProp( $propName, $articleId, $this->dbVersion );
	}

	protected function setWikiaProp( $propName, $articleId, $value ) {
		wfSetWikiaPageProp( $propName, $articleId, $value );
	}

	/**
	 * Save the metadata to DB ( page_wikia_props )
	 * to prop name defined in self::article_prop_name
	 */
	public function save( $propagateScribeEvent = false ) {
		$this->setWikiaProp( self::ARTICLE_PROP_NAME, $this->articleId, $this->getMetadata() );
		if ( $propagateScribeEvent ) {
			$article = new Article( $this->articleTitle );
			ScribeEventProducerController::notifyPageHasChanged( $article->getPage() );
		}
	}

	/**
	 * Set metadata field - you need to manually call save() method in order to save it in the DB
	 * @param $fieldName
	 * @param $value
	 * @throws NotValidPOIMetadataFieldException
	 */
	public function setField( $fieldName, $value ) {
		if ( !isset($this->metadata[ $fieldName ] ) ) {
			throw new NotValidPOIMetadataFieldException( $fieldName );
		}

		if ( is_array( $this->metadata[ $fieldName ] ) && !is_array( $value ) ) {
			throw new FieldNotArrayException( $fieldName );
		} else {
			$this->metadata[ $fieldName ] = $value;
		}
	}

	public function addFingerprint( $name ) {
		if ( !in_array($this->metadata[ self::FINGERPRINTS ], $name) ) {
			$this->metadata[ self::FINGERPRINTS ][] = $name;
		}
	}

	public function removeFingerprint( $name ) {
		foreach ( $this->metadata[ self::FINGERPRINTS ] as $i => $fp ) {
			if ( $fp == $name ) {
				unset( $this->metadata[self::FINGERPRINTS][$i] );
			}
		}
	}

	public function clearAllFingerprints() {
		$this->metadata[ self::FINGERPRINTS ] = [];
	}

	/**
	 * Get single field from metadata
	 * @param $fieldName
	 * @return mixed
	 */
	public function getField( $fieldName ) {
		return $this->metadata[ $fieldName ];
	}

	/**
	 * Get whole metadata as array
	 * @return array
	 */
	public function getMetadata() {
		return $this->metadata;
	}

}

//exceptions
class NotValidPOIMetadataFieldException extends WikiaException { }
class FieldNotArrayException extends WikiaException { }
class TitleNotFoundException extends WikiaException { }