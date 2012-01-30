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
		return '';	// Screenplay API includes this field, but videos
				// ingested prior to refactoring didn't save it
	}
}