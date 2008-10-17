<?php

/**
 * This extension allows us to insert certain JS code inside <head> section
 *
 * Usage: require_once("$IP/extensions/wikia/WikiaBotJS/WikiaBotJS.php"); in LocalSettings.php
 *
 * @author Maciej Brencz <macbre[at]wikia-inc[dot]com>
 */

$wgExtensionFunctions[] = 'wfWikiaBotJS';
$wgExtensionCredits['other'][] = array(
	'name' => 'WikiaBotJS',
	'author' => 'Maciej Brencz',
	'description' => 'Allow inclusion of JS code inside <head> section.',
	'version' => 0.1
);

// extension setup
function wfWikiaBotJS() {
	global $wgHooks, $wgUser;
	// show JS to limited number of users
	$allowedUsers = array('WikiaBot', 'Macbre', 'Galezewski', 'TOR', 'BartL', 'Adi3ek');
	if (in_array($wgUser->getName(), $allowedUsers)) {
		$wgHooks['BeforePageDisplay'][] = 'wfWikiaBotJSInsert';
	}
}

// insert JS code
function wfWikiaBotJSInsert(&$out, &$skin) {

	$JS = <<<EOD

<script type="text/javascript">/*<![CDATA[*/
// WikiaBotJS
window.onerror = function (msg, src, lno) {
 var url = "";
 url += ((url != "") ? "&" : "") + encodeURIComponent('ael_msg') + "=" + encodeURIComponent(msg);
 url += ((url != "") ? "&" : "") + encodeURIComponent('ael_url') + "=" + encodeURIComponent(src);
 url += ((url != "") ? "&" : "") + encodeURIComponent('ael_lno') + "=" + encodeURIComponent(lno);
 url += '&location=' + encodeURIComponent(document.location);
 url += '&rand=' + Math.random(); // prevent caching
 
 img = new Image();
 img.src = 'http://ws2.poz.wikia-inc.com/~lukasz/ael.php?' + url;

 return false;
}	
/*]]>*/</script>

EOD;

	$out->addHeadItem('wikiaBotJS', $JS);
	return true;
}
