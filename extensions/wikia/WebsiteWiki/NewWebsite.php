<?php

if( !defined( 'MEDIAWIKI' ) ) {
    echo "This is MediaWiki extension and cannot be used standalone.\n";
    exit( 1 ) ;
}

$dir = dirname(__FILE__);

/**
 * initialize parse hooks
 */
$wgAutoloadClasses[ 'NewWebsiteJob'    ] = $dir . '/NewWebsiteJob.php';
$wgAutoloadClasses[ 'SiteThumbnailJob' ] = $dir . '/SiteThumbnailJob.php';
$wgAutoloadClasses[ 'NewWebsite'       ] = $dir . '/NewWebsite.body.php';

$wgExtensionMessagesFiles[ 'Newsite'   ] = $dir . '/NewWebsite.i18n.php';
$wgExtensionAliasesFiles[ 'Newsite'    ] = $dir . '/NewWebsite.alias.php';

$wgSpecialPages[ "NewWebsite"          ] = 'NewWebsite';
$wgJobClasses[ "newsite"               ] = "NewWebsiteJob";
$wgJobClasses[ "SiteThumb"             ] = "SiteThumbnailJob";

include( $dir . "/domainhook.php" );
include( $dir . "/Keywords/Keyword.php" );
