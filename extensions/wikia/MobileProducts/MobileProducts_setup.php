<?php
/**
 *Landing page for Wikia's mobile products
 *
 *@author Federico "Lox" Lucignano <federico@wikia-inc.com>
 */
global $wgExtensionCredits, $wgExtensionFunctions, $wgAutoloadClasses, $wgSpecialPages, $wgExtensionMessagesFiles;

$wgExtensionCredits['specialpage'][] = array(
	'name' => 'Mobile products landing page',
	'description' => 'Landing Page for Wikia\'s mobile products',
	'author' => 'Federico "Lox" Lucignano <federico@wikia-inc.com>',
);

$dir = dirname(__FILE__) . '/';

//classes
$wgAutoloadClasses[ 'SpecialMobileProducts' ] = "{$dir}SpecialMobileProducts.class.php";

//special pages
$wgSpecialPages[ 'MobileProducts' ] = 'SpecialMobileProducts';

//i18n
$wgExtensionMessagesFiles[ 'MobileProducts' ] = "{$dir}MobileProducts.i18n.php";