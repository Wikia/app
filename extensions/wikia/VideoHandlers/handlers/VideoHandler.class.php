<?php

/*
 * Handler layer between specyfic video handler and the rest of BitmapHandlers
 * Used mainly for identyfication of Video hanlders
 *
 * In future common handler logic will be migrated here
 * If you are using public video handler specyfic function write them down here
 * 
 */

abstract class VideoHandler extends BitmapHandler {

	protected $api = null;
	protected $apiName = 'video/*';
	protected $videoId = '';
	protected static $aspectRatio;
	protected static $isJSLoaded = false;
	
	/**
	 * Returns embed code for a provider
	 * @return string Embed HTML
	 */
	abstract function getEmbed($width, $autoplay = false );

	function setVideoId( $videoId ){
		$this->videoId = $videoId;
	}
	
	public function getVideoId() {
		return $this->videoId;
	}
	
	/**
	 * Connects with Api and returns metadata
	 * @return ApiWrapper object
	 */
	function getMetadata( $image, $filename ) {
		return $this->getApi() instanceof ApiWrapper 
			? serialize( $this->getApi()->getMetadata() )
			: false;
	}

	/**
	 * Returns propper api for a current handler
	 * @return ApiWrapper object
	 */
	function getApi() {
		if ( !empty( $this->videoId ) && empty( $this->api ) ){
			$this->api = F::build ( $this->apiName, array( $this->videoId ) );
		}
		return $this->api;
	}

	/**
	 * Returns fedault thumbnail mime type
	 * @return array thumbnail extension and MIME type
	 */
	function getThumbType( $ext, $mime, $params = null ) {
		return array( 'jpg', 'image/jpeg' );
	}

	/**
	 * Get the thumbnail code for videos
	 * @return object ThumbnailVideo object or error object
	 */
	function doTransform( $image, $dstPath, $dstUrl, $params, $flags = 0 ) {
		global $wgOut, $wgExtensionsPath;

		$oThumbnailImage = parent::doTransform( $image, $dstPath, $dstUrl, $params, $flags );

		if ( empty( self::$isJSLoaded ) ) {
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
