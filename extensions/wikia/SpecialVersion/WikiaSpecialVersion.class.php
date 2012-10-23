<?php 

class WikiaSpecialVersion extends SpecialVersion
{
	/**
	 * Identifies tag we're on based on file
	 * @return string
	 */
	public static function getWikiaVersion() {
		global $IP;
		$filename = $IP . '/VERSION';
		if ( file_exists( $filename ) ) {
			return file_get_contents( $IP . '/VERSION' );
		}
		
		return self::getGitBranch();
	}

	/**
	 * Identifies branch we're on based on git call
	 * @return string
	 * @todo use MW 1.20 functionality for Git-based version
	 */
	private function getGitBranch()
	{
		return `git branch | grep '*' | perl -pe 's/^\* ([^ ]+).*$/$1/g'`;
	}
	
	/**
	 * Returns wiki text showing the third party software versions (apache, php, mysql).
	 * @see SpecialVersion
	 * @return string
	 */
	public static function softwareInformation()
	{
		
	    $dbr = wfGetDB( DB_SLAVE );
	
	    // Put the software in an array of form 'name' => 'version'. All messages should
	    // be loaded here, so feel free to use wfMsg*() in the 'name'. Raw HTML or wikimarkup
	    // can be used.
	    $software = array();
	    $software['[https://www.mediawiki.org/ MediaWiki]'] = self::getVersionLinked();
	    $software['[http://www.php.net/ PHP]'] = phpversion() . " (" . php_sapi_name() . ")";
	    $software[$dbr->getSoftwareLink()] = $dbr->getServerInfo();
	
	    // Allow a hook to add/remove items.
	    wfRunHooks( 'SoftwareInfo', array( &$software ) );
	
	    $out = Xml::element( 'h2', array( 'id' => 'mw-version-software' ), wfMsg( 'version-software' ) ) .
	    Xml::openElement( 'table', array( 'class' => 'wikitable', 'id' => 'sv-software' ) ) .
	    "<tr>
				<th>" . wfMsg( 'version-software-product' ) . "</th>
				<th>" . wfMsg( 'version-software-version' ) . "</th>
			</tr>\n
			<tr>
				<td>Wikia</td>
				<td>" . self::getWikiaVersion() . "</td>
			</tr>\n";
	
	    foreach( $software as $name => $version ) {
	        $out .= "<tr>
				<td>" . $name . "</td>
				<td dir=\"ltr\">" . $version . "</td>
			</tr>\n";
	    }
	
	    return $out . Xml::closeElement( 'table' );
	}
}