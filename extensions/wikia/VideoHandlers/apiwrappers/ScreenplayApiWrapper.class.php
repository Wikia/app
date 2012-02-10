<?php

class ScreenplayApiWrapper extends WikiaVideoApiWrapper implements ParsedVideoData {
	const VENDOR_ID = 1893;
	const VIDEO_TYPE = '.mp4';
	const THUMBNAIL_TYPE = '.jpg';
	const MEDIUM_JPEG_BITRATE_ID = 267;	// 250x200
	const LARGE_JPEG_BITRATE_ID = 382;	// 480x360
	const HIGHDEF_BITRATE_ID = 449;	// 720p
	const STANDARD_43_BITRATE_ID = 455;	// 360, 4:3
	const STANDARD_BITRATE_ID = 461;	// 360, 16:9
	const ENCODEFORMATCODE_JPEG = 9;
	const ENCODEFORMATCODE_MP4 = 20;

	protected static $THUMBNAIL_URL_TEMPLATE = 'http://www.totaleclips.com/Player/Bounce.aspx?eclipid=$1&bitrateid=$2&vendorid=$3&type=$4';
	protected static $PARSED_DATA_CACHE_KEY = 'screenplaydata';
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
		return '';	// no description from provider
	}
	
	public function getThumbnailUrl() {
		$bitrateId = self::MEDIUM_JPEG_BITRATE_ID;
		if ($this->getParsedDataField('jpegBitrateCode')) {
			$bitrateId = $this->getParsedDataField('jpegBitrateCode');
		}
		elseif (!empty($this->interfaceObj[3])) {
			$bitrateId = $this->interfaceObj[3];
		}
		$thumb = str_replace('$1', $this->videoId, self::$THUMBNAIL_URL_TEMPLATE);
		$thumb = str_replace('$2', $bitrateId, $thumb);
		$thumb = str_replace('$3', self::VENDOR_ID, $thumb);
		$thumb = str_replace('$4', self::THUMBNAIL_TYPE, $thumb);
		return $thumb;
	}

	protected function getVideoDuration(){
		if ($duration = $this->getParsedDataField('duration')) {
			return $duration;
		}
		if (!empty($this->interfaceObj[2])) {
			return $this->interfaceObj[2];
		}
		return '';
	}
	
	protected function getAspectRatio() {
		$bitrateId = '';
		if ($this->getParsedDataField('stdBitrateCode')) {
			$bitrateId = $this->getParsedDataField('stdBitrateCode');
		}
		elseif (!empty($this->interfaceObj[0])) {
			$bitrateId = $this->interfaceObj[0];
		}

		if ($bitrateId == self::STANDARD_BITRATE_ID) {
			return 1.7777778;
		}
		
		return '';		
	}
	
	protected function isHdAvailable() {
		if ($this->getParsedDataField('hd')) {
			return true;
		}
		if (!empty($this->interfaceObj[1])) {
			return true;
		}
		return false;
	}
	
	protected function getVideoPublished(){
		if ($dateAdded = $this->getParsedDataField('dateAdded')) {
			return strtotime($dateAdded);
		}
		elseif (!empty($this->interfaceObj[4])) {
			return strtotime($this->interfaceObj[4]);
		}
		return '';	// Screenplay API includes this field, but videos
				// ingested prior to refactoring didn't save it
	}
}