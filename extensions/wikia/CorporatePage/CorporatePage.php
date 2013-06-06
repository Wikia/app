<?php
if ( ! defined( 'MEDIAWIKI' ) )
	die( 1 );

$wgExtensionCredits['specialpage'][] = array(
	'name' => 'CorporatePage',
	'author' => 'Tomasz Odrobny',
	'description' => 'global page for wikia.com',
	'version' => '1.0.0',
);

$dir = dirname(__FILE__) . '/';

// this should be set in CommonSettings.php / WikiFactory
if ( !isset( $wgCorporatePageRedirectWiki ) ) {
	$wgCorporatePageRedirectWiki = "http://community.wikia.com/wiki/";
}

$wgAutoloadClasses['CorporatePageHelper']  = $dir . 'CorporatePageHelper.class.php';
$wgHooks['ArticleFromTitle'][] = 'CorporatePageHelper::ArticleFromTitle';