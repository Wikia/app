<?php

/**
 * simple hook for displaying additional informations in Special:Statistics
 *
 * @author Krzysztof Krzyżaniak <eloy@wikia-inc.com>
 */
$wgHooks[ "CustomSpecialStatistics" ][] = "DumpsOnDemads::customSpecialStatistics";

class DumpsOnDemads {

	/**
	 * @access public
	 * @static
	 */
	static public function customSpecialStatistics( &$specialpage, &$text ) {
		global $wgOut;

		$tmpl = new EasyTemplate( dirname( __FILE__ ) . "/templates/" );
		$dod = $tmpl->render( "dod" );
		$text .= $dod;
		Wikia::log( __METHOD__, "info", $dod );
		return true;
	}
}
