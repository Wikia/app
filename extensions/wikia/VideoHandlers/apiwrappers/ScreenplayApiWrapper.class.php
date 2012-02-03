<?php

class ScreenplayApiWrapper extends WikiaVideoApiWrapper {
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
	
	protected static $CACHE_KEY = 'screenplayapi';

	public function __construct($videoName, $params=array()) {
		$this->videoName = $videoName;
		if (!empty($params['videoId'])) {
			$this->videoId = $params['videoId'];
		}

		$memcKey = F::app()->wf->memcKey( static::$CACHE_KEY, static::$CACHE_KEY_VERSION, $this->videoName );
		$data = F::app()->wg->memc->get( $memcKey );
		$cacheMe = false;
		if ( empty( $data ) ){
			if (!empty($params['interfaceObj'])) {
				$this->interfaceObj = $params['interfaceObj'];
			}
			else {
				$this->initializeInterfaceObject();			
			}
			$cacheMe = true;
			$data = $this->generateCacheData();
		}
		else {
			$this->loadDataFromCache($data);
		}
		
		
		if ( $cacheMe ) {
			F::app()->wg->memc->set( $memcKey, $data, static::$CACHE_EXPIRY );
		}
	}
	
	protected function generateCacheData() {
		$data = array('videoId'=>$this->videoId, 'interfaceObj'=>$this->interfaceObj);
		return $data;
	}
	
	protected function loadDataFromCache($cacheData) {
		$this->videoId = $cacheData['videoId'];
		$this->interfaceObj = $cacheData['interfaceObj'];
	}
	
	public function getTitle() {
		return $this->videoName;
	}
	
	public function getDescription() {
		return '';	// no description from provider
	}
	
	public function getThumbnailUrl() {
		$bitrateId = self::MEDIUM_JPEG_BITRATE_ID;
		if (!empty($this->interfaceObj[3])) {
			$bitrateId = $this->interfaceObj[3];
		}
		$thumb = 'http://www.totaleclips.com/Player/Bounce.aspx?eclipid='.$this->videoId.'&bitrateid='.$bitrateId.'&vendorid='.self::VENDOR_ID.'&type='.self::THUMBNAIL_TYPE;
		return $thumb;
	}

	protected function getVideoDuration(){
		if (!empty($this->interfaceObj[2])) {
			return $this->interfaceObj[2];
		}
		return '';
	}
	
	protected function getAspectRatio() {
		if (!empty($this->interfaceObj[0])) {
			if ($this->interfaceObj[0] == self::STANDARD_BITRATE_ID) {
				return 1.7777778;
			}
		}
		return '';		
	}
	
	protected function isHdAvailable() {
		if (!empty($this->interfaceObj[1])) {
			return true;
		}
		return false;
	}
	
	protected function getVideoPublished(){
		if (!empty($this->interfaceObj[4])) {
			return strtotime($this->interfaceObj[4]);
		}
		return '';	// Screenplay API includes this field, but videos
				// ingested prior to refactoring didn't save it
	}
}