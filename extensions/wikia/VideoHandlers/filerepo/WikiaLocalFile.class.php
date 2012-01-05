<?php

class WikiaLocalFile extends LocalFile {

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
		$oHandler = $this->getHandler();
		return ( $oHandler instanceof VideoHandler );
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
}
