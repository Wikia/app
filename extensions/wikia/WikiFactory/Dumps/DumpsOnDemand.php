<?php

/**
 * simple hook for displaying additional informations in Special:Statistics
 *
 * @author Krzysztof Krzyżaniak <eloy@wikia-inc.com>
 */
$wgHooks[ "CustomSpecialStatistics" ][] = "DumpsOnDemads::customSpecialStatistics";

$wgExtensionMessagesFiles[ "DumpsOnDemand" ] =  dirname( __FILE__ ) . '/DumpsOnDemand.i18n.php';

class DumpsOnDemand {

	const BASEURL = "http://wiki-stats.wikia.com";

	/**
	 * @access public
	 * @static
	 */
	static public function customSpecialStatistics( &$specialpage, &$text ) {
		global $wgOut, $wgDBname;

		wfLoadExtensionMessages( "DumpsOnDemads" );

		/**
		 * read json file with dumps information
		 */

		$tmpl = new EasyTemplate( dirname( __FILE__ ) . "/templates/" );
		$index = Wikia::json_decode( file_get_contents( self::getUrl( $wgDBname, "index.json" ) ) );

		$tmpl->set( "urlDumpFull", self::getUrl( $wgDBname, "pages_current.xml.gz" ) );
		$tmpl->set( "urlDumpCurr", self::getUrl( $wgDBname, "pages_full.xml.gz" ) );
		$tmpl->set( "index", $index );
		$text .= $tmpl->render( "dod" );
		return true;
	}

	/**
	 * return url to place where dumps are stored
	 *
	 * @static
	 * @access public
	 *
	 * @return String
	 */
	static public function getUrl( $database, $file, $baseurl = false ) {
		$database = strtolower( $database );

		return sprintf(
			"%s/%s/%s/%s/%s",
			( $baseurl === false ) ? self::BASEURL : $baseurl,
			substr( $database, 0, 1),
			substr( $database, 0, 2),
			$database,
			$file
		);
	}
}
