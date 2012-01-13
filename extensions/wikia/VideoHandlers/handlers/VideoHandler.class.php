<?php

/*
 * Handler layer between specyfic video handler and the rest of BitmapHandlers
 * Used mainly for identyfication of Video hanlders
 *
 * In future common handler logic will be migrated here
 * If you are using public video handler specyfic function write them down here
 * 
 */

class VideoHandler extends BitmapHandler {

	protected $api = null;
	protected $apiName = 'video/*';
	protected $videoId = '';
	protected static $aspectRatio;
	protected static $isJSLoaded = false;
	
	function getEmbed($width, $autoplay=false){
		/* override */
		return false;
	}

	function setVideoId( $videoId ){
		$this->videoId = $videoId;
	}
	
	public function getVideoId() {
		return $this->videoId;
	}
	
	function getMetadata( $image, $filename ) {
		$this->loadApi();
		return $this->api instanceof ApiWrapper ? serialize( $this->api->getMetadata() ) : false;
	}

	function loadApi() {
		if ( !empty( $this->videoId ) && empty( $this->api ) ){
			$this->api = F::build ( $this->apiName, array( $this->videoId ) );
		}
	}

	function getThumbType( $ext, $mime, $params = null ) {
		return array( 'jpg', 'image/jpeg' );
	}

	/**
	 * Get the thumbnail extension and MIME type for a given source MIME type
	 * @return array thumbnail extension and MIME type
	 */

	function doTransform( $image, $dstPath, $dstUrl, $params, $flags = 0 ) {
		global $wgOut, $wgExtensionsPath;

		$oThumbnailImage = parent::doTransform( $image, $dstPath, $dstUrl, $params, $flags );

		if (empty(self::$isJSLoaded)) {
			$wgOut->addScript('<script src="'.$wgExtensionsPath.'/wikia/VideoHandlers/js/VideoHandlers.js"></script>');
			self::$isJSLoaded = true;
		}		

		return new ThumbnailVideo(
			$oThumbnailImage->file,
			$oThumbnailImage->url,
			$oThumbnailImage->width,
			$oThumbnailImage->height,
			$oThumbnailImage->path,
			$oThumbnailImage->page
		);		
	}

}
