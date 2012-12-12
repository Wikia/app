<?php

/* Leaf to WikiaLocalFile Composite
 *
 * Handles logic shared through Wikia LocalFile Wrappers
 */

class WikiaLocalFileShared  {

	var $forceMime = '';
	var $oFile = null;
	var $videoId = '';
	var $trackingArticleId = false;
	var $embedCodeMaxHeight = false;

	function __construct( $oWikiaLocalFile ){
		$this->oFile = $oWikiaLocalFile;
	}

	/*
	 * Checkes if file is a video
	 */
	public function isVideo(){
		wfProfileIn( __METHOD__ );
		$ret = ($this->oFile->getHandler() instanceof VideoHandler);
		wfProfileOut( __METHOD__ );
		return $ret;
	}

	/*
	 * Embed code max height
	 */
	public function setEmbedCodeMaxHeight( $height ) {
		$this->embedCodeMaxHeight = $height;
	}

	public function addExtraBorder( $width ){
		if ( $this->isVideo() ){
			return ($this->oFile->getHandler()->addExtraBorder( $width ));
		}
		return 0;
	}

	/*
	 * Returns embed HTML
	 */
	public function getEmbedCode( $width, $autoplay = false, $isAjax = false, $postOnload = false ){
		wfProfileIn( __METHOD__ );
		if ( ( $this->trackingArticleId !== false ) && ( F::app()->wg->title instanceof Title ) ){
			$this->trackingArticleId = F::app()->wg->title->getArticleID();
		}
		$handler = $this->oFile->getHandler();
		if ( $this->isVideo() && !empty($handler) ){
			if ( $this->embedCodeMaxHeight !== false && $this->embedCodeMaxHeight > 0 ) {
				$handler->setMaxHeight( $this->embedCodeMaxHeight );
			}
			$handler->setThumbnailImage( $this->oFile->transform( array( 'width' => $width ) ) );
			$this->trackingArticleId = false;
			$embed = $handler->getEmbed( $this->trackingArticleId, $width, $autoplay, $isAjax, $postOnload );
			$res = $embed;
		} else {
			$this->trackingArticleId = false;
			$res = false;
		}
		wfProfileOut( __METHOD__ );
		return $res;
	}

	public function getPlayerAssetUrl() {

		wfProfileIn( __METHOD__ );
		if ( $this->isVideo() ) {
			$asset = $this->oFile->getHandler()->getPlayerAssetUrl();
			$res = $asset;
		}
		else {
			$res = false;
		}
		wfProfileOut( __METHOD__ );
		return $res;
	}

	public function getVideoUniqueId() {
		return $this->getProviderName() . $this->getVideoId();
	}

	public function getProviderName() {
		return $this->oFile->minor_mime;
	}

	public function getProviderDetailUrl() {
		wfProfileIn( __METHOD__ );
		$handler = $this->oFile->getHandler();
		if ( $this->isVideo() && !empty( $handler ) ){
			$detail = $handler->getProviderDetailUrl();
			wfProfileOut( __METHOD__ );
			return $detail;
		}
		wfProfileOut( __METHOD__ );
		return false;
	}

	public function getProviderHomeUrl() {
		$handler = $this->oFile->getHandler();
		if ( $this->isVideo() && !empty( $handler ) ){
			return $handler->getProviderHomeUrl();
		}

		return false;
	}

	/*
	 * Force file to use some specyfic mimetype
	 *
	 * MediaWiki is getting mime type directly from a file.
	 * Need to alter this behavior for videos
	 * as they are represented in filesystem by an image
	 */

	function forceMime( $aMime ){
		$this->forceMime = $aMime;
	}

	/*
	 * Used only as part of video migration process (prevent
	 * connecting to Provider, because we take metadata from
	 * previously stored information)
	 * and in video ingestion scripts from premium partners
	 */
	function forceMetadata( $metadata ) {
		$this->forceMetadata = $metadata;
	}

	function setVideoId( $videoId ){
		$this->videoId = $videoId;
	}

	function getVideoId(){
		wfProfileIn( __METHOD__ );
		if ( !empty( $this->videoId ) ) {
			wfProfileOut( __METHOD__ );
			return $this->videoId;
		}

		// check metadata
		if ( !empty( $this->oFile->metadata ) ) {
			$metadata = unserialize($this->oFile->metadata);
			if (!empty($metadata['videoId'])) {
				$this->videoId = $metadata['videoId'];
			}
		}
		wfProfileOut( __METHOD__ );
		return $this->videoId;
	}

	/* alter LocalFile getHandler logic */

	function afterGetHandler(&$handler){
		wfProfileIn( __METHOD__ );
		if (!empty($handler) && $handler instanceof VideoHandler) {
			// make sure that the new handler ( if video ) will have videoId
			if ($this->oFile->media_type == MEDIATYPE_VIDEO) {
				$videoId = $this->getVideoId();
				if ( !empty( $videoId ) ){
					$handler->setVideoId( $videoId );
				}
				$handler->setTitle($this->oFile->getTitle()->getText());
				$handler->setMetadata($this->oFile->metadata);
			}
		}
		wfProfileOut( __METHOD__ );
	}

	/* alter LocalFile setProps logic */

	function afterSetProps() {
		global $wgMediaHandlers;

		if ( $this->forceMime ){
			// if mime type was forced, repopulate File with proper data
			$this->oFile->dataLoaded = true;
			$this->oFile->mime = $this->forceMime;
			list( $this->oFile->major_mime, $this->oFile->minor_mime ) = LocalFile::splitMime( $this->oFile->mime );
			// normally, this kind of method would call
			// MediaHandler::getHandler(). However, this function
			// may be called repeatedly in one session (by a video
			// ingestion script) for different videos. MediaHandler::getHandler()
			// reads its own cache and returns the same video handler for different videos.
			// We must create the proper video handler ourselves.
			$type = $this->oFile->getMimeType();
			$class = $wgMediaHandlers[$type];
			$handler = new $class();
			$handler->setVideoId( $this->oFile->videoId );

			$this->oFile->metadata = ( isset( $this->forceMetadata ) ) ? $this->forceMetadata : $handler->getMetadata();
			$this->oFile->media_type = MEDIATYPE_VIDEO;
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

	function isBroken(){
		return 	$this->oFile->getSize() == 0
			? true
			: $this->oFile->getHandler()->isBroken();
	}
}
