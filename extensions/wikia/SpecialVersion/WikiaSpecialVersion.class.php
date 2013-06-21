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
		return self::getVersionFromDir("/usr/wikia/conf/current"); # no global for config path :(
	}

	public static function getVersionFromDir($dir) {
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
	private function getGitBranch($dir) {	
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
