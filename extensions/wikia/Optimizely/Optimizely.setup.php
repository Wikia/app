<?php
/**
 * Optimizely setup
 *
 * @author Damian Jóźwiak
 * @author Bartosz "V." Bentkowski
 *
 */
$dir = dirname( __FILE__ ) . '/';

$wgExtensionCredits[ 'other' ][] = array(
	'name'           => 'Optimizely',
	'author'         => [ 'Damian Jóźwiak', 'Bartosz "V." Bentkowski' ],
	'descriptionmsg' => 'optimizely-desc',
	'version'        => 1,
	'url'            => 'https://github.com/Wikia/app/tree/dev/extensions/wikia/Optimizely'
);

//i18n

// classes
$wgAutoloadClasses[ 'Optimizely' ] =  $dir . 'Optimizely.class.php';
$wgAutoloadClasses[ 'OptimizelyController' ] = $dir . '/OptimizelyController.class.php';

// hooks
$wgHooks[ 'WikiaSkinTopScripts' ][] = 'Optimizely::onWikiaSkinTopScripts';
$wgHooks[ 'OasisSkinAssetGroupsBlocking' ][] = 'Optimizely::onOasisSkinAssetGroupsBlocking';
