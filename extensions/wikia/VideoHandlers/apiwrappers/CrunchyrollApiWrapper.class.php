<?php

class CrunchyrollApiWrapper extends IngestionApiWrapper {

	protected static $CACHE_KEY = 'crunchyrollapi';
	protected static $CACHE_KEY_VERSION = 0.2;
	protected static $aspectRatio = 1.7777778;

	/**
	 * @inheritdoc
	 */
	public function getDescription() {
		wfProfileIn( __METHOD__ );

		$description = $this->getOriginalDescription();

		wfProfileOut( __METHOD__ );

		return $description;
	}

	/**
	 * @inheritdoc
	 */
	public function getThumbnailUrl() {
		if ( !empty( $this->metadata['thumbnail'] ) ) {
			return $this->metadata['thumbnail'];
		}

		return '';
	}

	/**
	 * @inheritdoc
	 */
	protected function loadMetadata( array $overrideFields = [] ) {
		parent::loadMetadata( $overrideFields );

		if ( !isset( $this->metadata['videoUrl'] ) ) {
			$this->metadata['videoUrl'] = $this->getVideoUrl();
		}
	}

	protected function getVideoUrl() {
		if ( !empty( $this->metadata['videoUrl'] ) ) {
			return $this->metadata['videoUrl'];
		}

		return '';
	}

}