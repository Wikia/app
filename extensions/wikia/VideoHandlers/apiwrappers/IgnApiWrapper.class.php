<?php

class IgnApiWrapper extends IngestionApiWrapper {

	protected static $CACHE_KEY = 'ignapi';
	protected static $aspectRatio = 1.7777778;

	public function getDescription() {

		wfProfileIn( __METHOD__ );

		$description = $this->getOriginalDescription();

		wfProfileOut( __METHOD__ );

		return $description;
	}

	public function getThumbnailUrl() {
		if (!empty($this->metadata['thumbnail'])) {
			return $this->metadata['thumbnail'];
		}
		return '';
	}

	public function getAspectRatio() {
		return self::$aspectRatio;
	}

}