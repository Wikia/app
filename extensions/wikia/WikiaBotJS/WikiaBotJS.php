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
	'description' => 'Allow inclusion of JS code inside <head> section',
	'version' => 0.2
);

// extension setup
function wfWikiaBotJS() {
	global $wgHooks, $wgUser;
	// show JS to limited number of users
	$allowedUsers = array('WikiaBot', 'Macbre', 'Galezewski', 'TOR', 'BartL', 'Adi3ek');
	if (in_array($wgUser->getName(), $allowedUsers)) {
		$wgHooks['SkinTemplateOutputPageBeforeExec'][] = 'wfWikiaBotJSInsert';
	}
}

// insert JS code
function wfWikiaBotJSInsert(&$skin, &$tpl) {

	$JS = <<<EOD
		<script type="text/javascript">/*<![CDATA[*/
			// WikiaBotJS
			window.onerror = function (msg, src, lno) {
				url = 'ael_msg=' + encodeURIComponent(msg);
				url += '&ael_url=' + encodeURIComponent(src);
				url += '&ael_lno=' + encodeURIComponent(lno);
				url += '&location=' + encodeURIComponent(document.location);

				// try to add wgUserName
				if (typeof wgUserName != 'undefined') {
					url+= '&user=' + encodeURIComponent(wgUserName);
				}

				// prevent caching
				url += '&rand=' + Math.random();

				img = new Image();
				img.src = 'http://ws2.poz.wikia-inc.com/~lukasz/ael.php?' + url;

				if (typeof console != "undefined") {
					console.log('WikiaBotJS: error "' + msg + '" @ ' + src  + ':' + lno  + ' reported to our QA team');
				}

				return false;
			}
			if (typeof console != "undefined") console.log('WikiaBotJS: ok');
		/*]]>*/</script>

EOD;

	$tpl->data['headlinks'] .= $JS;
	return true;
}
