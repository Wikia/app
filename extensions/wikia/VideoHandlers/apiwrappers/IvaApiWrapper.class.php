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

	protected function isAgeGate() {
		if ( !empty( $this->metadata['ageGate'] ) ) {
			return true;
		}

		return false;
	}

	protected function getAgeRequired() {
		if ( !empty( $this->metadata['ageRequired'] ) ) {
			return $this->metadata['ageRequired'];
		}

		return 0;
	}

	protected function getGenres() {
		if ( !empty($this->metadata['genres']) ) {
			return $this->metadata['genres'];
		}

		return '';
	}

	protected function getActors() {
		if ( !empty($this->metadata['actors']) ) {
			return $this->metadata['actors'];
		}

		return '';
	}

}