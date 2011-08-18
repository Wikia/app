<?php
/**
 * @author Sean Colombo
 *
 */

if ( !defined( 'MEDIAWIKI' ) ) die("This is a MediaWiki extension.");

$wgExtensionMessagesFiles['FoggyFoto'] = dirname( __FILE__ ) . '/SpecialFoggyFoto.i18n.php';
$wgExtensionCredits['specialpage'][] = array(
	'name' => 'FoggyFoto',
	'url' => 'http://www.wikia.com/Mobile', // TODO: Update with a link to a landing page for the SPECIFIC mobile app once that is available (eg: /Mobile/FoggyFoto)
	'author' => '[http://www.seancolombo.com Sean Colombo]',
	'descriptionmsg' => 'foggyfoto-desc',
	'version' => '0.1',
);


$dir = dirname(__FILE__) . '/';
$app = F::app();

$app->registerClass('FoggyFotoController', $dir . 'FoggyFotoController.class.php');
$app->registerExtensionMessageFile('FoggyFoto', $dir . 'FoggyFoto.i18n.php');

// register messages package for JS
F::build('JSMessages')->registerPackage('FoggyFoto', array(
	'foggyfoto-progress-numbers',
));
