<?php

if( !defined( 'MEDIAWIKI' ) ) {
    echo "This is MediaWiki extension and cannot be used standalone.\n";
    exit( 1 ) ;
}

include('neue_website.php');

$dir = dirname(__FILE__);

/**
 * initialize parse hooks
 */
// $wgHooks['ParserFirstCallInit'][] = 'efNeueWebsiteHooks';
// $wgAutoloadClasses['NeueWebsiteHooks'] = $dir . '/NeueWebsite.hooks.php';

$wgAutoloadClasses['NeueWebsite'] = $dir . '/NeueWebsite.body.php';
$wgSpecialPages['NewWebsite'] = 'NeueWebsite';
$wgExtensionMessagesFiles['Newsite'] = $dir . '/NeueWebsite.i18n.php';
$wgExtensionAliasesFiles['Newsite'] = $dir . '/NeueWebsite.alias.php';

/**
 * register <nws:related /> tag
 */
function efNeueWebsiteHooks( &$parser ) {
	$parser->setHook( "nws:related", array( "NeueWebsiteHooks", "renderRelated" ) );
	return true;
}
