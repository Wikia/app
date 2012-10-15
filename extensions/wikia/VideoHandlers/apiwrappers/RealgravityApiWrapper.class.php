<?php

class RealgravityApiWrapper extends IngestionApiWrapper {

	protected static $CACHE_KEY = 'realgravityapi';
	protected static $aspectRatio = 1.7777778;
	
	public function getDescription() {

		wfProfileIn( __METHOD__ );

		$description = $this->getOriginalDescription();
		if ($category = $this->getVideoCategory()) {
			$description .= "\n\nCategory: $category";
		}
		if ($keywords = $this->getVideoKeywords()) {
			$description .= "\n\nKeywords: $keywords";
		}

		wfProfileOut( __METHOD__ );

		return $description;
	}

	public function getThumbnailUrl() {
		if (!empty($this->metadata['thumbnail'])) {
			return $this->metadata['thumbnail'];
		}
		elseif (!empty($this->interfaceObj[1])) {
			return $this->interfaceObj[1];
		}
		return '';
	}

	protected function getOriginalDescription() {
		if (!empty($this->interfaceObj[3])) {
			return $this->interfaceObj[3];
		}
		return '';
	}

	protected function getVideoDuration() {
		if (!empty($this->interfaceObj[2])) {
			return $this->interfaceObj[2];
		}
		return '';
	}

	public function getAspectRatio() {
		$ratio = parent::getAspectRatio();
		if (!empty($this->interfaceObj[0])) {
			list($width, $height) = explode('x', $this->interfaceObj[0]);
		}
		if(!empty($width) && !(empty($height))) {
			$ratio = $width / $height;
		}
		return $ratio;
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

}