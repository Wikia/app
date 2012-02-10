<?php

class MovieclipsApiWrapper extends ApiWrapper implements ParsedVideoData {
	
	protected static $RESPONSE_FORMAT = self::RESPONSE_FORMAT_XML;
	protected static $API_URL = 'http://api.movieclips.com/v2/videos/$1';
	protected static $CACHE_KEY = 'movieclipsapi';
	protected static $MOVIECLIPS_XMLNS = 'http://api.movieclips.com/schemas/2010';
	protected static $PARSED_DATA_CACHE_KEY = 'movieclipsdata';
	protected $parsedData;

	public function __construct($videoId, $params=array()) {
		$this->videoId = $this->sanitizeVideoId($videoId);

		$memcKey = F::app()->wf->memcKey( static::$PARSED_DATA_CACHE_KEY, static::$CACHE_KEY_VERSION, $this->videoId );
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
		$data = array('parsedData'=>$this->parsedData);
		return $data;
	}
	
	public function loadDataFromCache($cacheData) {
		$this->parsedData = $cacheData['parsedData'];
	}

	public function getTitle() {
		if (!empty($this->videoName)) {
			return $this->videoName;
		}
		else {			
			$title = '';
			$title .= $this->getMovieTitleAndYear() . ' - ';
			$title .= $this->getVideoTitle();
			return $title;
		}
	}

	protected function getMovieTitleAndYear() {
		if ($movieTitleAndYear = $this->getParsedDataField('movieTitleAndYear')) {
			return $movieTitleAndYear;
		}
		else {
			$description = $this->getOriginalDescription(false);
			preg_match('/(.+? \(\d{4}\)) - /', $description, $matches);
			if (is_array($matches) && sizeof($matches) > 1) {
				return $matches[1];
			}
		}

		return '';
	}

	protected function getVideoTitle() {
		if ($videoTitle = $this->getParsedDataField('videoTitle')) {
			return $videoTitle;
		}
		elseif (!empty($this->interfaceObj)) {
			return html_entity_decode( $this->interfaceObj['child'][SIMPLEPIE_NAMESPACE_ATOM_10]['entry'][0]['child'][SIMPLEPIE_NAMESPACE_ATOM_10]['title'][0]['data'] );
		}

		return '';
	}

	public function getDescription() {
		return $this->getOriginalDescription();
	}
	
	public function getThumbnailUrl() {
		if ($thumbnailUrl = $this->getParsedDataField('thumbnailUrl')) {
			return $thumbnailUrl;
		}
		elseif (!empty($this->interfaceObj)) {
			$thumbnails = $this->interfaceObj['child'][SIMPLEPIE_NAMESPACE_ATOM_10]['entry'][0]['child'][SIMPLEPIE_NAMESPACE_MEDIARSS]['group'][0]['child'][SIMPLEPIE_NAMESPACE_MEDIARSS]['thumbnail'];
			return $this->getLargestThumbnailUrl($thumbnails);
		}
		
		return '';
	}

	private function getLargestThumbnailUrl($thumbnails) {
		$highestVal = 0;
		$highestUrl = '';

		if (is_array($thumbnails)) {
			foreach ($thumbnails as $thumbnail) {
				if ($thumbnail['attribs']['']['height'] > $highestVal) {
					$highestUrl = $thumbnail['attribs']['']['url'];
				}
			}
		}

		return $highestUrl;
	}
		
	protected function getOriginalDescription($stripTitleAndYear=true) {
		if ($description = $this->getParsedDataField('description')) {
			return $description;
		}
		elseif (!empty($this->interfaceObj)) {
			$description = strip_tags( html_entity_decode( $this->interfaceObj['child'][SIMPLEPIE_NAMESPACE_ATOM_10]['entry'][0]['child'][SIMPLEPIE_NAMESPACE_ATOM_10]['content'][0]['data'] ) );
			if ($stripTitleAndYear) {
				$description = str_replace("{$this->getMovieTitleAndYear()} - {$this->getVideoTitle()} - ", '', $description);
			}
			return $description;
		}
		
		return '';		
	}
	
	protected function getVideoPublished() {
		if ($published = $this->getParsedDataField('published')) {
			return strtotime($published);
		}
		elseif (!empty($this->interfaceObj)) {
			return strtotime($this->interfaceObj['child'][SIMPLEPIE_NAMESPACE_ATOM_10]['entry'][0]['child'][SIMPLEPIE_NAMESPACE_ATOM_10]['published'][0]['data']);
		}
		
		return '';
	}
	
	protected function getVideoDuration() {
		if ($duration = $this->getParsedDataField('duration')) {
			return $duration;
		}
		elseif (!empty($this->interfaceObj)) {
			return $this->interfaceObj['child'][SIMPLEPIE_NAMESPACE_ATOM_10]['entry'][0]['child'][SIMPLEPIE_NAMESPACE_MEDIARSS]['group'][0]['child'][SIMPLEPIE_NAMESPACE_MEDIARSS]['content'][0]['attribs']['']['duration'];
		}
		
		return '';
	}	
}