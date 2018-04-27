<?php

class WikiaSpecialVersion extends SpecialVersion {
	/**
	 * Identifies tag we're on based on file
	 * @return string
	 */
	public static function getWikiaCodeVersion() {
		global $IP;
		return self::getVersionFromDir($IP);
	}

	public static function getWikiaConfigVersion() {
		global $IP;
		if ( file_exists( "$IP/../config" ) ) {
			return self::getVersionFromDir("$IP/../config");
		}
	}

	public static function getVersionFromDir($dir) {
		$filename = $dir . '/wikia.version.txt';
		if ( file_exists( $filename ) ) {
			return file_get_contents( $filename );
		}
		return self::getGitBranch($dir);
	}

	/**
	 * Identifies branch we're on based on git call
	 * @return string
	 * @todo use MW 1.20 functionality for Git-based version
	 */
	private static function getGitBranch($dir) {
		return shell_exec("cd $dir ; git branch 2> /dev/null | grep '*' | perl -pe 's/^\* (\S+).*$/$1/g'");
	}

	/**
	 * Returns wiki text showing MediaWiki (and SMW) version.
	 * @see SpecialVersion
	 * @return string[]
	 */
	public static function getSoftwareList() {
	    // Put the software in an array of form 'name' => 'version'. All messages should
	    // be loaded here, so feel free to use wfMsg*() in the 'name'. Raw HTML or wikimarkup
	    // can be used.
	    $software = array();
	    $software['[https://www.mediawiki.org MediaWiki]'] = self::getVersionLinked();

	    // Allow a hook to add/remove items.
	    Hooks::run( 'SoftwareInfo', array( &$software ) );

		return $software;
	}
}
