<?php

class ScreenplayApiWrapper extends IngestionApiWrapper {
	const VIDEO_TYPE = '.mp4';
	const THUMBNAIL_TYPE = '.jpg';

	const MEDIUM_JPEG_BITRATE_ID = 267;   // 250x200
	const LARGE_JPEG_BITRATE_ID = 382;    // 480x360

	const HIGHDEF_BITRATE_ID = 449;       // 720p, 16:9
	const STANDARD_43_BITRATE_ID = 455;   // 360, 4:3
	const STANDARD_BITRATE_ID = 461;      // 360, 16:9
	const STANDARD2_43_BITRATE_ID = 471;  // 360, 4:3
	const STANDARD2_BITRATE_ID = 472;     // 360, 16:9

	const ENCODEFORMATCODE_JPEG = 9;
	const ENCODEFORMATCODE_MP4 = 20;

	protected static $CACHE_KEY = 'screenplayapi';
	protected static $aspectRatio = 1.7777778;
	protected static $THUMBNAIL_URL_TEMPLATE = 'http://www.totaleclips.com/Player/Bounce.aspx?eclipid=$1&bitrateid=$2&vendorid=$3&type=$4';

	public function getDescription() {
		return '';	//  no description from provider
	}

	public function getThumbnailUrl() {

		$bitrateId = self::MEDIUM_JPEG_BITRATE_ID;
		if ( !empty( $this->metadata['jpegBitrateCode'] ) ) {
			$bitrateId = $this->metadata['jpegBitrateCode'];
		} elseif ( !empty( $this->interfaceObj[3] ) ) {
			$bitrateId = $this->interfaceObj[3];
		}
		$thumb = str_replace( '$1', $this->videoId, self::$THUMBNAIL_URL_TEMPLATE );
		$thumb = str_replace( '$2', $bitrateId, $thumb );
		$thumb = str_replace( '$3', F::app()->wg->ScreenplayApiConfig['customerId'], $thumb );
		$thumb = str_replace( '$4', self::THUMBNAIL_TYPE, $thumb );
		return $thumb;
	}

	protected function getVideoDuration(){
		if ( !empty( $this->interfaceObj[2] ) ) {
			return $this->interfaceObj[2];
		}
		return '';
	}

	public function getAspectRatio() {
		// force 16:9
		return self::$aspectRatio;
	}

	protected function isHdAvailable() {
		if ( !empty( $this->interfaceObj[1] ) ) {
			return true;
		}
		return false;
	}

	protected function getVideoPublished(){
		if ( !empty( $this->interfaceObj[4] ) ) {
			return strtotime($this->interfaceObj[4]);
		}
		return '';	// Screenplay API includes this field, but videos ingested prior to refactoring didn't save it
	}
}
