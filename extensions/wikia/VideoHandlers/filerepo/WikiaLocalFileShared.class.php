<?php

/* Leaf to WikiaLocalFile Composite
 * 
 * Handles logic shared through Wikia LocalFile Wrappers
 */

class WikiaLocalFileShared  {

	var $forceMime = '';
	var $oFile = null;
	var $videoId = '';
	const VIDEO_MEDIA_TYPE = 'VIDEO';

	function __construct( $oWikiaLocalFile ){
		$this->oFile = $oWikiaLocalFile;
	}

	/*
	 * Checkes if file is a video
	 */
	public function isVideo(){
		// Has proper mediatype
		if ( $this->oFile->media_type == self::VIDEO_MEDIA_TYPE ) return true;
		// if mediatype is not set, maybe it has appropriate handler?
		if ( $this->oFile->getHandler() instanceof VideoHandler ) return true;
		// Too bad
		return false;
	}

	/*
	 * Returns embed HTML
	 */
	public function getEmbedCode( $articleId, $width, $autoplay=false, $isAjax=false ){
		$handler = $this->oFile->getHandler();
		if ( $this->isVideo() && !empty($handler) ){
			$handler->setThumbnailImage($this->oFile->getThumbnail($width));			
			return $handler->getEmbed( $articleId, $width, $autoplay, $isAjax );
		} else {
			return false;
		}
	}
	
	public function getPlayerAssetUrl() {
		if ( $this->isVideo() ) {
			return $this->oFile->getHandler()->getPlayerAssetUrl();
		}
		else {
			return false;
		}
	}

	/*
	 * Force file to use some specyfic mimetype
	 *
	 * MediaWiki is getting mime type directly from a file.
	 * Need to alter this behavior for videos
	 * as they are represented in filesystem by an image
	 */
	
	function forceMime( $aMime, $metadata = false ){
		$this->forceMime = $aMime;
		if ( !empty( $metadata ) ){
			$this->forceMetadata = $metadata;
		}
	}

	function setVideoId( $videoId ){
		$this->videoId = $videoId;
	}

	function getVideoId(){
		if (!empty($this->videoId)) {
			return $this->videoId;
		}

		// check metadata
		if ( !empty( $this->oFile->metadata ) ) {
			$metadata = unserialize($this->oFile->metadata);
			if (!empty($metadata['videoId'])) {
				$this->videoId = $metadata['videoId'];
			}
		}
		return $this->videoId;
	}

	/* alter LocalFile getHandler logic */

	function afterGetHandler(){
		if (!empty($this->oFile->handler)) {
			// make sure that the new handler ( if video ) will have videoId
			if ($this->oFile->media_type == self::VIDEO_MEDIA_TYPE) {
				$videoId = $this->getVideoId();
				if ( !empty( $videoId ) ){
					$this->oFile->handler->setVideoId( $videoId );
				}			
				$this->oFile->handler->setTitle($this->oFile->getTitle()->getText());
				$this->oFile->handler->setMetadata($this->oFile->metadata);
			}
		}
	}

	/* alter LocalFile setProps logic */

	function afterSetProps() {
		if ( $this->forceMime ){
			// if mime type was forced, repopulate File with proper data
			$this->oFile->dataLoaded = true;
			$this->oFile->mime = $this->forceMime;
			list( $this->oFile->major_mime, $this->oFile->minor_mime ) = LocalFile::splitMime( $this->oFile->mime );
			$handler = MediaHandler::getHandler( $this->oFile->getMimeType() );
			
			$handler->setVideoId( $this->oFile->videoId );

			$this->oFile->metadata = ( isset( $this->forceMetadata ) ) ? $this->forceMetadata : $handler->getMetadata();
			$this->oFile->media_type = self::VIDEO_MEDIA_TYPE;
			$this->forceMime = false;
		}
	}

	/* alter loadFromFile logic
	 * 
	 * loadFromFile resets few params in class based on actual file in file system.
	 * As videos are represented as image files we want some data not to be reseted.
	 */

	private $lockedProperties = array( 'metadata', 'minor_mime', 'major_mime', 'mime', 'media_type' );
	private $lockedPropertiesValues = array();

	function beforeLoadFromFile(){
		if ( $this->isVideo() ){
			$this->lockedPropertiesValues = array();
			foreach( $this->lockedProperties as $param ){
				$this->lockedPropertiesValues[ $param ] = $this->oFile->$param;
			}
		}
	}

	function afterLoadFromFile(){
		if ( $this->isVideo() ){
			foreach( $this->lockedProperties as $param ){
				$this->oFile->$param = $this->lockedPropertiesValues[ $param ];
			}
		}
	}
}
