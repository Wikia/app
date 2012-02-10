<?php

class RealgravityApiWrapper extends WikiaVideoApiWrapper implements ParsedVideoData {

	protected static $PARSED_DATA_CACHE_KEY = 'realgravitydata';
	protected $parsedData;

	public function __construct($videoName, $params=array()) {
		$this->videoName = $videoName;
		if (!empty($params['videoId'])) {
			$this->videoId = $params['videoId'];
		}

		$memcKey = F::app()->wf->memcKey( static::$PARSED_DATA_CACHE_KEY, static::$CACHE_KEY_VERSION, $this->videoName );
		$data = F::app()->wg->memc->get( $memcKey );
		$cacheMe = false;
		if ( empty( $data ) ){
			if (!empty($params['parsedData'])) {
				$this->parsedData = $params['parsedData'];
				$cacheMe = true;
				$data = $this->generateCacheData();
			}
			else {
				$this->initializeInterfaceObject();			
			}
		}
		else {
			$this->loadDataFromCache($data);
		}
		
		if ( $cacheMe ) {
			F::app()->wg->memc->set( $memcKey, $data, static::$CACHE_EXPIRY );
		}
	}

	public function getParsedDataField($field) {
		if (isset($this->parsedData[$field])) {
			return $this->parsedData[$field];
		}
		return null;
	}
	
	public function generateCacheData() {
		$data = array('videoId'=>$this->videoId, 'parsedData'=>$this->parsedData);
		return $data;
	}
	
	public function loadDataFromCache($cacheData) {
		$this->videoId = $cacheData['videoId'];
		$this->parsedData = $cacheData['parsedData'];
	}
	
	protected function getVideoTitle() {
		return $this->videoName;
	}
	
	public function getDescription() {
		$description = $this->getOriginalDescription();
		if ($category = $this->getVideoCategory()) {
			$description .= "\n\nCategory: $category";
		}
		if ($keywords = $this->getVideoKeywords()) {
			$description .= "\n\nKeywords: $keywords";
		}
		
		return $description;
	}

	public function getThumbnailUrl() {
		if ($thumbnailUrl = $this->getParsedDataField('thumbnail')) {
			return $thumbnailUrl;
		}
		elseif (!empty($this->interfaceObj[1])) {
			return $this->interfaceObj[1];
		}
		return '';
	}

	protected function getOriginalDescription() {
		if ($description = $this->getParsedDataField('description')) {
			return $description;
		}
		elseif (!empty($this->interfaceObj[3])) {
			return $this->interfaceObj[3];
		}
		return '';
	}

	protected function getVideoDuration() {
		if ($duration = $this->getParsedDataField('duration')) {
			return $duration;
		}
		elseif (!empty($this->interfaceObj[2])) {
			return $this->interfaceObj[2];
		}
		return '';
	}

	protected function getAspectRatio() {
		$ratio = '';
		if ($aspectRatio = $this->getParsedDataField('aspectRatio')) {
			$ratio = $aspectRatio;
		}
		elseif (!empty($this->interfaceObj[0])) {
			$ratio = $this->interfaceObj[0];
		}
		if ($ratio) {
			list($width, $height) = explode('x', $ratio);
			$ratio = $width / $height;
		}
		return $ratio;
	}
	
	protected function getVideoPublished() {
		if ($published = $this->getParsedDataField('published')) {
			return strtotime($published);
		}
		
		return '';
	}
	
	protected function getVideoCategory() {
		if ($category = $this->getParsedDataField('category')) {
			return $category;
		}
		
		return '';
	}
	
	protected function getVideoKeywords() {
		if ($keywords = $this->getParsedDataField('keywords')) {
			return $keywords;
		}
		
		return '';
	}

}