<?php
# Alert the user that this is not a valid entry point to MediaWiki if they try to access the special pages file directly.
if (!defined('MEDIAWIKI')) {
        echo <<<EOT
This file is not meant to be run by itself, but only as a part of MediaWiki
EOT;
        exit( 1 );
}
 
$wgExtensionCredits['specialpage'][] = array(
	'name' => 'SpecialSponsor',
	'author' => 'Aerik Sylvan',
	//'url' => 'http://www.mediawiki.org/wiki/Extension:MyExtension',
	'descriptionmsg' => 'sponsorpage-desc',
	'version' => '0.0.1',
);
 
$dir = dirname(__FILE__) . '/';

$wgExtensionMessagesFiles['SponsorPage'] = $dir . 'Sponsor.i18n.php';


// per-page ad limit
// override possible via WikiFactory
if ( !isset( $wgSponsorAdsLimit ) ) {
	$wgSponsorAdsLimit = 2;
}

//enable the advertisements
$wgAutoloadClasses['Advertisement'] = $dir . 'Advertisements.php';
$wgAutoloadClasses['AdDisplay'] = $dir . 'AdDisplay.php';
$wgHooks['OutputPageBeforeHTML'][] = 'AdDisplay::OutputAdvertisementOutputHook';
$wgHooks['ArticlePurge'][] = 'Advertisement::onArticlePurge';
//$wgHooks['ParserAfterTidy'][] = 'AdDisplay::OutputAdvertisementParserAfterTidy';
//$wgHooks['OutputPageParserOutput'][] = 'AdDisplay::OutputAdvertisementOutputPageParserOutput';
//$wgHooks['ArticleAfterFetchContent'][] = 'AdDisplay::OutputAdvertisementAfterArticleFetch';
 
//Sponsor page 
$wgAutoloadClasses['SpecialSponsor'] = $dir . 'SpecialSponsor_body.php'; 
//$wgSpecialPages['Sponsor'] = 'SpecialSponsor'; 
