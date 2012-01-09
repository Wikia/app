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
		return empty( $api ) ? $api()->getTitles() : false;
	}
	// dunno if will be used
	function getDescription() {
		$this->loadApi();
		return empty( $api ) ? $api()->getDescription() : false;
	}

	function getMetadata( $image, $filename ) {
		$this->loadApi();
		return empty( $api ) ? $api()->getMetaData() : false;
	}

	function loadApiDriver() {
		if ( !empty( $this->videoId ) && empty( $this->api ) ){
			$this->api = F::build ( $this->apiName, array( $this->videoId ) );
		}
	}
}
