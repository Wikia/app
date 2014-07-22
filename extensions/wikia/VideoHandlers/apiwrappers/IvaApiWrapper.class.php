<?php

class IvaApiWrapper extends IngestionApiWrapper {

	protected static $CACHE_KEY = 'ivaapi';
	protected static $aspectRatio = 1.7777778;

	public function getDescription() {
		$description = $this->getOriginalDescription();

		return $description;
	}

	public function getThumbnailUrl() {
		if ( !empty($this->metadata['thumbnail']) ) {
			return $this->metadata['thumbnail'];
		}

		return '';
	}

	public function getAspectRatio() {
		return self::$aspectRatio;
	}

}