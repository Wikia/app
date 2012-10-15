<?php 
# Alert the user that this is not a valid entry point to MediaWiki if they try to access the special pages file directly.
if (!defined('MEDIAWIKI')) {
        echo <<<EOT
To install this extension put the following line in LocalSettings.php:
require_once( "\$IP/extensions/OracleTextSearch/OracleTextSearch.php" );
EOT;
        exit( 1 );
}
$wgExtensionCredits['other'][] = array(
	'path' => __FILE__,
	'name' => 'OracleTextSearch',
	'author' => 'freakolowsky [Jure Kajzer]',
	'url' => 'https://www.mediawiki.org/wiki/Extension:OracleTextSearch',
	'descriptionmsg' => 'oracletextsearch-desc',
	'version' => '1.0.0',
);

$dir = dirname(__FILE__) . '/';
$wgExtensionMessagesFiles['OracleTextSearch'] = $dir . 'OracleTextSearch.i18n.php';
$wgAutoloadClasses['SearchOracleText'] = $dir . 'SearchOracleText.php';
$wgHooks['UploadComplete'][] = 'SearchOracleText::onUploadCompleteHook';

/**
 * extension defaults
 */

/**
 * index on http (false requires you to setup credentials wallet in oracle)
 */
$wgExIndexOnHTTP = true;
/**
 * default set of mime types Oracle Text will index (set according to DB version)
 */
$wgExIndexMIMETypes = array(	'application/pdf', 
								'application/xml', 
								'text/xml', 
								'application/msword' , 
								'text/plain', 
								'text/html' );


