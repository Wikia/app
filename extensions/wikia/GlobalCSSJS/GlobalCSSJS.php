<?php
$wgHooks['BeforePageDisplay'][] = 'wfGlobalWikiaCSS';
$wgHooks['BeforePageDisplay'][] = 'wfGlobalWikiaJS';

$wgExtensionCredits['other'][] = array(
	'name' => 'Global CSS/JS',
	'author' => '[http://www.wikia.com/wiki/User:Datrio Dariusz Siedlecki]',
	'description' => 'Adds global user CSS and JavaScript to a page, fetched from the Central Wikia.',
  	'version' => "1.0"
  );

/**
 * Adds custom user CSS and JavaScript to a page - Dariusz Siedlecki, datrio@wikia.com
 * @param $out Handle to an OutputPage object (presumably $wgOut).
 */
function wfGlobalWikiaCSS(OutputPage &$out, Skin &$skin ) {
	global $wgDisableGlobalCSS, $wgUser;
	if( !empty( $wgDisableGlobalCSS ) ) {
		return true;
	}

	if (!$wgUser->isAnon()) {
		$userName = str_replace(' ', '_', $wgUser->getName());
		$out->addStyle("http://community.wikia.com/index.php?title=User:{$userName}/global.css&action=raw&ctype=text/css&smaxage=0");
	}

	return true;
}

function wfGlobalWikiaJS(OutputPage &$out, Skin &$skin) {
	global $wgDisableGlobalJS, $wgJsMimeType, $wgUser;
	if( !empty( $wgDisableGlobalJS ) ) {
		return true;
	}

	if (!$wgUser->isAnon()) {
		$userName = str_replace(' ', '_', $wgUser->getName());
		$out->addScript("<script type=\"{$wgJsMimeType}\" src=\"http://community.wikia.com/index.php?title=User:{$userName}/global.js&amp;action=raw&amp;ctype={$wgJsMimeType}\"></script>");
	}

	return true;
}
