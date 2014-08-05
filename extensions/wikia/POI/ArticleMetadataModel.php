<?php

class ArticleMetadataModel {

	const QUEST_ID = "quest_id";
	const FINGERPRINTS = "fingerprints";
	const ABILITY_ID = "ability_id";
	const MAP_REGION = "map_region";

	const article_prop_name = WPP_PALANTIR_METADATA;

	protected $articleId = 0;
	protected $articleTitle = null;

	protected $metadata = [
		self::QUEST_ID => "",
		self::MAP_REGION => "",
		self::ABILITY_ID => "",
		self::FINGERPRINTS => [],
	];

	public function __construct( $articleId ) {
		$this->articleId = (int) $articleId;
		$this->articleTitle = Title::newFromID( $this->articleId );
		if ( is_null( $this->articleTitle ) ) {
			throw new TitleNotFoundException();
		}
		$this->load();
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
		$data = $this->getWikiaProp( self::article_prop_name, $this->articleId );
		foreach ( $this->metadata as $meta_key => $meta_val ) {
			if ( isset( $data[$meta_key] ) && !empty( $data[$meta_key] ) ) {
				$this->metadata[$meta_key] = $data[$meta_key];
			}
		}
	}

	protected function getWikiaProp($propName, $articleId) {
		return wfGetWikiaPageProp( $propName, $articleId );
	}

	protected function setWikiaProp( $propName, $articleId, $value ) {
		wfSetWikiaPageProp( $propName, $articleId, $value );
	}

	/**
	 * Save the metadata to DB ( page_wikia_props )
	 * to prop name defined in self::article_prop_name
	 */
	public function save( $propagateScribeEvent = false ) {
		$this->setWikiaProp( self::article_prop_name, $this->articleId, $this->getMetadata() );
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