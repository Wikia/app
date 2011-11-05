<?php
/**
 * @author Sean Colombo
 * @date 20111011
 *
 * Internationalization / localization code for ApiGate.
 *
 * Currently not really implemented in a stand-alone way.  Just leaning on the MediaWiki
 * implementation for now.
 *
 * TODO: Implement this in a way which allows ApiGate to be standalone but still default to MediaWiki's
 * i18n system if that's available.
 */

// Load the actual string files.
$i18nDir = dirname(__FILE__);
require "$i18nDir/ApiGate_i18n.strings.php";

// For now, just wrap MediaWiki's i18n functions.
function i18n( $msgName, $data=null, $data2=null ) { // TODO: There is a better way to do arbitrary numbers of params, right?
	wfProfileIn( __METHOD__ );

	if( function_exists( 'wfMsg' ) ) {
		if($data === null){
			$retVal = wfMsg( $msgName );
		} else if($data2 === null){
			$retVal = wfMsg( $msgName, $data );
		} else {
			$retVal = wfMsg( $msgName, $data, $data2 );
		}
	} else {
		$retVal = "<ApiGate - $msgName>";
	}

	wfProfileOut( __METHOD__ );
	return $retVal;
} // end i18n()
