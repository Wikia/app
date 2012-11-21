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

	protected function getOriginalDescription() {
		if (!empty($this->metadata['description'])) {
			return $this->metadata['description'];
		}
		return '';
	}

	protected function getVideoDuration() {
		if (!empty($this->metadata['duration'])) {
			return $this->metadata['duration'];
		}
		return '';
	}

	public function getAspectRatio() {
		return self::$aspectRatio;
	}

	protected function getVideoPublished() {
		if (!empty($this->metadata['published'])) {
			return $this->metadata['published'];
		}

		return '';
	}

	protected function getVideoCategory() {
		if (!empty($this->metadata['category'])) {
			return $this->metadata['category'];
		}

		return '';
	}

	protected function getVideoKeywords() {
		if (!empty($this->metadata['keywords'])) {
			return $this->metadata['keywords'];
		}

		return '';
	}

	protected function getVideoTags() {
		if (!empty($this->metadata['tags'])) {
			return $this->metadata['tags'];
		}

		return '';
	}

}