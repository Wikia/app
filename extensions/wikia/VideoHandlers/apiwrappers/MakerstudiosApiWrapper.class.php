<?php

class MakerstudiosApiWrapper extends IngestionApiWrapper {

	protected static $CACHE_KEY = 'makerstudiosapi';

	public function getDescription() {

		return $this->getOriginalDescription();
	}

	public function getThumbnailUrl() {
		if ( !empty( $this->metadata['thumbnail'] ) ) {
			return $this->metadata['thumbnail'];
		}
		return '';
	}
}
