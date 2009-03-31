<?php

/**
 * Helper tools for dealing with other locally-hosted wikis
 */

class WikiMap {
	static function getWiki( $wikiID ) {
		global $wgConf, $IP;
		static $initialiseSettingsDone = false;

		// This is a damn dirty hack
		if ( !$initialiseSettingsDone ) {
			$initialiseSettingsDone = true;
			if( file_exists( "$IP/InitialiseSettings.php" ) ) {
				require_once "$IP/InitialiseSettings.php";
			}
		}

		list( $major, $minor ) = $wgConf->siteFromDB( $wikiID );
		if( isset( $major ) ) {
			$server = $wgConf->get( 'wgServer', $wikiID, $major,
				array( 'lang' => $minor, 'site' => $major ) );
			$path = $wgConf->get( 'wgArticlePath', $wikiID, $major,
				array( 'lang' => $minor, 'site' => $major ) );
			return new WikiReference( $major, $minor, $server, $path );
		} else {
			return null;
		}

	}
}

class WikiReference {
	private $mMinor; ///< 'en', 'meta', 'mediawiki', etc
	private $mMajor; ///< 'wiki', 'wiktionary', etc
	private $mServer; ///< server override, 'www.mediawiki.org'
	private $mPath;   ///< path override, '/wiki/$1'

	function __construct( $major, $minor, $server, $path ) {
		$this->mMajor = $major;
		$this->mMinor = $minor;
		$this->mServer = $server;
		$this->mPath = $path;
	}

	function getHostname() {
		$prefixes = array( 'http://', 'https://' );
		foreach ( $prefixes as $prefix ) {
			if ( substr( $this->mServer, 0, strlen( $prefix ) ) ) {
				return substr( $this->mServer, strlen( $prefix ) );
			}
		}
		throw new MWException( "Invalid hostname for wiki {$this->mMinor}.{$this->mMajor}" );
	}

	/**
	 * pretty it up
	 */
	function getDisplayName() {
		$url = $this->getUrl( '' );
		$url = preg_replace( '!^https?://!', '', $url );
		$url = preg_replace( '!/index\.php(\?title=|/)$!', '/', $url );
		$url = preg_replace( '!/wiki/$!', '/', $url );
		$url = preg_replace( '!/$!', '', $url );
		return $url;
	}

	private function getLocalUrl( $page ) {
		// FIXME: this may be generalized...
		return str_replace( '$1', wfUrlEncode( str_replace( ' ', '_', $page ) ), $this->mPath );
	}

	function getUrl( $page ) {
		return
			$this->mServer . 
			$this->getLocalUrl( $page );
	}
}
