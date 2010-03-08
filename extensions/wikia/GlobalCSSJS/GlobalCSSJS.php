<?php
$wgHooks['SkinTemplateSetupPageCss'][] = 'wfGlobalWikiaCSS';
$wgHooks['BeforePageDisplay'][] = 'wfGlobalWikiaJS';

$wgExtensionCredits['other'][] = array(
	'name' => 'Global CSS/JS',
	'author' => '[http://www.wikia.com/wiki/User:Datrio Dariusz Siedlecki]',
#	'url' => '',
	'description' => 'Adds global user CSS and JavaScript to a page, fetched from the Central Wikia.',
  	'version' => "1.0"
  );

/**
 * Adds custom user CSS and JavaScript to a page - Dariusz Siedlecki, datrio@wikia.com
 * Usage: $wgHooks['SkinTemplateSetupPageCss'][] = 'wfGlobalWikiaCSS'; $wgHooks['BeforePageDisplay'][] = 'wfGlobalWikiaJS';
 * @param $out Handle to an OutputPage object (presumably $wgOut).
 */

// www.wikia.com/index.php is hardcoded since we cannot read the LocalSettings of our Central Wikia

function wfGlobalWikiaCSS( &$out ) {
	global $wgDisableGlobalCSS, $wgUser;
	if( !empty( $wgDisableGlobalCSS ) ) {
		return true;
	}

	if (!$wgUser->isAnon()) {
		$userName = str_replace(' ', '_', $wgUser->getName());
		$out .= "@import \"http://community.wikia.com/index.php?title=User:{$userName}/global.css&action=raw&ctype=text/css&smaxage=0\";";
	}

	return true;
}

function wfGlobalWikiaJS( &$out ) {
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
