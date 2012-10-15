<?php
# Alert the user that this is not a valid entry point to MediaWiki if they try to access the special pages file directly.
if ( !defined( 'MEDIAWIKI' ) ) {
    echo <<<EOT
To install my extension, put the following line in LocalSettings.php:
require_once( "\$IP/extensions/RDFIO/specials/SpecialRDFImport.php" );
EOT;
    exit( 1 );
}

$wgExtensionCredits['specialpage'][] = array(
	'path' => __FILE__,
	'name' => 'RDFImport',
	'author' => 'Samuel Lampa',
	'url' => 'https://www.mediawiki.org/wiki/Extension:SMWRDFConnector',
	'descriptionmsg' => 'rdfio-rdfimport-desc',
	'version' => '0.0.0',
);

$dir = dirname( __FILE__ ) . '/';

$wgAutoloadClasses['RDFImport'] = $dir . 'SpecialRDFImport_body.php'; # Tell MediaWiki to load the extension body.
$wgExtensionMessagesFiles['RDFImport'] = $dir . '../RDFIO.i18n.php';
$wgExtensionAliasFiles['RDFImport'] = $dir . '../RDFIO.alias.php';
$wgSpecialPages['RDFImport'] = 'RDFImport'; # Let MediaWiki know about your new special page.
