<?php
/**
 * WikiFeatures
 *
 * @author Hyun Lim, Owen Davis
 *
 */
$dir = dirname(__FILE__) . '/';
$app = F::app();

$wgExtensionCredits[ 'specialpage' ][ ] = array(
	'name' => 'WikiFeatures',
	'author' => array(
		'Hyun Lim',
		'Owen Davis'
	),
	'descriptionmsg' => 'wikifeatures-desc',
	'url' => 'https://github.com/Wikia/app/tree/dev/extensions/wikia/AuthImage',
);

//classes
$wgAutoloadClasses['WikiFeaturesSpecialController'] = $dir . 'WikiFeaturesSpecialController.class.php';
$app->getDispatcher()->addRouting(
	'WikiFeaturesSpecialController',
	array( 'index' => array( "skin" => array( "monobook", "wikiamobile" ), "method" => "notOasis") )
);

$wgAutoloadClasses['WikiFeaturesHelper'] =  $dir . 'WikiFeaturesHelper.class.php';
$wgAutoloadClasses['WikiaLabsSpecialController'] =  $dir . 'WikiaLabsSpecialController.class.php';

// i18n mapping
$wgExtensionMessagesFiles['WikiFeatures'] = $dir . 'WikiFeatures.i18n.php';
$wgExtensionMessagesFiles['WikiFeaturesAliases'] = $dir . 'WikiFeatures.alias.php' ;

// special pages
$wgSpecialPages['WikiFeatures'] = 'WikiFeaturesSpecialController';
$wgSpecialPages['WikiaLabs'] = 'WikiaLabsSpecialController';

$wgLogTypes[] = 'wikifeatures';
$wgLogNames['wikifeatures'] = 'wikifeatures-log-name';
$wgLogHeaders['wikifeatures'] = 'wikifeatures-log-header';

JSMessages::registerPackage( 'WikiFeatures', array(
	'wikifeatures-deactivate-heading',
	'wikifeatures-deactivate-description',
	'wikifeatures-deactivate-notification',
	'wikifeatures-deactivate-confirm-button',
	'wikifeatures-deactivate-cancel-button'
) );

