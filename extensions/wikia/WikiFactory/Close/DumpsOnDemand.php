<?php

/**
 * simple hook for displaying additional informations in Special:Statistics
 *
 * @author Krzysztof Krzyżaniak <eloy@wikia-inc.com>
 */
$wgHooks[ "CustomSpecialStatistics" ][] = "DumpsOnDemads::customSpecialStatistics";

$wgExtensionMessagesFiles[ "WikiFactoryDoD" ] =  dirname( __FILE__ ) . '/DumpsOnDemand.i18n.php';

class DumpsOnDemads {

	/**
	 * @access public
	 * @static
	 */
	static public function customSpecialStatistics( &$specialpage, &$text ) {
		global $wgOut;

		wfLoadExtensionMessages( "WikiFactoryDoD" );

		$tmpl = new EasyTemplate( dirname( __FILE__ ) . "/templates/" );
		$text .= $tmpl->render( "dod" );
		return true;
	}
}
