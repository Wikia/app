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
	'author' => array( 'Aerik Sylvan', "[http://community.wikia.com/wiki/User:TOR Lucas 'TOR' Garczewski]" ),
	'description' => 'Extension to allow users to buy sponsorships',
	'version' => '0.0.1',
);
 
$dir = dirname(__FILE__) . '/';

$wgExtensionMessagesFiles['SponsorPage'] = $dir . 'Sponsor.i18n.php';

// pricing array
// override possible via WikiFactory
if ( !isset( $wgSponsorshipPrices ) ) {
	$wgSponsorshipPrices = array(
		'5mo' => array(
			'price' => 5,
			'months' => 1,
			'text' => 'sponsor-price-5mo',
		),
		'45yr' => array(
			'price' => 45,
			'months' => 12,
			'text' => 'sponsor-price-45yr',
		),
	);
}

// per-page ad limit
// override possible via WikiFactory
if ( !isset( $wgSponsorAdsLimit ) ) {
	$wgSponsorAdsLimit = 2;
}

//enable the advertisements
$wgAutoloadClasses['Advertisement'] = $dir . 'Advertisements.php';
$wgAutoloadClasses['AdDisplay'] = $dir . 'AdDisplay.php';
$wgHooks['OutputPageBeforeHTML'][] = 'AdDisplay::OutputAdvertisementOutputHook';
//$wgHooks['ParserAfterTidy'][] = 'AdDisplay::OutputAdvertisementParserAfterTidy';
//$wgHooks['OutputPageParserOutput'][] = 'AdDisplay::OutputAdvertisementOutputPageParserOutput';
//$wgHooks['ArticleAfterFetchContent'][] = 'AdDisplay::OutputAdvertisementAfterArticleFetch';
 
//Sponsor page 
$wgAutoloadClasses['SpecialSponsor'] = $dir . 'SpecialSponsor_body.php'; 
//$wgExtensionMessagesFiles['SpecialSponsor'] = $dir . 'MyExtension.i18n.php';
//$wgExtensionAliasesFiles['SpecialSponsor'] = $dir . 'MyExtension.alias.php';
$wgSpecialPages['Sponsor'] = 'SpecialSponsor'; 
