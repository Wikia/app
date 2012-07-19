<?php

class WikiaApiWrapper extends ApiWrapper {

	protected $file = null;

	public function __construct( $videoId, $overrideMetadata = array() /* not used atm */ , $fileName = '' ) {
		wfProfileIn( __METHOD__ );

		$this->videoId = $this->sanitizeVideoId( $videoId );

		if( !empty( $fileName ) ) {
			$this->file = wfFindFile( $fileName );

			if ( !$this->file ) { // bugID: 26721
				$this->file = wfFindFile( urldecode($fileName) );
			}
		}

		wfProfileOut( __METHOD__ );
	}

	public static function isMatchingHostname( $hostname ) {
		if( endsWith($hostname, "wikia.com") || endsWith($hostname, "wikia-inc.com") ) {
			return true;
		}

		// local links
		foreach( self::getNSCanonicalNames() as $nsName ) {
			if( startsWith(ucfirst($hostname), $nsName) ) {
				return true;
			}
		}

		return false;
	}

	public function getFile() {
		return $this->file;
	}

	public function isFileExists() {
		return !empty( $this->file );
	}

	public static function newFromUrl( $url ) {
		wfProfileIn( __METHOD__ );

		$pattern = '/(' . implode( '|', self::getNSCanonicalNames() ) . ')(.+)$/';

		if(preg_match($pattern, $url, $matches)) {
			$wrapper = new WikiaApiWrapper( 1, array(), $matches[2] );
			if( $wrapper->isFileExists() ) {
				wfProfileOut( __METHOD__ );
				return $wrapper;
			}
		}

		wfProfileOut( __METHOD__ );
		return null;
	}

	protected static function getNSCanonicalNames() {
		$names = array();

		$names[] = MWNamespace::getCanonicalName( NS_FILE ) . ":";
		$names[] = F::app()->wg->contLang->getNsText( NS_FILE ) . ":";

		return $names;
	}

	protected function getVideoTitle() {
		return !empty($this->file) ? $this->file->getTitle()->getText() : '';
	}

	public function getDescription() {
		return '';
	}

	public function getThumbnailUrl() {
		return '';
	}

	public function getMimeType() {
		return 'FILE';
	}

	public function getVideoId() {
		return !empty($this->file) ? $this->file->getHandler()->getVideoId() : $this->videoId;
	}

}
