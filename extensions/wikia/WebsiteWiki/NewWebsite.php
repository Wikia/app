<?php

if( !defined( 'MEDIAWIKI' ) ) {
    echo "This is MediaWiki extension and cannot be used standalone.\n";
    exit( 1 ) ;
}

$dir = dirname(__FILE__);

/**
 * initialize parse hooks
 */
$wgAutoloadClasses[ 'NewWebsiteJob'   ] = $dir . '/NewWebsiteJob.php';
$wgAutoloadClasses[ 'NewWebsite'      ] = $dir . '/NewWebsite.body.php';

$wgExtensionMessagesFiles[ 'Newsite'  ] = $dir . '/NewWebsite.i18n.php';
$wgExtensionAliasesFiles[ 'Newsite'   ] = $dir . '/NewWebsite.alias.php';

$wgSpecialPages[ "NewWebsite"         ] = 'NewWebsite';
$wgJobClasses[ "newsite"              ] = "NewWebsiteJob";

include( $dir . "/domainhook.php" );
