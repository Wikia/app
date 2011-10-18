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

$wgExceptionHooks[] = array( 'ErrorPage', 'showErrorPage');

$app->registerClass('ErrorPage', $dir . 'ErrorPage.class.php');
$app->registerClass('ErrorPageSpecialController', $dir . 'ErrorPageSpecialController.class.php');
$app->wg->set( 'wgSpecialPages', 'ErrorPageSpecialController', 'ErrorPage' );

$app->registerExtensionMessageFile('ErrorPage', $dir . 'ErrorPage.i18n.php');

