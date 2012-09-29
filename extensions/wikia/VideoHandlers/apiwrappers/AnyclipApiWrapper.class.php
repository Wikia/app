<?php

class AnyclipApiWrapper extends IngestionApiWrapper {

	protected static $CACHE_KEY = 'anyclipapi';
	protected static $aspectRatio = 1.7777778;

	public function getDescription() {
		wfProfileIn( __METHOD__ );

		$description = $this->getOriginalDescription();
		if ( $category = $this->getVideoCategory() ) {
			$description .= "\n\nCategory: $category";
		}
		if ( $keywords = $this->getVideoKeywords() ) {
			$description .= "\n\nKeywords: $keywords";
		}
		if ( $tags = $this->getVideoTags() ) {
			$description .= "\n\nTags: $tags";
		}

		wfProfileOut( __METHOD__ );

		return $description;
	}

	public function getThumbnailUrl() {
		if ( !empty($this->metadata['thumbnail']) ) {
			return $this->metadata['thumbnail'];
		}

		return '';
	}

	protected function getOriginalDescription() {
		if ( !empty($this->metadata['description']) ) {
			return $this->metadata['description'];
		}

		return '';
	}

	protected function getVideoDuration() {
		if ( !empty($this->metadata['duration']) ) {
			return $this->metadata['duration'];
		}

		return '';
	}

	public function getAspectRatio() {
		return self::$aspectRatio;
	}

	protected function getVideoPublished() {
		if ( !empty($this->metadata['published']) ) {
			return $this->metadata['published'];
		}

		return '';
	}

	protected function getVideoCategory() {
		if ( !empty($this->metadata['category']) ) {
			return $this->metadata['category'];
		}

		return '';
	}

	protected function getVideoKeywords() {
		if ( !empty($this->metadata['keywords']) ) {
			return $this->metadata['keywords'];
		}

		return '';
	}

	protected function getVideoTags() {
		if ( !empty($this->metadata['tags']) ) {
			return $this->metadata['tags'];
		}

		return '';
	}

	protected function getLanguage() {
		if ( !empty($this->metadata['language']) ) {
			return $this->metadata['language'];
		}

		return '';
	}

	protected function isHdAvailable(){
		if ( !empty($this->metadata['hd']) ) {
			return (bool) $this->metadata['hd'];
		}

		return false;
	}

}