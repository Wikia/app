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
	'description' => 'Extension to allow users to buy sponsorships',
	//'descriptionmsg' => 'myextension-desc',
	'version' => '0.0.1',
);
 
$dir = dirname(__FILE__) . '/';

$wgExtensionMessagesFiles['SponsorPage'] = $dir . 'Sponsor.i18n.php';

//enable the advertisements
include_once($dir.'Advertisements.php');
$wgHooks['OutputPageBeforeHTML'][] = 'AdDisplay::OutputAdvertisementOutputHook';
//$wgHooks['ParserAfterTidy'][] = 'AdDisplay::OutputAdvertisementParserAfterTidy';
//$wgHooks['OutputPageParserOutput'][] = 'AdDisplay::OutputAdvertisementOutputPageParserOutput';
//$wgHooks['ArticleAfterFetchContent'][] = 'AdDisplay::OutputAdvertisementAfterArticleFetch';
 
//Sponsor page 
$wgAutoloadClasses['SpecialSponsor'] = $dir . 'SpecialSponsor_body.php'; 
//$wgExtensionMessagesFiles['SpecialSponsor'] = $dir . 'MyExtension.i18n.php';
//$wgExtensionAliasesFiles['SpecialSponsor'] = $dir . 'MyExtension.alias.php';
$wgSpecialPages['Sponsor'] = 'SpecialSponsor'; 
