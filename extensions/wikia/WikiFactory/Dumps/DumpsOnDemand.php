<?php

/**
 * simple hook for displaying additional informations in Special:Statistics
 *
 * @author Krzysztof Krzyżaniak <eloy@wikia-inc.com>
 */
$wgHooks[ "CustomSpecialStatistics" ][] = "DumpsOnDemand::customSpecialStatistics";
$wgExtensionMessagesFiles[ "DumpsOnDemand" ] =  dirname( __FILE__ ) . '/DumpsOnDemand.i18n.php';

class DumpsOnDemand {

	const BASEURL = "http://wiki-stats.wikia.com";

	/**
	 * @access public
	 * @static
	 */
	static public function customSpecialStatistics( &$specialpage, &$text ) {
		global $wgOut, $wgDBname, $wgContLang;

		wfLoadExtensionMessages( "DumpsOnDemand" );

		/**
		 * read json file with dumps information
		 */

		$tmpl = new EasyTemplate( dirname( __FILE__ ) . "/templates/" );
		$index = array();
		$json = @file_get_contents( self::getUrl( $wgDBname, "index.json" ) );
		if( $json ) {
			$index = (array )Wikia::json_decode( $json );
		}

		$tmpl->set( "curr", array(
			"url" => self::getUrl( $wgDBname, "pages_current.xml.gz" ),
			"timestamp" => !empty( $index["pages_current.xml.gz"]->mwtimestamp )
				? $wgContLang->timeanddate( $index[ "pages_current.xml.gz"]->mwtimestamp )
				: "unknown"
		));

		$tmpl->set( "full", array(
			"url" => self::getUrl( $wgDBname, "pages_full.xml.gz" ),
			"timestamp" => !empty( $index[ "pages_full.xml.gz" ]->mwtimestamp )
				? $wgContLang->timeanddate( $index[ "pages_full.xml.gz" ]->mwtimestamp )
				: "unknown"
		));
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
