<?php

class VimeoApiWrapper extends ApiWrapper {

	protected static $API_URL = 'http://vimeo.com/api/v2/video/$1.json';
	protected static $CACHE_KEY = 'Vimeoapi';
	
	public function getTitle() {
		if (!empty($this->interfaceObj['title'])) {
			return $this->interfaceObj['title'];
		}
		return '';
	}
	
	public function getDescription() {
		$text = $this->getOriginalDescription();
		if ( $this->getVideoKeywords() ) $text .= "\n\nTags: {$this->getVideoKeywords()}";
		return $text;
	}
	
	public function getThumbnailUrl() {
		return $this->interfaceObj['thumbnail_large'];
	}

	public function getMetadata() {
		$metadata = array();
		
		$metadata['videoId'] = $this->videoId;
		$metadata['published'] = $this->getVideoPublished();
		$metadata['category'] = $this->getVideoCategory();
		$metadata['canEmbed'] = $this->canEmbed();
		$metadata['hd'] = $this->isHdAvailable();
		$metadata['keywords'] = $this->getVideoKeywords();
		$metadata['duration'] = $this->getVideoDuration();
		
		return $metadata;
	}

	/**
	 * Title
	 * @return string
	 */
	protected function postProcess( $return ){
		return $return[0];
	}

	/**
	 * User-defined description
	 * @return string
	 */
	protected function getOriginalDescription() {
		if (!empty($this->interfaceObj['description'])) {
			
			return $this->interfaceObj['description'];
		}

		return '';
	}

	/**
	 * User-defined keywords
	 * @return array
	 */
	protected function getVideoKeywords() {
		if (!empty($this->interfaceObj['tags'])) {
			return $this->interfaceObj['tags'];
		}
		return '';
	}

	/**
	 * Time that this feed entry was created, in UTC
	 * @return string
	 */
	protected function getVideoPublished() {
		if ( !empty( $this->interfaceObj['upload_date'] ) ) {

			return strtotime($this->interfaceObj['upload_date']);
		}

		return '';
	}

	/**
	 * Video duration, in seconds
	 * @return int
	 */
	protected function getVideoDuration() {
		if ( !empty( $this->interfaceObj['duration'] ) ) {

			return $this->interfaceObj['duration'];
		}
		return false;
	}

	/**
	 * Is resolution of 720 or higher available
	 * @return boolean 
	 */
	protected function isHdAvailable() {
		if (	!empty( $this->interfaceObj['width'] ) &&
			$this->interfaceObj['width'] >= 720 ) {

			return true;
		}
		return false;
	}

	/**
	 * Can video be embedded
	 * @return boolean
	 */
	protected function canEmbed() {
		if (	!empty( $this->interfaceObj['embed_privacy'] ) &&
			$this->interfaceObj['embed_privacy'] != 'anywhere' ) {

			return true;
		}		
		return true;
	}

	/*
	 * Handle response errors
	 */
	protected function checkForResponseErrors( $status, $content, $apiUrl ){

		if ( $content == ( $this->videoId.' not found.' ) ) {
			throw new VideoNotFoundException( $status, $content, $apiUrl );
		}

		// return default
		parent::checkForResponseErrors( $status, $content, $apiUrl );
	}
}