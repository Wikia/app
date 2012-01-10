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

	function getEmbed(){
		/* override */
		return false;
	}

	function setVideoId( $videoId ){
		$this->videoId = $videoId;
	}
	// dunno if will be used
	function getTitle() {
		$this->loadApi();
		return $this->api instanceof ApiWrapper ? $this->api->getTitles() : false;
	}
	// dunno if will be used
	function getDescription() {
		$this->loadApi();
		return $this->api instanceof ApiWrapper ? $this->api->getDescription() : false;
	}

	function getMetadata( $image, $filename ) {
		$this->loadApi();
		return $this->api instanceof ApiWrapper ? serialize( $this->api->getMetaData() ) : false;
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

		$oThumbnailImage = parent::doTransform( $image, $dstPath, $dstUrl, $params, $flags );

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
