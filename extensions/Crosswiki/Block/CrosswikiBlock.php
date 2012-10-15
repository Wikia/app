<?php
if ( !defined( 'MEDIAWIKI' ) ) {
	exit( 1 );
}

$wgExtensionCredits['specialpage'][] = array(
	'path' => __FILE__,
	'name' => 'Crosswiki Blocking',
	'author' => 'VasilievVV',
	'version' => '1.0.1alpha',
	'url' => 'https://www.mediawiki.org/wiki/Extension:Crosswiki_Blocking',
	'descriptionmsg' => 'crosswikiblock-desc',
);

$dir = dirname( __FILE__ ) . '/';
$wgExtensionMessagesFiles['CrosswikiBlock']   = $dir . 'CrosswikiBlock.i18n.php';
$wgAutoloadClasses['SpecialCrosswikiBlock']   = $dir . 'CrosswikiBlock.page.php';
$wgAutoloadClasses['SpecialCrosswikiUnblock'] = $dir . 'CrosswikiBlock.page.php';
$wgAutoloadClasses['CrosswikiBlock']          = $dir . 'CrosswikiBlock.class.php';

$wgAvailableRights[] = 'crosswikiblock';
$wgGroupPermissions['steward']['crosswikiblock'] = true;

$wgSpecialPages['Crosswikiblock'] = 'SpecialCrosswikiBlock';
$wgSpecialPages['Crosswikiunblock'] = 'SpecialCrosswikiUnblock';
