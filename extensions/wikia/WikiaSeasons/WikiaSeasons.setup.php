<?php

/**
 * Setup for WikiaSeasons - seasonal changes in Oasis Skin
 * @author Andrzej 'nAndy' Łukaszewski
 * @author Marcin Maciejewski
 * @author Sebastian Marzjan
 */

$app = F::app();
$dir = dirname(__FILE__) . '/';

$wgExtensionCredits[ 'other' ][ ] = array(
	'name' => 'WikiaSeasons',
	'author' => array(
		'Andrzej \'nAndy\' Łukaszewski',
		'Marcin Maciejewski',
		'Sebastian Marzjan'
	),
	'descriptionmsg' => 'wikiaseasons-desc',
	'url' => 'https://github.com/Wikia/app/tree/dev/extensions/wikia/WikiaSeasons',
);

/**
 * classes
 */
$wgAutoloadClasses['WikiaSeasonsController'] =  $dir . 'WikiaSeasonsController.class.php';

/**
 * hooks
 */
//$app->registerHook();

/**
 * i18n mapping
 */
$app->registerExtensionMessageFile( 'WikiaSeasons', $dir . 'WikiaSeasons.i18n.php' );
