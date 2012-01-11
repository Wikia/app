<?php

/* Leaf to WikiaLocalFile Composite */

class WikiaVideoLogic  {

	var $forceMime = '';
	var $oFile = null;
	var $videoId = '';
	const VIDEO_MEDIA_TYPE = 'VIDEO';

	private $lockedProperties = array( 'metadata', 'minor_mime', 'major_mime', 'mime', 'media_type' );
	private $lockedPropertiesValues = array();
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
	public function getEmbedCode( $width ){
		if ( $this->isVideo() ){
			return $this->oFile->getHandler()->getEmbed( $width );
		} else {
			false;
		}
	}

	function forceMime( $aMime ){
		$this->forceMime = $aMime;
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

	function afterGetHandler(){
		$videoId = $this->getVideoId();
		if ( !empty( $videoId ) && ( $this->oFile->media_type == self::VIDEO_MEDIA_TYPE ) ){
			$this->oFile->handler->setVideoId( $videoId );
		}
	}

	function afterSetProps() {
		if ( $this->forceMime ){
			$this->oFile->dataLoaded = true;
			$this->oFile->mime = $this->forceMime;
			list( $this->oFile->major_mime, $this->oFile->minor_mime ) = LocalFile::splitMime( $this->oFile->mime );

			$handler = MediaHandler::getHandler( $this->oFile->getMimeType() );
			$handler->setVideoId( $this->oFile->videoId );

			$this->oFile->metadata = $handler->getMetaData( false, false );
			$this->oFile->media_type = 'video';
			$this->forceMime = false;
		}
	}

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
