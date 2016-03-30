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
		# transition only, remove when new deploytools are released
		if ( file_exists("$IP/../docroot" ) ) {
			return self::getVersionFromDir("$IP/../docroot");
		}
	}

	public static function getVersionFromDir($dir) {
		$filename = $dir . '/wikia.version.txt';
		if ( file_exists( $filename ) ) {
			return file_get_contents( $filename );
		}
		# transition only, remove when new deploytools are released
		$filename = $dir . '/VERSION';
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
		return shell_exec("cd $dir ; git branch | grep '*' | perl -pe 's/^\* (\S+).*$/$1/g'");
	}

	/**
	 * Returns wiki text showing the third party software versions (apache, php, mysql).
	 * @see SpecialVersion
	 * @return array of strings
	 */
	public static function getSoftwareList() {
	    $dbr = wfGetDB( DB_SLAVE );

	    // Put the software in an array of form 'name' => 'version'. All messages should
	    // be loaded here, so feel free to use wfMsg*() in the 'name'. Raw HTML or wikimarkup
	    // can be used.
	    $software = array();
	    $software['[https://www.mediawiki.org MediaWiki]'] = self::getVersionLinked();
	    $software['[http://www.php.net/ PHP]'] = phpversion() . " (" . php_sapi_name() . ")";
	    $software[$dbr->getSoftwareLink()] = $dbr->getServerInfo();

	    // Allow a hook to add/remove items.
	    wfRunHooks( 'SoftwareInfo', array( &$software ) );

		return $software;
	}
}
