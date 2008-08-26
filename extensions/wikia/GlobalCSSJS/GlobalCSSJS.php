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
	global $wgDisableGlobalCSS;
	if( !empty( $wgDisableGlobalCSS ) ) {
		return true;
	}

	global $wgUser;

	$out = "";

	if (!$wgUser->isAnon())
		$out .= '@import "http://www.wikia.com/index.php?title=User:'. str_replace(" ", "_", $wgUser->mName) .'/global.css&action=raw&ctype=text/css&smaxage=18000";';

	//$out .= '@import "http://www.wikia.com/index.php?title=MediaWiki:Global.css&action=raw&ctype=text/css&smaxage=18000";';

	return true;
}

function wfGlobalWikiaJS( &$out ) {
	global $wgDisableGlobalJS;
	if( !empty( $wgDisableGlobalJS ) ) {
		return true;
	}

	global $wgJsMimeType, $wgUser;

	if (!$wgUser->isAnon())
		$out->addScript('<script language="javascript" type="'. $wgJsMimeType .'" src="http://www.wikia.com/index.php?title=User:'. str_replace(" ", "_", $wgUser->mName) .'/global.js&amp;action=raw&amp;ctype='. $wgJsMimeType .'&amp;dontcountme=s"></script>');

	//$out->addScript('<script language="javascript" type="'. $wgJsMimeType .'" src="http://www.wikia.com/index.php?title=MediaWiki:Global.js&amp;action=raw&amp;ctype='. $wgJsMimeType .'&amp;dontcountme=s"></script>');

	return true;
}
