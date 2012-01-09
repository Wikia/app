<?php

class WikiaLocalFile extends LocalFile {

	protected $forceMime = '';

	function __construct( $title, $repo ){
		parent::__construct( $title, $repo );
	}
	
	/**
	 * Create a LocalFile from a title
	 * Do not call this except from inside a repo class.
	 *
	 * Note: $unused param is only here to avoid an E_STRICT
	 */
	static function newFromTitle( $title, $repo, $unused = null ) {
		return new self( $title, $repo );
	}

	/**
	 * Create a LocalFile from a title
	 * Do not call this except from inside a repo class.
	 */
	static function newFromRow( $row, $repo ) {
		$title = Title::makeTitle( NS_FILE, $row->img_name );
		$file = new self( $title, $repo );
		$file->loadFromRow( $row );
		return $file;
	}

	/*
	 * Checkes if file is a video
	 */

	function isVideo(){
		// Has proper mediatype
		if ( $this->media_type == 'video' ) return true;
		// if mediatype is not set, maybe it has appropriate handler?
		if ( $this->getHandler() instanceof VideoHandler ) return true;
		// Too bad
		return false;
	}

	/*
	 * Returns embed HTML
	 */
	function getEmbedCode(){
		if ( $this->isVideo() ){
			return $this->handler->getEmbed();
		} else {
			false;
		}
	}

	function forceMime( $sMime ){
		$this->forceMime = $sMime;
	}

	function setVideoId( $videoId ){
		if ( $this->isVideo() ){
			$this->videoId = $videoId;
		}
	}

	function getHandler(){
		$oHandler = parent::getHandler();
		if ( !empty( $this->videoId ) && $this->isVideo() ){
			$oHandler->setVideoId( $this->videoId );
		}
		return $oHandler;
	}

	function setProps( $info ) {

		parent::setProps( $info );
		if ( $this->forceMime ){
			$this->dataLoaded = true;
			$this->mime = $this->forceMime;
			list( $this->major_mime, $this->minor_mime ) = self::splitMime( $this->mime );
			$handler = MediaHandler::getHandler( $this->getMimeType() );
			$this->metadata = $handler->getMetaData();
			$this->media_type = 'video';
		}
	}

	/**
	 * Load metadata from the file itself unless it is a video
	 */
	function loadFromFile() {

		$aParams = array( 'minor_mime', 'major_mime', 'mime', 'media_type' );
		if ( $this->isVideo() ){
			$aVal = array();
			foreach( $aParams as $param ){
				$aVal[ $param ] = $this->$param;
			}
		}
		
		parent::loadFromFile();

		if ( $this->isVideo() ){
			foreach( $aParams as $param ){
				$this->$param = $aVal[ $param ];
			}
		}
	}
}
