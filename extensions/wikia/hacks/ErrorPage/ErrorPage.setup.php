<?php
/**
 * @author Sean Colombo
 *
 * Just playing around with more fun error pages.
 */

if ( !defined( 'MEDIAWIKI' ) ) die("This is a MediaWiki extension.");

$wgExtensionMessagesFiles['PhotoPop'] = dirname( __FILE__ ) . '/ErrorPage.i18n.php';
$wgExtensionCredits['specialpage'][] = array(
	'name' => 'Error Page fun',
	'url' => 'http://lyrics.wikia.com',
	'author' => '[http://www.seancolombo.com Sean Colombo] and Lauren Robinette',
	'descriptionmsg' => 'errorpage-desc',
	'version' => '0.1',
);


$dir = dirname(__FILE__) . '/';
$app = F::app();

$app->registerClass('ErrorPageSpecialController', $dir . 'ErrorPageSpecialController.class.php');
$app->registerExtensionMessageFile('ErrorPage', $dir . 'ErrorPage.i18n.php');
