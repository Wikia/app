<?php
# Alert the user that this is not a valid entry point to MediaWiki if they try to access the special pages file directly.
if ( !defined( 'MEDIAWIKI' ) ) {
    echo <<<EOT
To install my extension, put the following line in LocalSettings.php:
require_once( "\$IP/extensions/RDFIO/specials/SpecialARC2Admin.php" );
EOT;
    exit( 1 );
}

$wgExtensionCredits['specialpage'][] = array(
	'path' => __FILE__,
	'name' => 'ARC2Admin',
	'author' => 'Samuel Lampa',
	'url' => 'https://www.mediawiki.org/wiki/Extension:SMWRDFConnector',
	'descriptionmsg' => 'rdfio-arc2admin-desc',
	'version' => '0.0.0',
);

$dir = dirname( __FILE__ ) . '/';

$wgAutoloadClasses['ARC2Admin'] = $dir . 'SpecialARC2Admin_body.php'; # Tell MediaWiki to load the extension body.
$wgExtensionMessagesFiles['ARC2Admin'] = $dir . '../RDFIO.i18n.php';
$wgExtensionAliasFiles['ARC2Admin'] = $dir . '../RDFIO.alias.php';
$wgSpecialPages['ARC2Admin'] = 'ARC2Admin'; # Let MediaWiki know about your new special page.
