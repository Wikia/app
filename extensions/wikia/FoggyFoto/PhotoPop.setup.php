<?php
/**
 * @author Sean Colombo
 *
 * This extension is the server-side of the Photo Pop mobile app.  Most of the gameplay is handled
 * by this extension (which will be wrapped in a web-view on the device).
 */

if ( !defined( 'MEDIAWIKI' ) ) die("This is a MediaWiki extension.");

$wgExtensionMessagesFiles['PhotoPop'] = dirname( __FILE__ ) . '/SpecialFoggyFoto.i18n.php';
$wgExtensionCredits['specialpage'][] = array(
	'name' => 'Photo Pop',
	'url' => 'http://www.wikia.com/Mobile', // TODO: Update with a link to a landing page for the SPECIFIC mobile app once that is available (eg: /Mobile/PhotoPop)
	'author' => '[http://www.seancolombo.com Sean Colombo]',
	'descriptionmsg' => 'photopop-desc',
	'version' => '0.1',
);


$dir = dirname(__FILE__) . '/';
$app = F::app();

$app->registerClass('PhotoPopController', $dir . 'PhotoPopController.class.php');
$app->registerExtensionMessageFile('PhotoPop', $dir . 'PhotoPop.i18n.php');

// register messages package for JS
F::build('JSMessages')->registerPackage('PhotoPop', array(
	'photopop-progress-numbers',
));
